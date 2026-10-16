<?php

namespace App\Http\Controllers;

use App\Models\Size;
use App\Models\Sport;
use App\Models\Product;
use App\Models\SubProduct;
use App\Models\ProductSport;
use App\Models\MainCategory;
use App\Models\ProductMainCategory;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Models\ProductFabric;
use App\Models\ProductCategory;
use App\Models\ProductCategoryList;
use App\Models\ProductAttribute;
use App\Models\SubProductColor;
use App\Models\ColorMaster;
use App\Models\Fabric;
use App\Models\Attribute;
use App\Models\ProductTaglineList;
use App\Models\ProductTagline;
use App\Models\EmbellishmentType;
use App\Models\MasterFit;
use App\Models\ProductFit;
use App\Models\ThemeSetting;
use App\Models\Gender;
use App\Models\SubProductImage;
use App\Http\Controllers\Controller;
use App\Models\ProductEmbellishmentType;
use App\Models\SubProductEmbellishmentOptions;

class CustomerProductCatlogController extends Controller
{
    public function upload_product_images(){

        $products = Product::get();
        foreach($products as $product){
            $product->mockup_img_1 = "/Product Master/PRO-".$product->id."/mockup/front.jpg";
            $product->mockup_img_2 = "/Product Master/PRO-".$product->id."/mockup/side.jpg";
            $product->mockup_img_3 = "/Product Master/PRO-".$product->id."/mockup/back.jpg";
            $product->save();

            echo("<br>".$product->id." updated succesfully");
        }

        $sub_products = SubProduct::get();
        foreach($sub_products as $sub_product){
            $sub_product->mockup_img_1 = "/Product Master/PRO-".$sub_product->parent_product_id."/".$sub_product->sub_product_no."/mockup/front.jpg";
            $sub_product->mockup_img_2 = "/Product Master/PRO-".$sub_product->parent_product_id."/".$sub_product->sub_product_no."/mockup/side.jpg";
            $sub_product->mockup_img_3 = "/Product Master/PRO-".$sub_product->parent_product_id."/".$sub_product->sub_product_no."/mockup/back.jpg";
            $sub_product->save();

            echo("<br>".$sub_product->id." updated succesfully");
        }
    }

    public function index()
    {
        $main_categories = MainCategory::orderBy('id')->get();
        $sports = Sport::where('active', 1)
            ->orderBy('sport_name')
            ->get();

        $productCategories = ProductCategory::where('active', 1)->orderBy('product_category_name')->get();

        $themeActions = ThemeSetting::where('active', 1)->where('id', 1)->first();

        $genders = Gender::get();

        if($themeActions->action == 1) {
            return view('pages.customer_product_catlog.product_catlog.index', ['main_categories'=>$main_categories, 'sports'=>$sports, 'productCategories'=>$productCategories, 'genders'=>$genders]);
        }else if($themeActions->action == 2){
            return view('pages.customer_product_catlog.product_catlog.index_theme_2', ['main_categories'=>$main_categories, 'sports'=>$sports, 'productCategories'=>$productCategories, 'genders'=>$genders]);
        } else {
            return view('pages.customer_product_catlog.product_catlog.default_index', ['main_categories'=>$main_categories, 'sports'=>$sports, 'productCategories'=>$productCategories]);
        }
    }

