<?php

namespace App\Services;

/**
 * Hand-rolled raw PDF builder (no packages).
 * Renders a bordered table with columns positioned by exact x-coordinates,
 * and supports clickable "View" links per row via PDF Link annotations.
 */
class SimplePdfBuilder
{
    protected string $orderNo = '';
    protected string $orgName = '';

    /** @var array<int, array{label:string,key:string,width:int}> */
    protected array $columns = [];

    /** @var array<int, array<string,string>> each row: [key => text, ...] plus optional 'tracking_link_url' */
    protected array $rows = [];

    protected int $pageWidth = 595;
    protected int $pageHeight = 842;
    protected int $marginLeft = 40;
    protected int $marginRight = 40;

    protected int $headerRowHeight = 20;
    protected int $dataRowHeight = 18;
    protected int $rowsPerPage = 28;

    public function setHeader(string $orderNo, string $orgName): static
    {
        $this->orderNo = $orderNo;
        $this->orgName = $orgName;
        return $this;
    }

    /**
     * @param array<int, array{label:string,key:string,width:int}> $columns
     */
    public function setColumns(array $columns): static
    {
        $this->columns = $columns;
        return $this;
    }

    /**
     * @param array<string,string> $row keys must match column 'key's.
     *                                  Optional 'tracking_link_url' makes the
     *                                  matching column (key === 'tracking_link') clickable.
     */
    public function addRow(array $row): static
    {
        $this->rows[] = $row;
        return $this;
    }

