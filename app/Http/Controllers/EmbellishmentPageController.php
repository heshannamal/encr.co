<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmbellishmentType;

class EmbellishmentPageController extends Controller
{
    public function embellishmentPage(){

        $embellishmentTypes = EmbellishmentType::where('active', 1)->orderBy('embellishment_name')->get();

        return view('pages/common_embellishment_page/index', ['embellishmentTypes'=>$embellishmentTypes]);
    }
}