    public function productFilter(Request $request)
    {
        $selectedCategory = $request->input('selectedCategory');
        $selectedGender = $request->input('selectedGender');
        $selectedSport = $request->input('selectedSport');
        $selectedStyle = $request->input('selectedStyle');

        $query1 = Product::with('productCategories')
            ->where('show_in_catalog', 1)
            ->where('active', '!=', 3);

        $query2 = SubProduct::with('productDetails.productCategories')
            ->where('active', '!=', 3)
            ->where('show_in_catalog', 1);

        // -------------------------
        // CATEGORY FILTER
        // -------------------------
        if ($selectedCategory != '5') {

            $main_category_records = ProductMainCategory::whereIn('main_category_id', [$selectedCategory])->whereNull('deleted_at')
                ->pluck('product_id')
                ->unique()
                ->toArray();

            $query1->whereIn('id', $main_category_records);

            $query2->whereHas('productDetails', function ($q) use ($main_category_records) {
                $q->whereIn('id', $main_category_records);
            });
        }

        // -------------------------
        // STYLE → FORCE GENDER
        // -------------------------
        if (in_array($selectedStyle, ['17', '9', '1'])) {
            $selectedGender = 'All';
        }

        // -------------------------
        // GENDER FILTER
        // -------------------------
        if ($selectedGender != 'All') {
            $query1->where(function ($q) use ($selectedGender) {
                $q->where('gender', $selectedGender)
                ->orWhere('gender', 'Uni');
            });

            $query2->whereHas('productDetails', function ($q) use ($selectedGender) {
                $q->where(function ($q2) use ($selectedGender) {
                    $q2->where('gender', $selectedGender)
                    ->orWhere('gender', 'Uni');
                });
            });
        }

        // -------------------------
        // SPORT FILTER
        // -------------------------
        if ($selectedSport != '18') {

            $sport_records = ProductSport::whereIn('sport_id', [$selectedSport, 18])->whereNull('deleted_at')
                ->pluck('product_id')
                ->unique()
                ->toArray();

            $query1->whereIn('id', $sport_records);

            $query2->whereHas('productDetails', function ($q) use ($sport_records) {
                $q->whereIn('id', $sport_records);
            });
        }

        // -------------------------
        // STYLE FILTER
        // -------------------------
        if ($selectedStyle !== '0') {

            $style_records = ProductCategoryList::where('product_category_id', $selectedStyle)->whereNull('deleted_at')
                ->pluck('product_id')
                ->unique()
                ->toArray();

            $query1->whereIn('id', $style_records);

            $query2->whereHas('productDetails', function ($q) use ($style_records) {
                $q->whereIn('id', $style_records);
            });
        }

        // -------------------------
        // EXECUTE
        // -------------------------
        $matchingData = $query1->inRandomOrder()->get();
        $sub_products = $query2->inRandomOrder()->get();

        // -------------------------
        // STATIC DATA
        // -------------------------
        $mainCategory = MainCategory::orderBy('category_name')->get();
        $sports = Sport::orderBy('sport_name')->where('active', 1)->get();

        // $categoryOrder = [20, 8, 11, 21, 9, 2, 7, 1, 17, 5, 3];
        $categoryOrder = [21, 8, 20, 11, 9, 2, 7, 1, 17, 5, 3];

        $productCategories = ProductCategory::where('active', 1)
            ->orderBy('product_category_name')
            ->get()
            ->sortBy(function ($cat) use ($categoryOrder) {
                $index = array_search($cat->id, $categoryOrder);
                return $index === false ? PHP_INT_MAX : $index;
            })->values();

        $main_categories = $selectedCategory ? optional(MainCategory::find($selectedCategory))->category_name : null;

        $productStyles = ($selectedStyle == 0)
            ? 'All'
            : ($selectedStyle ? optional(ProductCategory::find($selectedStyle))->product_category_name : null);

        $sportName = $selectedSport ? optional(Sport::find($selectedSport))->sport_name : null;

        $alldata = [];

        // Products
        foreach ($matchingData as $data) {

            $studio_images = ProductImage::where('active', 1)
                ->where('product_id', $data->id)
                ->whereIn('image_type', [5, 2]) // 👈 meka
                ->get();

            $relatedFabric = $this->getRelatedFabrics($data->id, 'product');

            // Product level embellishments (non-deleted)
            $productEmbellishmentIDs = ProductEmbellishmentType::where('product_id', $data->id)
                ->whereNull('deleted_at')
                ->pluck('embellishment_type_id')
                ->toArray();

            $productEmbellishmentNames = EmbellishmentType::whereIn('id', $productEmbellishmentIDs)
                ->pluck('embellishment_name')
                ->toArray();

            // SubProduct level string embellishments
            $subProductEmbellishments = SubProduct::where('parent_product_id', $data->id)
                ->where('active', 1)
                ->pluck('type_of_embellishment')
                ->toArray();

            $allEmbellishments = array_merge($productEmbellishmentNames, $subProductEmbellishments);

            $relatedEmbellishments = $this->getRelatedEmbellishments($allEmbellishments);

            $alldata[] = [
                'type' => 'product', // ✅ manually set
                'category' => $data->productCategories->pluck('product_category_id')->toArray(),
                'data' => $data,
                'studio_images' => $studio_images,
                'relatedFabric' => $relatedFabric,
                'relatedEmbellishments' => $relatedEmbellishments
            ];
        }

        $sub_products = $query2->inRandomOrder()->get();

        // Sub-products
        foreach ($sub_products as $data) {

            $studio_images = SubProductImage::where('active', 1)
                ->where('sub_product_no', $data->sub_product_no)
                ->whereIn('image_type', [5, 2]) // 👈 meka
                ->get();

            $relatedFabric = $this->getRelatedFabrics($data->id, 'sub_product');

            // SubProduct level table embellishments
            $subProductEmbellishmentIDs = SubProductEmbellishmentOptions::where('sub_product_id', $data->id)
                // ->whereNull('deleted_at')
                ->pluck('embellishment_option')
                ->toArray();

            $subProductEmbellishmentNames = EmbellishmentType::whereIn('id', $subProductEmbellishmentIDs)
                ->pluck('embellishment_name')
                ->toArray();

            // Also include string-type embellishments from SubProduct record itself
            $subProductEmbellishments = SubProduct::where('id', $data->id)
                ->where('active', 1)
                ->pluck('type_of_embellishment')
                ->toArray();

            $allEmbellishments = array_merge($subProductEmbellishmentNames, $subProductEmbellishments);

            $relatedEmbellishments = $this->getRelatedEmbellishments($allEmbellishments);

            $alldata[] = [
                'type' => 'sub_product', // ✅ manually set
                'category' => $data->productDetails->productCategories->pluck('product_category_id')->toArray(),
                'data' => $data,
                'studio_images' => $studio_images,
                'relatedFabric' => $relatedFabric,
                'relatedEmbellishments' => $relatedEmbellishments
            ];
        }

        shuffle($alldata);

        return view('pages.customer_product_catlog.product_catlog.product_filter_index', [
            'matchingData' => $alldata,
            'selectedGender' => $selectedGender,
            'sportName' => $sportName,
            'productStyles' => $productStyles,
            'main_categories' => $main_categories,
            'selectedCategory' => $selectedCategory,
            'selectedMainCategory' => $selectedCategory,
            'selectedSport' => $selectedSport,
            'selectedStyle' => $selectedStyle,
            'mainCategory' => $mainCategory,
            'sports' => $sports,
            'productCategories' => $productCategories
        ]);
    }


