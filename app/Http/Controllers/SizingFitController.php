<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Size;
use App\Models\SizingFit;

class SizingFitController extends Controller
{
    public function sizing_fit(){

        $adultSizes = Size::where('active', 1)
             ->where('size_name', 'like', 'Adult%')
             ->get();

        $boySizes = Size::where('active', 1)
             ->where('size_name', 'like', 'Youth%')
             ->get();

        $menSocksSizes = Size::where('active', 1)
             ->where('size_type', 2)
             ->where('size_name', 'not like', 'Extra%')
             ->get();

        $adultMenSizes = SizingFit::where('size_type', 'Adult Men')
                                ->get();

        $adultWomenSizes = SizingFit::where('size_type', 'Adult Women')
                                ->get();

        $youthBoySizes = SizingFit::where('size_type', 'Youth Boy')
                                ->get();

        $youthGirlSizes = SizingFit::where('size_type', 'Youth Girl')
                                ->get();

        $menSocks = SizingFit::where('size_type', 'Men Socks')
                                ->get();

        $womenSocks = SizingFit::where('size_type', 'Women Socks')
                                ->get();
// dd($menSocks);

    return view('pages.masters.sizing_fit.index',['adultSizes' => $adultSizes, 'boySizes' => $boySizes, 'menSocksSizes'=>$menSocksSizes, 'adultMenSizes'=>$adultMenSizes,
                                                'youthBoySizes'=>$youthBoySizes, 'adultWomenSizes'=>$adultWomenSizes, 'youthGirlSizes'=>$youthGirlSizes,
                                                'menSocks'=>$menSocks, 'womenSocks'=>$womenSocks]);
    }

    public function customerSizing(){

        $adultSizes = Size::where('active', 1)
             ->where('size_name', 'like', 'Adult%')
             ->get();

        $boySizes = Size::where('active', 1)
             ->where('size_name', 'like', 'Youth%')
             ->get();

        $menSocksSizes = Size::where('active', 1)
             ->where('size_type', 2)
             ->where('size_name', 'not like', 'Extra%')
             ->get();

        $adultMenSizes = SizingFit::where('size_type', 'Adult Men')
                                ->get();

        $adultWomenSizes = SizingFit::where('size_type', 'Adult Women')
                                ->get();

        $youthBoySizes = SizingFit::where('size_type', 'Youth Boy')
                                ->get();

        $youthGirlSizes = SizingFit::where('size_type', 'Youth Girl')
                                ->get();

        $menSocks = SizingFit::where('size_type', 'Men Socks')
                                ->get();

        $womenSocks = SizingFit::where('size_type', 'Women Socks')
                                ->get();
// dd($menSocks);

    return view('pages.masters.sizing_fit.customer_index',['adultSizes' => $adultSizes, 'boySizes' => $boySizes, 'menSocksSizes'=>$menSocksSizes, 'adultMenSizes'=>$adultMenSizes,
                                                'youthBoySizes'=>$youthBoySizes, 'adultWomenSizes'=>$adultWomenSizes, 'youthGirlSizes'=>$youthGirlSizes,
                                                'menSocks'=>$menSocks, 'womenSocks'=>$womenSocks]);
    }

    public function saveMenSizes(Request $request) {
        $sizeData = $request->input('sizeData');

        foreach ($sizeData as $data) {
            $sizingFit = SizingFit::where('size_type', 'Adult Men')
                                  ->where('size_id', $data['size_id'])
                                  ->where('type', $data['type'])
                                  ->first();

            if ($sizingFit) {
                // Update existing sizingFit
                $sizingFit->size_id = $data['size_id'];
                $sizingFit->type = $data['type'];
                $sizingFit->size_type = 'Adult Men';
                $sizingFit->size_from = $this->formatSizeFromData($data);
                $sizingFit->size_to = $this->formatSizeToData($data);
                $sizingFit->save();
            } else {
                // Create a new sizingFit
                $sizingFit = new SizingFit();
                $sizingFit->size_id = $data['size_id'];
                $sizingFit->type = $data['type'];
                $sizingFit->size_type = 'Adult Men';
                $sizingFit->size_from = $this->formatSizeFromData($data);
                $sizingFit->size_to = $this->formatSizeToData($data);
                $sizingFit->save();
            }
        }

        return response()->json(['sizeData' => $sizeData]);
    }

    public function saveWomenSizes(Request $request) {
        $sizeData = $request->input('sizeData');

        foreach ($sizeData as $data) {
            $sizingFit = SizingFit::where('size_type', 'Adult Women')
                                  ->where('size_id', $data['size_id'])
                                  ->where('type', $data['type'])
                                  ->first();

            if ($sizingFit) {
                // Update existing sizingFit
                $sizingFit->size_id = $data['size_id'];
                $sizingFit->type = $data['type'];
                $sizingFit->size_type = 'Adult Women';
                $sizingFit->size_from = $this->formatSizeFromData($data);
                $sizingFit->size_to = $this->formatSizeToData($data);
                $sizingFit->save();
            } else {
                // Create a new sizingFit
                $sizingFit = new SizingFit();
                $sizingFit->size_id = $data['size_id'];
                $sizingFit->type = $data['type'];
                $sizingFit->size_type = 'Adult Women';
                $sizingFit->size_from = $this->formatSizeFromData($data);
                $sizingFit->size_to = $this->formatSizeToData($data);
                $sizingFit->save();
            }
        }

        return response()->json(['sizeData' => $sizeData]);
    }