    protected function escapeText(string $text): string
    {
        return str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], $text);
    }

    protected function truncate(string $text, int $colWidth): string
    {
        // Rough average glyph width for 8pt Helvetica
        $maxChars = max(4, (int) floor($colWidth / 4.3));
        if (mb_strlen($text) > $maxChars) {
            return mb_substr($text, 0, $maxChars - 1) . '…';
        }
        return $text;
    }

    protected function columnXPositions(): array
    {
        $x = $this->marginLeft;
        $positions = [];
        foreach ($this->columns as $col) {
            $positions[] = $x;
            $x += $col['width'];
        }
        $positions[] = $x; // right edge of last column
        return $positions;
    }

    /**
     * Builds the content stream + link annotations for a single page.
     *
     * @return array{0:string, 1:array<int, array{url:string, rect:array{0:float,1:float,2:float,3:float}}>}
     */
    protected function buildPage(array $pageRows, int $pageNum, int $totalPages): array
    {
        $xPositions = $this->columnXPositions();
        $tableRight = end($xPositions);

        $text = [];   // queued text draw ops: [x, y, size, str, color]
        $lines = [];  // queued line draw ops: [x1, y1, x2, y2]
        $links = [];  // link annotations for this page

        $y = 800;

        // Order / org header (repeated on every page for clarity)
        $text[] = [$this->marginLeft, $y, 12, 'Order #' . $this->orderNo, 'black'];
        $y -= 16;
        $text[] = [$this->marginLeft, $y, 11, $this->orgName, 'gray'];
        $y -= 22;

        if ($totalPages > 1) {
            $text[] = [$tableRight - 60, 800, 9, "Page {$pageNum}/{$totalPages}", 'gray'];
        }

        $tableTop = $y;

        // Header row background line (top border)
        $lines[] = [$this->marginLeft, $tableTop, $tableRight, $tableTop];

        // Column header labels
        foreach ($this->columns as $i => $col) {
            $text[] = [$xPositions[$i] + 4, $tableTop - 14, 9, strtoupper($col['label']), 'black'];
        }

        $headerBottom = $tableTop - $this->headerRowHeight;
        $lines[] = [$this->marginLeft, $headerBottom, $tableRight, $headerBottom];

        // Vertical column separators (drawn full height once we know table bottom)
        $rowTop = $headerBottom;

        foreach ($pageRows as $row) {
            $rowBottom = $rowTop - $this->dataRowHeight;

            foreach ($this->columns as $i => $col) {
                $cellX = $xPositions[$i] + 4;
                $cellY = $rowTop - 13;
                $key = $col['key'];

                if ($key === 'tracking_link') {
                    $url = $row['tracking_link_url'] ?? '';
                    if (!empty($url)) {
                        $label = 'View';
                        $text[] = [$cellX, $cellY, 9, $label, 'blue'];

                        // Approximate rect around the "View" text for the clickable area
                        $links[] = [
                            'url'  => $url,
                            'rect' => [$cellX - 1, $cellY - 2, $cellX + 26, $cellY + 9],
                        ];
                    } else {
                        $text[] = [$cellX, $cellY, 9, '-', 'gray'];
                    }
                } else {
                    $value = $this->truncate((string) ($row[$key] ?? '-'), $col['width']);
                    $text[] = [$cellX, $cellY, 9, $value, 'black'];
                }
            }

            $lines[] = [$this->marginLeft, $rowBottom, $tableRight, $rowBottom];
            $rowTop = $rowBottom;
        }

        $tableBottom = $rowTop;

        // Vertical lines spanning the full table height on this page
        foreach ($xPositions as $x) {
            $lines[] = [$x, $tableTop, $x, $tableBottom];
        }

        // Build the content stream
        $stream = "0.6 w\n"; // line width for grid

        foreach ($lines as [$x1, $y1, $x2, $y2]) {
            $stream .= "{$x1} {$y1} m {$x2} {$y2} l S\n";
        }

        $stream .= "BT\n";
        foreach ($text as [$x, $yPos, $size, $str, $color]) {
            $rgb = match ($color) {
                'gray' => '0.42 0.45 0.5',
                'blue' => '0.05 0.4 0.75',
                default => '0.07 0.09 0.15',
            };
            $stream .= "{$rgb} rg\n";
            $stream .= "/F1 {$size} Tf\n";
            $stream .= "1 0 0 1 {$x} {$yPos} Tm\n";
            $stream .= "(" . $this->escapeText($str) . ") Tj\n";
        }
        $stream .= "0 0 0 rg\nET";

        return [$stream, $links];
    }

    public function output(): string
    {
        $pages = array_chunk($this->rows, $this->rowsPerPage);
        if (empty($pages)) {
            $pages = [[]];
        }
        $totalPages = count($pages);

        $objects = [];
        $objects[1] = "<< /Type /Catalog /Pages 2 0 R >>";

        $pageObjIds = [];
        $contentObjIds = [];
        $annotObjIds = []; // pageIndex => [objId, ...]
        $nextId = 3;

        foreach ($pages as $i => $pageRows) {
            $pageObjIds[$i] = $nextId++;
            $contentObjIds[$i] = $nextId++;
        }
        $fontObjId = $nextId++;

        // Pre-build page content + links, reserving annotation object ids as we go
        $pageContents = [];
        $pageLinks = [];
        foreach ($pages as $i => $pageRows) {
            [$stream, $links] = $this->buildPage($pageRows, $i + 1, $totalPages);
            $pageContents[$i] = $stream;

            $ids = [];
            foreach ($links as $link) {
                $id = $nextId++;
                $ids[] = $id;
                $annotObjIds[$i][] = $id;
                $objects[$id] = sprintf(
                    "<< /Type /Annot /Subtype /Link /Rect [%.2f %.2f %.2f %.2f] /Border [0 0 0] "
                        . "/A << /Type /Action /S /URI /URI (%s) >> >>",
                    $link['rect'][0],
                    $link['rect'][1],
                    $link['rect'][2],
                    $link['rect'][3],
                    $this->escapeText($link['url'])
                );
            }
            $pageLinks[$i] = $ids;
        }

        $kids = implode(' ', array_map(fn($id) => "{$id} 0 R", $pageObjIds));
        $objects[2] = "<< /Type /Pages /Kids [{$kids}] /Count " . count($pages) . " >>";

        foreach ($pages as $i => $pageRows) {
            $annotsStr = '';
            if (!empty($pageLinks[$i])) {
                $refs = implode(' ', array_map(fn($id) => "{$id} 0 R", $pageLinks[$i]));
                $annotsStr = " /Annots [{$refs}]";
            }

            $objects[$pageObjIds[$i]] =
                "<< /Type /Page /Parent 2 0 R /MediaBox [0 0 {$this->pageWidth} {$this->pageHeight}] "
                . "/Resources << /Font << /F1 {$fontObjId} 0 R >> >> "
                . "/Contents {$contentObjIds[$i]} 0 R{$annotsStr} >>";

            $content = $pageContents[$i];
            $objects[$contentObjIds[$i]] =
                "<< /Length " . strlen($content) . " >>\nstream\n{$content}\nendstream";
        }

        $objects[$fontObjId] = "<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>";

        ksort($objects);
        $pdf = "%PDF-1.4\n";
        $offsets = [];

        foreach ($objects as $id => $body) {
            $offsets[$id] = strlen($pdf);
            $pdf .= "{$id} 0 obj\n{$body}\nendobj\n";
        }

        $maxId = max(array_keys($objects));
        $xrefStart = strlen($pdf);
        $pdf .= "xref\n0 " . ($maxId + 1) . "\n";
        $pdf .= "0000000000 65535 f \n";
        for ($id = 1; $id <= $maxId; $id++) {
            $offset = $offsets[$id] ?? 0;
            $free = isset($offsets[$id]) ? 'n' : 'f';
            $pdf .= sprintf("%010d 00000 %s \n", $offset, $free);
        }

        $pdf .= "trailer\n<< /Size " . ($maxId + 1) . " /Root 1 0 R >>\n";
        $pdf .= "startxref\n{$xrefStart}\n%%EOF";

        return $pdf;
    }
}