    public function productSearch(Request $request)
    {
        $searchValue = trim(strtolower($request->input('search')));

        /*
        |--------------------------------------------------------------------------
        | FILTER DETECTION (redirect if match)
        |--------------------------------------------------------------------------
        */
        $searchValue = strtolower($searchValue);

        $selectedCategory = MainCategory::where(strtolower('category_name'), 'like', $searchValue)->first()->id ?? 5;
        $selectedSport = Sport::where(strtolower('sport_name'), 'like', $searchValue)->first()->id ?? 18;
        $selectedStyle = ProductCategory::where(strtolower('product_category_name'), 'like', $searchValue)->first()->id ?? 0;
        $selectedGender = $searchValue == 'men' || $searchValue == 'women' || $searchValue == 'uni' ? $searchValue : 'All';

        if($selectedCategory != 5 || $selectedSport != 18 || $selectedStyle != 0 || $selectedGender != 'All'){
            return redirect()->route('product_filter1', [
                'selectedCategory' => $selectedCategory,
                'selectedSport' => $selectedSport,
                'selectedStyle' => $selectedStyle,
                'selectedGender' => $selectedGender
            ]);
        }

        $regex = '[[:<:]]' . $searchValue . '[[:>:]]';

        /*
        |--------------------------------------------------------------------------
        | PRODUCTS
        |--------------------------------------------------------------------------
        */
        $products = Product::with(['productCategories'])
            ->where('show_in_catalog', 1)
            ->where('active', '!=', 3)
            ->where(function ($query) use ($searchValue, $regex) {

                $query->whereRaw('LOWER(gender) = ?', [$searchValue])

                    ->orWhereRaw('LOWER(product_no) REGEXP ?', [$regex])

                    ->orWhere(function ($q) use ($regex) {
                        $q->whereNotNull('show_in_catalog_name')
                        ->whereRaw('LOWER(show_in_catalog_name) REGEXP ?', [$regex]);
                    })

                    ->orWhere(function ($q) use ($regex) {
                        $q->whereNull('show_in_catalog_name')
                        ->whereRaw('LOWER(product_name) REGEXP ?', [$regex]);
                    });
            })
            ->get();

        /*
        |--------------------------------------------------------------------------
        | SUB PRODUCTS
        |--------------------------------------------------------------------------
        */
        $subProducts = SubProduct::with(['productDetails.productCategories'])
            ->where('active', '!=', 3)
            ->where('show_in_catalog', 1)
            ->where(function ($query) use ($searchValue, $regex) {

                $query->whereHas('productDetails', function ($q) use ($searchValue) {
                    $q->whereRaw('LOWER(gender) = ?', [$searchValue]);
                })

                ->orWhereRaw('LOWER(sub_product_no) REGEXP ?', [$regex])

                ->orWhere(function ($q) use ($regex) {
                    $q->whereNotNull('show_in_catalog_name')
                    ->whereRaw('LOWER(show_in_catalog_name) REGEXP ?', [$regex]);
                })

                ->orWhere(function ($q) use ($regex) {
                    $q->whereNull('show_in_catalog_name')
                    ->whereRaw('LOWER(product_name) REGEXP ?', [$regex]);
                });
            })
            ->get();

        /*
        |--------------------------------------------------------------------------
        | EXTRA MATCHES (SPORT / CATEGORY / STYLE)
        |--------------------------------------------------------------------------
        */
        $sportsMatch = Product::join('product_sports', 'products.id', '=', 'product_sports.product_id')
            ->join('sports', 'product_sports.sport_id', '=', 'sports.id')
            ->whereRaw('LOWER(sports.sport_name) LIKE ?', ["%{$searchValue}%"])
            ->whereNull('product_sports.deleted_at')
            ->where('products.show_in_catalog', 1)
            ->where('products.active', '!=', 3)
            ->select('products.*')
            ->get();

        $categoryMatch = Product::join('product_main_categories', 'products.id', '=', 'product_main_categories.product_id')
            ->join('main_categories', 'product_main_categories.main_category_id', '=', 'main_categories.id')
            ->whereRaw('LOWER(main_categories.category_name) LIKE ?', ["%{$searchValue}%"])
            ->whereNull('product_main_categories.deleted_at')
            ->where('products.show_in_catalog', 1)
            ->where('products.active', '!=', 3)
            ->select('products.*')
            ->get();

        $styleMatch = Product::join('product_category_lists', 'products.id', '=', 'product_category_lists.product_id')
            ->join('product_categories', 'product_category_lists.product_category_id', '=', 'product_categories.id')
            ->whereRaw('LOWER(product_categories.product_category_name) LIKE ?', ["%{$searchValue}%"])
            ->whereNull('product_category_lists.deleted_at')
            ->where('products.show_in_catalog', 1)
            ->where('products.active', '!=', 3)
            ->select('products.*')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | MERGE + UNIQUE
        |--------------------------------------------------------------------------
        */
        $products = $products
            ->merge($sportsMatch)
            ->merge($categoryMatch)
            ->merge($styleMatch)
            ->unique('id')
            ->values();

        $subProducts = $subProducts->unique('id')->values();

        $alldata = [];

        // Products
        foreach ($products as $data) {

            $studio_images = ProductImage::where('active', 1)
                ->where('product_id', $data->id)
                ->whereIn('image_type', [5, 2]) // 👈 meka
                ->get();

            $relatedFabric = $this->getRelatedFabrics($data->id, 'product');

            // Product level embellishments (non-deleted)
            $productEmbellishmentIDs = ProductEmbellishmentType::where('product_id', $data->id)
                ->whereNull('deleted_at')
                ->pluck('embellishment_type_id')
                ->toArray();

            $productEmbellishmentNames = EmbellishmentType::whereIn('id', $productEmbellishmentIDs)
                ->pluck('embellishment_name')
                ->toArray();

            // SubProduct level string embellishments
            $subProductEmbellishments = SubProduct::where('parent_product_id', $data->id)
                ->where('active', 1)
                ->pluck('type_of_embellishment')
                ->toArray();

            $allEmbellishments = array_merge($productEmbellishmentNames, $subProductEmbellishments);

            $relatedEmbellishments = $this->getRelatedEmbellishments($allEmbellishments);

            $alldata[] = [
                'type' => 'product', // ✅ manually set
                'category' => $data->productCategories->pluck('product_category_id')->toArray(),
                'data' => $data,
                'studio_images' => $studio_images,
                'relatedFabric' => $relatedFabric,
                'relatedEmbellishments' => $relatedEmbellishments
            ];
        }

        // Sub-products
        foreach ($subProducts as $data) {

            $studio_images = SubProductImage::where('active', 1)
                ->where('sub_product_no', $data->sub_product_no)
                ->whereIn('image_type', [5, 2]) // 👈 meka
                ->get();

            $relatedFabric = $this->getRelatedFabrics($data->id, 'sub_product');

            // SubProduct level table embellishments
            $subProductEmbellishmentIDs = SubProductEmbellishmentOptions::where('sub_product_id', $data->id)
                // ->whereNull('deleted_at')
                ->pluck('embellishment_option')
                ->toArray();

            $subProductEmbellishmentNames = EmbellishmentType::whereIn('id', $subProductEmbellishmentIDs)
                ->pluck('embellishment_name')
                ->toArray();

            // Also include string-type embellishments from SubProduct record itself
            $subProductEmbellishments = SubProduct::where('id', $data->id)
                ->where('active', 1)
                ->pluck('type_of_embellishment')
                ->toArray();

            $allEmbellishments = array_merge($subProductEmbellishmentNames, $subProductEmbellishments);

            $relatedEmbellishments = $this->getRelatedEmbellishments($allEmbellishments);

            $alldata[] = [
                'type' => 'sub_product', // ✅ manually set
                'category' => $data->productDetails->productCategories->pluck('product_category_id')->toArray(),
                'data' => $data,
                'studio_images' => $studio_images,
                'relatedFabric' => $relatedFabric,
                'relatedEmbellishments' => $relatedEmbellishments
            ];
        }

        shuffle($alldata);

        /*
        |--------------------------------------------------------------------------
        | FILTER DATA (UI REQUIREMENT)
        |--------------------------------------------------------------------------
        */
        $mainCategory = MainCategory::orderBy('category_name')->get();
        $sports = Sport::where('active', 1)->orderBy('sport_name')->get();
        $productCategories = ProductCategory::where('active', 1)->orderBy('product_category_name')->get();

        /*
        |--------------------------------------------------------------------------
        | FINAL RETURN ✅
        |--------------------------------------------------------------------------
        */
        return view('pages.customer_product_catlog.product_catlog.product_filter_index', [
            'matchingData' => $alldata,
            'searchValue' => $searchValue,
            'mainCategory' => $mainCategory,
            'sports' => $sports,
            'productCategories' => $productCategories
        ]);
    }