    public function saveBoySizes(Request $request) {
        $sizeData = $request->input('sizeDataBoy');

        foreach ($sizeData as $data) {
            $sizingFit = SizingFit::where('size_type', 'Youth Boy')
                                  ->where('size_id', $data['size_id'])
                                  ->where('type', $data['type'])
                                  ->first();

            if ($sizingFit) {
                // Update existing sizingFit
                $sizingFit->size_id = $data['size_id'];
                $sizingFit->type = $data['type'];
                $sizingFit->size_type = 'Youth Boy';
                $sizingFit->size_from = $this->formatSizeFromData($data);
                $sizingFit->size_to = $this->formatSizeToData($data);
                $sizingFit->save();
            } else {
                // Create a new sizingFit
                $sizingFit = new SizingFit();
                $sizingFit->size_id = $data['size_id'];
                $sizingFit->type = $data['type'];
                $sizingFit->size_type = 'Youth Boy';
                $sizingFit->size_from = $this->formatSizeFromData($data);
                $sizingFit->size_to = $this->formatSizeToData($data);
                $sizingFit->save();
            }
        }

        return response()->json(['sizeData' => $sizeData]);
    }

    public function saveGirlSizes(Request $request) {
        $sizeData = $request->input('sizeDataGirl');

        foreach ($sizeData as $data) {
            $sizingFit = SizingFit::where('size_type', 'Youth Girl')
                                  ->where('size_id', $data['size_id'])
                                  ->where('type', $data['type'])
                                  ->first();

            if ($sizingFit) {
                // Update existing sizingFit
                $sizingFit->size_id = $data['size_id'];
                $sizingFit->type = $data['type'];
                $sizingFit->size_type = 'Youth Girl';
                $sizingFit->size_from = $this->formatSizeFromData($data);
                $sizingFit->size_to = $this->formatSizeToData($data);
                $sizingFit->save();
            } else {
                // Create a new sizingFit
                $sizingFit = new SizingFit();
                $sizingFit->size_id = $data['size_id'];
                $sizingFit->type = $data['type'];
                $sizingFit->size_type = 'Youth Girl';
                $sizingFit->size_from = $this->formatSizeFromData($data);
                $sizingFit->size_to = $this->formatSizeToData($data);
                $sizingFit->save();
            }
        }

        return response()->json(['sizeData' => $sizeData]);
    }

    public function saveMenShoeSizes(Request $request) {
        $sizeData = $request->input('sizeDataMenShoe');

        foreach ($sizeData as $data) {
            $sizingFit = SizingFit::where('size_type', 'Men Socks')
                                  ->where('size_id', $data['size_id'])
                                  ->where('type', $data['type'])
                                  ->first();

            if ($sizingFit) {
                // Update existing sizingFit
                $sizingFit->size_id = $data['size_id'];
                $sizingFit->type = $data['type'];
                $sizingFit->size_type = 'Men Socks';
                $sizingFit->size_from = $this->formatSizeFromData($data);
                $sizingFit->size_to = $this->formatSizeToData($data);
                $sizingFit->save();
            } else {
                // Create a new sizingFit
                $sizingFit = new SizingFit();
                $sizingFit->size_id = $data['size_id'];
                $sizingFit->type = $data['type'];
                $sizingFit->size_type = 'Men Socks';
                $sizingFit->size_from = $this->formatSizeFromData($data);
                $sizingFit->size_to = $this->formatSizeToData($data);
                $sizingFit->save();
            }
        }

        return response()->json(['sizeData' => $sizeData]);
    }

    public function saveWomenShoeSizes(Request $request) {
        $sizeData = $request->input('sizeDataWomenShoe');

        foreach ($sizeData as $data) {
            $sizingFit = SizingFit::where('size_type', 'Women Socks')
                                  ->where('size_id', $data['size_id'])
                                  ->where('type', $data['type'])
                                  ->first();

            if ($sizingFit) {
                // Update existing sizingFit
                $sizingFit->size_id = $data['size_id'];
                $sizingFit->type = $data['type'];
                $sizingFit->size_type = 'Women Socks';
                $sizingFit->size_from = $this->formatSizeFromData($data);
                $sizingFit->size_to = $this->formatSizeToData($data);
                $sizingFit->save();
            } else {
                // Create a new sizingFit
                $sizingFit = new SizingFit();
                $sizingFit->size_id = $data['size_id'];
                $sizingFit->type = $data['type'];
                $sizingFit->size_type = 'Women Socks';
                $sizingFit->size_from = $this->formatSizeFromData($data);
                $sizingFit->size_to = $this->formatSizeToData($data);
                $sizingFit->save();
            }
        }

        return response()->json(['sizeData' => $sizeData]);
    }

    public function formatSizeFromData($data) {
        if ($data['type'] === 'height') {
            $fromFeet = $data['from_feet'] ?? null;
            $fromInch = $data['from_inch'] ?? null;

            // Return null instead of an empty string if no data
            if ($fromFeet === null && $fromInch === null) {
                return null;
            }

            return "{$fromFeet}'{$fromInch}\"";
        } else {
            return $data['from'] ?? null;
        }
    }

    public function formatSizeToData($data) {
        if ($data['type'] === 'height') {
            $toFeet = $data['to_feet'] ?? null;
            $toInch = $data['to_inch'] ?? null;

            // Return null instead of an empty string if no data
            if ($toFeet === null && $toInch === null) {
                return null;
            }

            return "{$toFeet}'{$toInch}\"";
        } else {
            return $data['to'] ?? null;
        }
    }


}
