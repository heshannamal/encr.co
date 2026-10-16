<?php

namespace App\Http\Controllers;

use App\Models\PdtProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class PdtController extends Controller
{
    public function index()
    {
        $pdtProducts = PdtProduct::with('product')
            ->orderByDesc('id')
            ->get();

        $usedProductIds = $pdtProducts
            ->pluck('product_id')
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values()
            ->all();

        $products = Product::select('id', 'product_name', 'show_in_catalog_name')
            ->where('active', 1)
            ->orderBy('product_name')
            ->get();

        return view('pages.pdt.index', compact(
            'pdtProducts',
            'products',
            'usedProductIds'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => [
                'required',
                'integer',
                'exists:products,id',
                Rule::unique('pdt_products', 'product_id'),
            ],
            'modal_path' => ['required', 'file', 'max:153600'],
            'dxf_path' => ['required', 'file', 'max:51200'],
            'layout_parts' => ['required', 'string'],
        ], [
            'product_id.unique' => 'This product has already been added to PDT.',
        ]);

        $this->validateFileExtension(
            $request->file('modal_path'),
            ['glb', 'gltf'],
            'modal_path',
            'The 3D model must be a GLB or GLTF file.'
        );

        $this->validateFileExtension(
            $request->file('dxf_path'),
            ['dxf'],
            'dxf_path',
            'The drawing file must be a DXF file.'
        );

        $layoutParts = $this->validatedLayoutParts($request);

        $modelPath = null;
        $dxfPath = null;

        try {
            $modelPath = $this->storePublicFile(
                $request->file('modal_path'),
                'pdt/models',
                'model'
            );

            $dxfPath = $this->storePublicFile(
                $request->file('dxf_path'),
                'pdt/dxf',
                'dxf'
            );

            PdtProduct::create([
                'product_id' => $validated['product_id'],
                'modal_path' => $modelPath,
                'dxf_path' => $dxfPath,
                'active' => 1,
                'layout_parts' => $layoutParts,
            ]);
        } catch (\Throwable $exception) {
            $this->deletePublicFile($modelPath);
            $this->deletePublicFile($dxfPath);

            throw $exception;
        }

        return redirect()
            ->back()
            ->with('success', 'PDT Product added successfully.');
    }

    public function update(Request $request)
    {
        $pdt = PdtProduct::findOrFail($request->id);

        $validated = $request->validate([
            'id' => ['required', 'integer', 'exists:pdt_products,id'],
            'product_id' => [
                'required',
                'integer',
                'exists:products,id',
                Rule::unique('pdt_products', 'product_id')->ignore($pdt->id),
            ],
            'active' => ['required', Rule::in([0, 1, '0', '1'])],
            'modal_path' => ['nullable', 'file', 'max:153600'],
            'dxf_path' => ['nullable', 'file', 'max:51200'],
            'layout_parts' => ['required', 'string'],
        ], [
            'product_id.unique' => 'This product is already assigned to another PDT record.',
        ]);

        if ($request->hasFile('modal_path')) {
            $this->validateFileExtension(
                $request->file('modal_path'),
                ['glb', 'gltf'],
                'modal_path',
                'The 3D model must be a GLB or GLTF file.'
            );
        }

        if ($request->hasFile('dxf_path')) {
            $this->validateFileExtension(
                $request->file('dxf_path'),
                ['dxf'],
                'dxf_path',
                'The drawing file must be a DXF file.'
            );
        }

        $layoutParts = $this->validatedLayoutParts($request);

        $oldModelPath = $pdt->modal_path;
        $oldDxfPath = $pdt->dxf_path;
        $newModelPath = null;
        $newDxfPath = null;

        try {
            if ($request->hasFile('modal_path')) {
                $newModelPath = $this->storePublicFile(
                    $request->file('modal_path'),
                    'pdt/models',
                    'model'
                );

                $pdt->modal_path = $newModelPath;
            }

            if ($request->hasFile('dxf_path')) {
                $newDxfPath = $this->storePublicFile(
                    $request->file('dxf_path'),
                    'pdt/dxf',
                    'dxf'
                );

                $pdt->dxf_path = $newDxfPath;
            }

            $pdt->product_id = $validated['product_id'];
            $pdt->active = (int) $validated['active'];
            $pdt->layout_parts = $layoutParts;
            $pdt->save();

            if ($newModelPath) {
                $this->deletePublicFile($oldModelPath);
            }

            if ($newDxfPath) {
                $this->deletePublicFile($oldDxfPath);
            }
        } catch (\Throwable $exception) {
            $this->deletePublicFile($newModelPath);
            $this->deletePublicFile($newDxfPath);

            throw $exception;
        }

        return redirect()
            ->back()
            ->with('success', 'PDT Product updated successfully.');
    }

    public function Product_index()
    {
        $pdtProducts = PdtProduct::with('product')
            ->where('active', 1)
            ->orderByDesc('id')
            ->get();

        return view('products.index', compact('pdtProducts'));
    }

    private function validatedLayoutParts(Request $request): array
    {
        $raw = $request->input('layout_parts', '[]');
        $parts = json_decode($raw, true);

        if (json_last_error() !== JSON_ERROR_NONE || !is_array($parts)) {
            throw ValidationException::withMessages([
                'layout_parts' => 'Invalid product parts data.',
            ]);
        }

        if (count($parts) === 0) {
            throw ValidationException::withMessages([
                'layout_parts' => 'Add at least one product part.',
            ]);
        }

        $normalized = [];
        $seenKeys = [];

        foreach ($parts as $index => $part) {
            $row = $index + 1;
            $key = trim((string) ($part['key'] ?? ''));
            $label = trim((string) ($part['label'] ?? ''));
            $order = (int) ($part['order'] ?? $row);
            $meshValue = $part['mesh'] ?? ($part['meshes'] ?? '');

            if ($key === '') {
                throw ValidationException::withMessages([
                    'layout_parts' => "Part row {$row}: Part Key is required.",
                ]);
            }

            if (in_array($key, $seenKeys, true)) {
                throw ValidationException::withMessages([
                    'layout_parts' => "Part Key '{$key}' is selected more than once.",
                ]);
            }

            if (is_array($meshValue)) {
                $meshValue = $meshValue[0] ?? '';
            }

            $mesh = trim((string) $meshValue);

            if ($mesh === '') {
                throw ValidationException::withMessages([
                    'layout_parts' => "Part '{$key}': select one GLB mesh.",
                ]);
            }

            $seenKeys[] = $key;

            $normalized[] = [
                'key' => $key,
                'label' => $label !== '' ? $label : $key,
                'order' => $order > 0 ? $order : $row,
                'meshes' => [$mesh],
                'flip_to' => trim((string) ($part['flip_to'] ?? '')),
                'flip_mirror' => in_array(
                    $part['flip_mirror'] ?? false,
                    [true, 1, '1', 'true', 'on'],
                    true
                ),
            ];
        }

        foreach ($normalized as $index => $part) {
            if ($part['flip_to'] === '') {
                unset($normalized[$index]['flip_to'], $normalized[$index]['flip_mirror']);
                continue;
            }

            if ($part['flip_to'] === $part['key']) {
                throw ValidationException::withMessages([
                    'layout_parts' => "Part '{$part['key']}' cannot flip to itself.",
                ]);
            }

            if (!in_array($part['flip_to'], $seenKeys, true)) {
                throw ValidationException::withMessages([
                    'layout_parts' => "Flip target '{$part['flip_to']}' is not a valid DXF part.",
                ]);
            }
        }

        usort($normalized, fn ($a, $b) => $a['order'] <=> $b['order']);

        return array_values($normalized);
    }

    private function validateFileExtension(
        $file,
        array $allowedExtensions,
        string $field,
        string $message
    ): void {
        $extension = strtolower((string) $file->getClientOriginalExtension());

        if (!in_array($extension, $allowedExtensions, true)) {
            throw ValidationException::withMessages([
                $field => $message,
            ]);
        }
    }

    private function storePublicFile($file, string $directory, string $suffix): string
    {
        $absoluteDirectory = public_path($directory);

        if (!File::isDirectory($absoluteDirectory)) {
            File::makeDirectory($absoluteDirectory, 0775, true);
        }

        $extension = strtolower((string) $file->getClientOriginalExtension());
        $fileName = Str::uuid() . "_{$suffix}.{$extension}";

        $file->move($absoluteDirectory, $fileName);

        return "{$directory}/{$fileName}";
    }

    private function deletePublicFile(?string $path): void
    {
        if (!$path) {
            return;
        }

        $absolutePath = public_path(ltrim($path, '/'));

        if (File::exists($absolutePath)) {
            File::delete($absolutePath);
        }
    }
}