    public function productDetails($id, Request $request){

        $searchValue = $request->query('search', null);
        $selectedGender = $request->query('selectedGender', null);
        $selectedCategory = $request->query('selectedCategory', null);
        $selectedSport = $request->query('selectedSport', null);
        $selectedStyle = $request->query('selectedStyle', null);

        $type = $request->query('type', null);

        if ($type == 'product') {

            $product = Product::find($id);
            $product->size_chart = $product->size_chart ? 'assets'.$product->size_chart : null;

            $fabricIDs = SubProduct::where('parent_product_id', $id)
            ->where('active', 1)
            ->pluck('standard_fabric')
            ->toArray();

            $lifestyleImages = ProductImage::where('product_id', $id)->where('image_type', 1)->pluck('image_link');
            $Images3D = ProductImage::where('product_id', $id)->where('image_type', 2)->pluck('image_link');

            $images_3d = ProductImage::where('active', 1)
                    ->where('product_id', $id)
                    ->where('image_type', 1)
                    ->get();

            $lifeStyle_images = ProductImage::where('active', 1)
                    ->where('product_id', $id)
                    ->where('image_type', 2)
                    ->get();

            $closeUp_images = ProductImage::where('active', 1)
                    ->where('product_id', $id)
                    ->where('image_type', 3)
                    ->get();

            $branding_images = ProductImage::where('active', 1)
                    ->where('product_id', $id)
                    ->where('image_type', 4)
                    ->get();
            $studio_images = ProductImage::where('active', 1)
                    ->where('product_id', $id)
                    ->where('image_type', 5)
                    ->get();

            $EmbellishmentsFiltered = ProductEmbellishmentType::where('product_id' , $id)->pluck('embellishment_type_id')->toArray();
            $embellishmentProducts = SubProduct::where('parent_product_id', $id)
            ->where('active', 1)
            ->pluck('type_of_embellishment')
            ->toArray();

            $productType = 'product';

        }elseif($type == 'sub_product'){

            $sub_product_found = SubProduct::find($id);
            $product = Product::find($sub_product_found->parent_product_id);

            $product->product_no = $sub_product_found->sub_product_no;
            $product->show_in_catalog_name = $sub_product_found->show_in_catalog_name ?? NULL;
            $product->product_name = $sub_product_found->product_name;
            $product->pattern_code = $sub_product_found->pattern_code;
            $product->default_price = $sub_product_found->default_price;
            $product->standard_fabric = $sub_product_found->standard_fabric;
            $product->description = $sub_product_found->description;
            $product->who_we_made_this_for = $sub_product_found->who_we_made_this_for;
            $product->product_features = $sub_product_found->product_features;
            $product->notes = $sub_product_found->notes;
            $product->mockup_img_1 = $sub_product_found->mockup_img_1;
            $product->mockup_img_2 = $sub_product_found->mockup_img_2;
            $product->mockup_img_3 = $sub_product_found->mockup_img_3;
            $product->size_chart = $sub_product_found->size_chart ?? ($product->size_chart ? 'assets'.$product->size_chart : null);

            $fabricIDs = SubProduct::where('id', $id)
            ->where('active', 1)
            ->pluck('standard_fabric')
            ->toArray();

            $lifestyleImages = SubProductImage::where('sub_product_no', $sub_product_found->sub_product_no)->where('image_type', 1)->pluck('image_link');
            $Images3D = SubProductImage::where('sub_product_no', $sub_product_found->sub_product_no)->where('image_type', 2)->pluck('image_link');

            $images_3d = SubProductImage::where('active', 1)
                    ->where('sub_product_no', $sub_product_found->sub_product_no)
                    ->where('image_type', 1)
                    ->get();

            $lifeStyle_images = SubProductImage::where('active', 1)
                    ->where('sub_product_no', $sub_product_found->sub_product_no)
                    ->where('image_type', 2)
                    ->get();

            $closeUp_images = SubProductImage::where('active', 1)
                    ->where('sub_product_no', $sub_product_found->sub_product_no)
                    ->where('image_type', 3)
                    ->get();

            $branding_images = SubProductImage::where('active', 1)
                    ->where('sub_product_no', $sub_product_found->sub_product_no)
                    ->where('image_type', 4)
                    ->get();
            $studio_images = SubProductImage::where('active', 1)
                    ->where('sub_product_no', $sub_product_found->sub_product_no)
                    ->where('image_type', 5)
                    ->get();

            $EmbellishmentsFiltered = SubProduct::where('id' , $id)->where('active' , 1)->pluck('type_of_embellishment')->toArray();
            $EmbellishmentsFiltered = SubProductEmbellishmentOptions::where('sub_product_id' , $id)->pluck('embellishment_option')->toArray();
            $embellishmentProducts = SubProduct::where('id', $id)
            ->where('active', 1)
            ->pluck('type_of_embellishment')
            ->toArray();

            $productType = 'sub_product';

        }

        $fabricIDs = array_unique($fabricIDs);

        if (count($fabricIDs) > 0) {
            $productFabric = implode(' | ', $fabricIDs);
        } else {
            $productFabric = "No fabrics";
        }

        if (!$product) {
            return redirect()->route('error.page');
        }
        $product_main_cat = ProductMainCategory::where('product_id' , $product->id)->first();
        $product->main_category_id = $product_main_cat->main_category_id;

        $categoryID = $product->product_category_id;

        $randomProducts = Product::inRandomOrder()
            ->where('product_category_id', $categoryID)
            ->where('show_in_catalog', 1)
            ->take(4)
            ->get();

        $size = Size::select('id', 'size_name', 'size_type')
            ->where('size_name', 'not like', 'Extra%')
            ->get();

        $mainCategory = MainCategory::select('id', 'category_name')->get();


        if(count($EmbellishmentsFiltered) > 0){
            $productEmblishment = $EmbellishmentsFiltered[0];
        }else{
            $productEmblishment = "No available";
        }

        $productAttributes = ProductAttribute::where('product_id', $product->id)
            ->whereIn('attribute_id', [3, 4, 5])
            ->whereNull('deleted_at')
            ->with('attributes')
            ->get();

        $selectedMainCategory = MainCategory::where('id', $selectedCategory)->get();

        if ($productAttributes->isNotEmpty()) {
            $attributeNames = [];
            foreach ($productAttributes as $productAttribute) {
                $attributeNames[] = $productAttribute->attributes->pluck('attribute_name')->implode(' | ');
            }
            $displayedAttributes = implode(' | ', $attributeNames);
        } else {
            $displayedAttributes = "";
        }

        $mainCategories = MainCategory::orderBy('category_name')->get();

        $sports = Sport::orderBy('sport_name')->where('active', 1)->get();

        $productCategories = ProductCategory::orderBy('product_category_name')->where('active', 1)->get();

        $productColors = SubProductColor::where('id', $product->id)->get();

        $masterColors = ColorMaster::get();

        $relatedColors = [];

        foreach ($productColors as $productColor) {
            foreach ($masterColors as $masterColor) {
                if ($productColor->color_master_id == $masterColor->id) {
                    $relatedColors[] = $masterColor;
                }
            }
        }

        if ($type == 'sub_product') {
            $fabricProducts = SubProduct::where('id', $id)
            ->where('active', 1)
            ->select('id', 'fabric_id')
            ->get();
        }else{
            $fabricProducts = SubProduct::where('parent_product_id', $id)
            ->where('active', 1)
            ->select('id', 'fabric_id')
            ->get();
        }

        $fabricDetails = Fabric::get();

        $relatedFabric = [];

        foreach ($fabricProducts as $fabricProduct) {
            foreach ($fabricDetails as $fabricDetail) {
                if ($fabricProduct->fabric_id == $fabricDetail->id) {
                    $relatedFabric[] = [
                        'subproduct_id' => $fabricProduct->id,
                        'fabric_detail' => $fabricDetail,
                    ];
                }
            }
        }

        $attributeProducts = ProductAttribute::where('product_id', $id)
            ->where('deleted_at', null)
            ->get();

        $attributes = Attribute::get();

        $relatedAttributes = [];

        foreach ($attributeProducts as $attributeProduct) {
            foreach ($attributes as $attribute) {
                if ($attributeProduct->attribute_id == $attribute->id &&
                    $attribute->attribute_name != 'Player #' &&
                    $attribute->attribute_name != 'Player Name') {
                    $relatedAttributes[] = $attribute;
                }
            }
        }

        $embellishmentTypes = EmbellishmentType::get();

        $relatedEmbellishments = [];

        foreach ($embellishmentProducts as $embellishmentProduct) {
            $separatedEmbellishments = explode(' / ', $embellishmentProduct);

            foreach ($separatedEmbellishments as $embellishment) {
                foreach ($embellishmentTypes as $embellishmentType) {
                    if (trim($embellishment) == $embellishmentType->embellishment_name) {
                        if (!in_array($embellishmentType, $relatedEmbellishments)) {
                            $relatedEmbellishments[] = $embellishmentType;
                        }
                    }
                }
            }
        }

       $productTaglineLists = ProductTaglineList::where('product_id', $product->id)->get();

       $masterTaglines = ProductTagline::get();

        $relatedTaglines = [];

        foreach ($productTaglineLists as $productTaglineList) {
            foreach ($masterTaglines as $masterTagline) {
                if ($productTaglineList->tagline_id == $masterTagline->id) {
                    $relatedTaglines[] = $masterTagline;
                }
            }
        }

        $productFits = ProductFit::where('product_id', $product->id)->get();

        $masterFits = MasterFit::get();

        $relatedFits = [];

        foreach ($productFits as $productFit) {
            foreach ($masterFits as $masterFit) {
                if ($productFit->fit_id == $masterFit->id) {
                    $relatedFits[] = $masterFit;
                }
            }
        }

        if ($searchValue !== null) {
            return view('pages.customer_product_catlog.product_catlog.product_view', [
                'searchValue'=> $searchValue,
                'product' => $product,
                'lifestyleImages' => $lifestyleImages,
                'Images3D' => $Images3D,
                'randomProducts' => $randomProducts,
                'size' => $size,
                'mainCategory' => $mainCategory,
                'productFabric'=> $productFabric,
                'selectedSport'=>$selectedSport,
                'productEmblishment'=>$productEmblishment,
                'productAttributes'=>$productAttributes,
                'displayedAttributes'=>$displayedAttributes,
                'mainCategories'=>$mainCategories,
                'selectedCategory'=>$selectedCategory,
                'selectedGender' =>$selectedGender,
                'sports'=>$sports,
                'selectedStyle'=>$selectedStyle,
                'productCategories'=>$productCategories,
                'relatedColors'=>$relatedColors,
                'relatedFabric'=>$relatedFabric,
                'relatedAttributes'=>$relatedAttributes,
                'relatedEmbellishments'=>$relatedEmbellishments,
                'images_3d'=>$images_3d,
                'lifeStyle_images'=>$lifeStyle_images,
                'studio_images'=>$studio_images,
                'relatedTaglines'=>$relatedTaglines,
                'relatedFits'=>$relatedFits,
                'closeUp_images'=>$closeUp_images,
                'branding_images'=>$branding_images,
                'productType'=>$productType
            ]);
        } else {
            return view('pages.customer_product_catlog.product_catlog.product_view', [
                'product' => $product,
                'lifestyleImages' => $lifestyleImages,
                'Images3D' => $Images3D,
                'randomProducts' => $randomProducts,
                'size' => $size,
                'mainCategory' => $mainCategory,
                'productFabric'=> $productFabric,
                'selectedGender' =>$selectedGender,
                'selectedCategory'=>$selectedCategory,
                'selectedSport'=>$selectedSport,
                'selectedStyle'=>$selectedStyle,
                'productEmblishment'=>$productEmblishment,
                'productAttributes'=>$productAttributes,
                'displayedAttributes'=>$displayedAttributes,
                'selectedMainCategory'=>$selectedMainCategory,
                'mainCategories'=>$mainCategories,
                'sports'=>$sports,
                'productCategories'=>$productCategories,
                'relatedColors'=>$relatedColors,
                'relatedFabric'=>$relatedFabric,
                'relatedAttributes'=>$relatedAttributes,
                'relatedEmbellishments'=>$relatedEmbellishments,
                'images_3d'=>$images_3d,
                'lifeStyle_images'=>$lifeStyle_images,
                'studio_images'=>$studio_images,
                'relatedTaglines'=>$relatedTaglines,
                'relatedFits'=>$relatedFits,
                'closeUp_images'=>$closeUp_images,
                'branding_images'=>$branding_images,
                'productType'=>$productType
            ]);
        }
    }

    public function filterEmbellishment(Request $request)
    {
        $product_id = $request->input('product_id');
        $productType = $request->input('productType');

        $productColors = [];
        $relatedEmbellishments = [];
        $embellishmentTypes = EmbellishmentType::all()->pluck('embellishment_name')->toArray();
        $masterColors = ColorMaster::get();

        if (!$product_id || !$productType) {
            return response()->json(['error' => 'Product ID and Product Type are required.'], 400);
        }
        if($productType == 'sub_product'){
            $product = SubProduct::where('id', $product_id)->first();
            $productColors = SubProductColor::where('sub_product_no', $product->sub_product_no)->get();
            $embellishmentProducts = SubProductEmbellishmentOptions::where('sub_product_id', $product_id)->pluck('embellishment_option')->toArray();
        }else{
            $product = Product::where('id', $product_id)->first();
            $productColors = SubProductColor::whereHas('subProduct.productDetails', function ($query) use ($product_id) {
                $query->where('id', $product_id);
            })->get();
            $embellishmentProducts = ProductEmbellishmentType::where('product_id', $product_id)->pluck('embellishment_type_id')->toArray();

        }
        $relatedColors = [];

        foreach ($productColors as $productColor) {
            foreach ($masterColors as $masterColor) {
                if ($productColor->color_master_id == $masterColor->id) {
                    $relatedColors[] = $masterColor;
                }
            }
        }

        $embellishmentList = EmbellishmentType::whereIn('id', $embellishmentProducts)->get();

        foreach ($embellishmentList as $embellishment) {
            if ($embellishment->active) {
                $relatedEmbellishments[] = $embellishment;
            }
        }

        $relatedEmbellishments = array_values($relatedEmbellishments);


        return response()->json([
            'relatedEmbellishments' => $relatedEmbellishments, 'relatedColors'=>$relatedColors
        ]);
    }

    public function getFabricDetails(Request $request){

        $subProductId = $request->input('subProductId');

        $subProduct = SubProduct::where('id', $subProductId)
            ->where('active', 1)
            ->with('fabric')
            ->first();


        return response()->json([
            'subProduct'=>$subProduct
        ]);
    }

    public function getEmbellishmentDetails(Request $request){

        $selectedEmbellishmentId = $request->input('selectedEmbellishmentId');

        $embellishmentTypes = EmbellishmentType::where('id', $selectedEmbellishmentId)->first();

        $subProductId = $request->input('subProductId');

        $subProduct = SubProduct::where('id', $subProductId)->first();

        $masterColors = ColorMaster::get();

        $productColors = SubProductColor::where('sub_product_no', $subProduct->sub_product_no)->get();

        $relatedColors = [];

        foreach ($productColors as $productColor) {
            foreach ($masterColors as $masterColor) {
                if ($productColor->color_master_id == $masterColor->id) {
                    $relatedColors[] = $masterColor;
                }
            }
        }

        return response()->json([
            'embellishmentTypes'=>$embellishmentTypes, 'relatedColors'=>$relatedColors
        ]);
    }

    public function getColorDetails(Request $request){


        $subProductId = $request->input('subProductId');

        $subProduct = SubProduct::where('id', $subProductId)->first();

        $masterColors = ColorMaster::get();

        $productColors = SubProductColor::where('sub_product_no', $subProduct->sub_product_no)->get();

        $relatedColors = [];

        foreach ($productColors as $productColor) {
            foreach ($masterColors as $masterColor) {
                if ($productColor->color_master_id == $masterColor->id) {
                    $relatedColors[] = $masterColor;
                }
            }
        }

        return response()->json([
            'relatedColors'=>$relatedColors
        ]);
    }

    public function getTaglineDetails(Request $request){

        $taglineId = $request->input('taglineId');

        $productTaglines = ProductTagline::where('id', $taglineId)->first();

        return response()->json([
            'productTaglines'=>$productTaglines
        ]);
    }

    private function getRelatedFabrics($productId, $type = 'product')
    {
        if ($type == 'sub_product') {
            $fabricProducts = SubProduct::where('id', $productId)
                ->where('active', 1)
                ->select('id', 'fabric_id')
                ->get();
        } else {
            $fabricProducts = SubProduct::where('parent_product_id', $productId)
                ->where('active', 1)
                ->select('id', 'fabric_id')
                ->get();
        }

        $fabricDetails = Fabric::get();
        $relatedFabric = [];

        foreach ($fabricProducts as $fabricProduct) {
            foreach ($fabricDetails as $fabricDetail) {
                if ($fabricProduct->fabric_id == $fabricDetail->id) {
                    $relatedFabric[] = [
                        'subproduct_id' => $fabricProduct->id,
                        'fabric_detail' => $fabricDetail,
                    ];
                }
            }
        }

        return $relatedFabric;
    }

    private function getRelatedEmbellishments($embellishmentProducts)
    {
        $embellishmentTypes = EmbellishmentType::get(); // no need deleted filter here now

        $relatedEmbellishments = [];

        foreach ($embellishmentProducts as $embellishmentProduct) {

            if (!$embellishmentProduct) continue;

            $separatedEmbellishments = preg_split('/\s*\/\s*/', $embellishmentProduct);

            foreach ($separatedEmbellishments as $embellishment) {

                $cleanName = strtolower(trim($embellishment));

                foreach ($embellishmentTypes as $embellishmentType) {

                    if (strtolower(trim($embellishmentType->embellishment_name)) === $cleanName) {

                        if (!collect($relatedEmbellishments)->pluck('id')->contains($embellishmentType->id)) {
                            $relatedEmbellishments[] = $embellishmentType;
                        }
                    }
                }
            }
        }

        return $relatedEmbellishments;
    }


}
