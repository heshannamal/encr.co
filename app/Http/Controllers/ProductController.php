<?php

namespace App\Http\Controllers;

use Storage;
use Carbon\Carbon;
use App\Models\Size;
use App\Models\Price;
use App\Models\Sport;
use App\Models\Fabric;
use App\Models\Factory;
use App\Models\Product;
use App\Models\SizeType;
use App\Models\Attribute;
use App\Models\ProductMainCategory;
use App\Models\OrderItem;
use App\Models\PriceType;
use App\Models\ProductSize;
use App\Models\ColumnLayout;
use App\Models\MainCategory;
use App\Models\ProductImage;
use App\Models\ProductSport;
use Illuminate\Http\Request;
use App\Models\ProductFabric;
use App\Models\ProductLayout;
use App\Models\ProductFactory;
use App\Models\ProductCategory;
use App\Models\ProductAttribute;
use App\Models\EmbellishmentType;
use App\Models\SubProduct;
use App\Models\ColorMaster;
use App\Models\ProductTagline;
use App\Models\ProductTaglineList;
use App\Models\MasterFit;
use App\Models\ProductFit;
use App\Models\MainProductColor;
use App\Models\PriceTemp;
use Illuminate\Http\UploadedFile;
use App\Models\ProductCategoryList;
use Illuminate\Support\Facades\Auth;
use App\Models\ProductEmbellishmentType;
use App\Models\ProductImageTemp;
use App\Models\ProductTemp;
use App\Models\Project;
use App\Models\SubProductImageTemp;
use App\Models\SubProductTemp;
use Illuminate\Support\Facades\File;
use domainencore\Facades\ProductFacade\ProductFacade;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    //Google Drive- test
    // public $parentFolder = '1wA5Jm3cSDpvMJU1F4LjAg2uPp9Tc1Hen';
    //Google Drive- Live
    // public $parentFolder = '1wA5Jm3cSDpvMJU1F4LjAg2uPp9Tc1Hen';

    protected $parentFolder;

    public function __construct()
    {
        $this->parentFolder = env('PARENT_FOLDER_ID');
    }

    public function index(){
        if(auth()->user()->can('view product')){
            $maxId = Product::max('id');
            // $productNo = 'PRO'.str_pad(($maxId+1), 6, "0", STR_PAD_LEFT);
            $productNo = 'PRO-'.($maxId+1);

            $newProductNo = $maxId+1;

            $products = Product::with('productCategories.categories')->whereIn('active', [1,3,4])->orderBy('id')->get();

            $productLayout = productLayout::where('user_id', Auth::user()->id)->first();

            $columnLayout = ColumnLayout::where('interface_id', 5)->where('user_id', Auth::user()->id)->first();

            $sizes = Size::orderBy('id')->where('active', 1)->get();

            $productCategories = ProductCategory::orderBy('id')->where('active', 1)->get();

            $fabrics = Fabric::orderBy('fabric_name')->where('active', 1)->get();

            $embellishmentTypes = EmbellishmentType::orderBy('embellishment_name')->where('active', 1)->get();

            $productAttributes = Attribute::orderBy('attribute_name')->where('active', 1)->get();

            $sports = Sport::where('active', 1)->orderBy('sport_name')->get();

            $factories = Factory::where('active', 1)->orderBy('factory_name')->get();

            $sizeTypes = SizeType::get();

            $productSports = ProductSport::orderBy('id')->get();

            $mainCategories = MainCategory::get();

            $productImages = ProductImage::get();

            $priceTypes = PriceType::get();

            $price = Price::where('active', 1)->get();

            $multipleProductCategories = ProductMainCategory::get();

            $subProducts = SubProduct::with('embellishmentTypes')->get();

            return view('pages.masters.products.index', [
                'productNo'=>$productNo, 'products'=>$products, 'productLayout'=>$productLayout, 'sizes'=>$sizes, 'productCategories'=>$productCategories,
                'fabrics'=>$fabrics, 'embellishmentTypes'=>$embellishmentTypes, 'columnLayout'=>$columnLayout, 'sports'=>$sports,
                'productAttributes'=>$productAttributes, 'factories'=>$factories, 'productSports'=>$productSports,'sizeTypes'=>$sizeTypes, 'newProductNo'=>$newProductNo,
                'mainCategories'=>$mainCategories, 'priceTypes'=>$priceTypes, 'price'=>$price,
                'productImages'=>$productImages, 'multipleProductCategories'=>$multipleProductCategories, 'subProducts'=>$subProducts
            ]);
        } else {
            return redirect()->back()->withError('Permission Not Granted!');
        }
    }

    //newly created functions with sub products update

    public function edit_product($id){
        if(auth()->user()->can('view product')){


        if($id == "null"){

            $productID = Product::max('id')+1;

            $sizes = Size::orderBy('id')->where('active', 1)->get();

            $productCategories = ProductCategory::orderBy('id')->where('active', 1)->get();

            $embellishmentTypes = EmbellishmentType::orderBy('embellishment_name')->where('active', 1)->get();

            $productAttributes = Attribute::orderBy('attribute_name')->where('active', 1)->get();

            $sports = Sport::where('active', 1)->orderBy('sport_name')->get();

            $factories = Factory::where('active', 1)->orderBy('factory_name')->get();

            $sizeTypes = SizeType::get();

            $productSports = ProductSport::orderBy('id')->get();

            $mainCategories = MainCategory::get();

            $productImages = null;

            $priceTypes = PriceType::get();

            $prices = null;

            $isExist = 0;

            $product = null;

            $colorMasters = ColorMaster::get();

            $productTaglines = ProductTagline::where('active', 1)->get();

            $masterFits = MasterFit::where('active', 1)->get();

        }else{

            $sizes = Size::orderBy('id')->where('active', 1)->get();

            $productCategories = ProductCategory::orderBy('id')->where('active', 1)->get();

            $embellishmentTypes = EmbellishmentType::orderBy('embellishment_name')->where('active', 1)->get();

            $productAttributes = Attribute::orderBy('attribute_name')->where('active', 1)->get();

            $sports = Sport::where('active', 1)->orderBy('sport_name')->get();

            $factories = Factory::where('active', 1)->orderBy('factory_name')->get();

            $sizeTypes = SizeType::get();

            $productSports = ProductSport::orderBy('id')->get();

            $mainCategories = MainCategory::get();

            $productImages = ProductImage::where('active', 1)->where('product_id', $id)->orderBy('id')->get();

            $priceTypes = PriceType::get();

            $prices = Price::where('product_id', $id)->where('active', 1)->orderBy('price_type')->get();

            // dd($prices);

            $isExist = 1;

            $productID = $id;

            $product = Product::find($id);

            $sub_product_found = SubProduct::where('parent_product_id', $id)->first();
            if($sub_product_found){
                $product->attribute_on_price = array_map('trim', explode('/', $sub_product_found->attribute_on_price));
            }else{
                $product->attribute_on_price = [];
            }

            //Multi values for $product

            $product_main_category_ids = ProductMainCategory::where('product_id', $id)->pluck('main_category_id')->unique();
            if(!empty($product_main_category_ids)){
                $product->main_category_id = $product_main_category_ids;
            }

            $product_category_ids = ProductCategoryList::where('product_id', $id)->pluck('product_category_id')->unique();
            if(!empty($product_category_ids)){
                $product->product_category_id = $product_category_ids;
            }
            $product_sport_ids = ProductSport::where('product_id', $id)->pluck('sport_id')->unique();
            if(!empty($product_sport_ids)){
                $product->sport = $product_sport_ids;
            }
            $product_attributes_ids = ProductAttribute::where('product_id', $id)->pluck('attribute_id')->unique();
            if(!empty($product_attributes_ids)){
                $product->attributes = $product_attributes_ids;
            }
            $product_factory_ids = ProductFactory::where('product_id', $id)->pluck('product_factory_id')->unique();
            if(!empty($product_factory_ids)){
                $product->factory = $product_factory_ids;
            }
            $product_embellishment_type_ids = ProductEmbellishmentType::where('product_id', $id)->pluck('embellishment_type_id')->unique();
            if(!empty($product_embellishment_type_ids)){
                $product->embellishmentTypes = $product_embellishment_type_ids;
            }

            $colorMasters = ColorMaster::get();

            $productTaglines = ProductTagline::where('active', 1)->get();

            $product_tagline_ids = ProductTaglineList::where('product_id', $id)->pluck('tagline_id')->unique();
            if(!empty($product_tagline_ids)){
                $product->tagline = $product_tagline_ids;
            }

            $masterFits = MasterFit::where('active', 1)->get();

            $product_fit_ids = ProductFit::where('product_id', $id)->pluck('fit_id')->unique();
            if(!empty($product_fit_ids)){
                $product->fit = $product_fit_ids;
            }
        }
        return view('pages.masters.products.product_create', [
            'productID'=>$productID, 'sizes'=>$sizes, 'productCategories'=>$productCategories, 'product' => $product,
            'embellishmentTypes'=>$embellishmentTypes, 'sports'=>$sports,
            'productAttributes'=>$productAttributes, 'factories'=>$factories, 'productSports'=>$productSports,'sizeTypes'=>$sizeTypes,
            'mainCategories'=>$mainCategories, 'priceTypes'=>$priceTypes, 'prices'=>$prices,
            'productImages'=>$productImages, 'isExist' => $isExist, 'colorMasters'=>$colorMasters, 'productTaglines'=>$productTaglines,
            'masterFits'=>$masterFits
        ]);

        } else {
            return redirect()->back()->withError('Permission Not Granted!');
        }
    }

    public function create_product(Request $request){

        if (auth()->user()->can('edit products')) {
            $product = Product::where('id', $request->product_id)->first();
            if($product){
                $product->product_name = $request->new_product_name;
                $product->show_in_catalog_name = $request->show_in_catalog_name;
                $product->product_no = $request->new_product_no;
                $product->pattern_code = $request->pattern_code;
                $product->gender = $request->new_gender;
                $product->default_price = $request->new_default_price;
                $product->size_id = $request->new_size_id;
                $product->MOQ = $request->MOQ;
                $product->description = $request->new_description;
                $product->who_we_made_this_for = $request->who_we_made_this_for;
                $product->product_features = $request->product_features;
                $product->notes = $request->new_notes;
                $product->product_reference_link = $request->new_product_reference_link;
                $product->active = $request->active;
                if($request->active == 0 || $request->active == 3){
                    SubProduct::where('parent_product_id', $request->product_id)->where('active', 1)->update(['active' => $request->active]);

                }
                if(isset($request->show_in_catalog)){
                    $product->show_in_catalog = 1;
                }else{
                    $product->show_in_catalog = 0;
                }
                if($request->active != 1){
                    $product->show_in_catalog = 0;
                }
                $product->fits_true_to_size =$request->fitsSizes;
                $product->update();

                $sub_products = SubProduct::where('parent_product_id', $request->product_id)->get();

                foreach ($sub_products as $subProduct) {
                    if (is_array($request->attribute_on_price)) {
                        $subProduct->attribute_on_price = implode(' / ', $request->attribute_on_price);
                        $subProduct->save();
                    } else {
                        $subProduct->attribute_on_price = '';
                        $subProduct->save();
                    }
                }

                ProductMainCategory::where('product_id', $request->product_id)->forceDelete();
                if(isset($request->new_main_category_id)){
                    foreach($request->new_main_category_id as $new_main_category_id){
                        $productMainCategory= new ProductMainCategory();
                        $productMainCategory->product_id = $product->id;
                        $productMainCategory->main_category_id=$new_main_category_id;
                        $productMainCategory->save();
                    }
                }

                $sizeByType = Size::select('id')->where('size_type', $request->new_size_id)->get();
                $sizeArray = array();
                foreach($sizeByType as $sizes){
                    $newSize = array($sizes['id']);
                    $newSize = implode(', ', $newSize);
                    array_push($sizeArray, $newSize);
                }

                $productSizes = ProductSize::where('product_id', $product->id)->delete();
                if (!empty($sizeArray)) {
                    foreach($sizeArray as $sizes){
                        $productSize = new ProductSize();
                        $productSize->product_id = $product->id;
                        $productSize->size_id = $sizes;
                        $productSize->save();
                    }
                } else {
                    foreach($sizeArray as $sizes){
                        $productSize = new ProductSize();
                        $productSize->product_id = $product->id;
                        $productSize->size_id = $sizes;
                        $productSize->save();
                    }
                }

                ProductFabric::where('product_id', $request->product_id)->forceDelete();
                if(isset($request->new_fabric_id)){
                    foreach($request->new_fabric_id as $fabrics){
                        $productFabric = new ProductFabric();
                        $productFabric->product_id = $product->id;
                        $productFabric->fabric_id = $fabrics;
                        $productFabric->save();
                    }
                }

                ProductSport::where('product_id', $request->product_id)->forceDelete();
                if (is_array($request->new_sport) && !empty($request->new_sport)) {
                    foreach($request->new_sport as $sports){
                        $productSport = new ProductSport();
                        $productSport->product_id = $product->id;
                        $productSport->sport_id = $sports;
                        $productSport->save();
                    }
                }

                ProductCategoryList::where('product_id', $request->product_id)->forceDelete();
                if(isset($request->new_product_category_id)){
                    foreach($request->new_product_category_id as $product_category){
                        $productCategoryList = new ProductCategoryList();
                        $productCategoryList->product_id = $product->id;
                        $productCategoryList->product_category_id=$product_category;
                        $productCategoryList->save();
                    }
                }

                ProductAttribute::where('product_id', $request->product_id)->forceDelete();
                if(isset($request->new_product_attribute_id)){
                    foreach($request->new_product_attribute_id as $product_attribute){
                        $productAttribute= new ProductAttribute();
                        $productAttribute->product_id = $product->id;
                        $productAttribute->attribute_id=$product_attribute;
                        $productAttribute->save();
                    }
                }

                ProductFactory::where('product_id', $request->product_id)->forceDelete();
                if(isset($request->new_product_factory_id)){
                    foreach($request->new_product_factory_id as $product_factory){
                        $productFactory= new ProductFactory();
                        $productFactory->product_id = $product->id;
                        $productFactory->product_factory_id=$product_factory;
                        $productFactory->save();
                    }
                }

                ProductTaglineList::where('product_id', $request->product_id)->delete();
                if(isset($request->product_tagline_id)){
                    foreach($request->product_tagline_id as $product_tagline){
                        $productTaglineList= new ProductTaglineList();
                        $productTaglineList->product_id = $product->id;
                        $productTaglineList->tagline_id=$product_tagline;
                        $productTaglineList->save();
                    }
                }

                ProductFit::where('product_id', $request->product_id)->delete();
                if(isset($request->product_fit_id)){
                    foreach($request->product_fit_id as $product_fit){
                        $productFit= new ProductFit();
                        $productFit->product_id = $product->id;
                        $productFit->fit_id=$product_fit;
                        $productFit->save();
                    }
                }

                ProductEmbellishmentType::where('product_id', $request->product_id)->forceDelete();
                if($request->new_embellishment_type_id != null){
                    foreach($request->new_embellishment_type_id as $embellishmentTypes){
                        $productEmbellishmentType = new ProductEmbellishmentType();
                        $productEmbellishmentType->product_id = $product->id;
                        $productEmbellishmentType->embellishment_type_id = $embellishmentTypes;
                        $productEmbellishmentType->save();
                    }
                }

                Price::where('product_id', $request->product_id)->where('active', 1)->update(['active' => 0,'end_date' => Carbon::now()->format('Y-m-d')]);

                    if ($request->new_default_price != null) {

                        $newDefaultPrice= new Price();
                        $currentDate = Carbon::now();
                        $newDefaultPrice->product_id = $product->id;
                        $newDefaultPrice->price_type = 1;
                        $newDefaultPrice->price = $request->new_default_price;
                        $newDefaultPrice->start_date = $currentDate->format('Y-m-d');
                        $newDefaultPrice->save();
                    }
                    if ($request->new_default_price2 !== null) {

                        $newDefaultPrice= new Price();
                        $currentDate = Carbon::now();
                        $newDefaultPrice->product_id = $product->id;
                        $newDefaultPrice->price_type =  $request->price_type_2;
                        $newDefaultPrice->price = $request->new_default_price2;
                        $newDefaultPrice->start_date = $currentDate->format('Y-m-d');
                        $newDefaultPrice->save();
                    }
                    if ($request->new_default_price3 !== null) {

                        $newDefaultPrice= new Price();
                        $currentDate = Carbon::now();
                        $newDefaultPrice->product_id = $product->id;
                        $newDefaultPrice->price_type =  $request->price_type_3;
                        $newDefaultPrice->price = $request->new_default_price3;
                        $newDefaultPrice->start_date = $currentDate->format('Y-m-d');
                        $newDefaultPrice->save();
                    }
                    if ($request->new_default_price4 !== null) {

                        $newDefaultPrice= new Price();
                        $currentDate = Carbon::now();
                        $newDefaultPrice->product_id = $product->id;
                        $newDefaultPrice->price_type =  $request->price_type_4;
                        $newDefaultPrice->price = $request->new_default_price4;
                        $newDefaultPrice->start_date = $currentDate->format('Y-m-d');
                        $newDefaultPrice->save();
                    }
                    if ($request->new_default_price5 !== null) {

                        $newDefaultPrice= new Price();
                        $currentDate = Carbon::now();
                        $newDefaultPrice->product_id = $product->id;
                        $newDefaultPrice->price_type =  $request->price_type_5;
                        $newDefaultPrice->price = $request->new_default_price5;
                        $newDefaultPrice->start_date = $currentDate->format('Y-m-d');
                        $newDefaultPrice->save();
                    }


                    if(isset($request->is_project_management)){
                        return redirect()->back()->with('success', 'Product PRO-' . $request->product_id . ' updated successfully !');
                    } else {
                        return redirect()->route('edit_product', ['id' => $request->product_id])->with('success', 'Product PRO-' . $request->product_id . ' updated successfully !');
                    }

            } else {
                // dd($request);
                    $product = new Product();
                    $product->product_name = $request->new_product_name;
                    $product->show_in_catalog_name = $request->show_in_catalog_name;
                    $product->product_no = $request->new_product_no;
                    $product->pattern_code = $request->pattern_code;
                    $product->MOQ = $request->MOQ;
                    $product->gender = $request->new_gender;
                    $product->default_price = $request->new_default_price;
                    $product->size_id = $request->new_size_id;
                    $product->description = $request->new_description;
                    $product->notes = $request->new_notes;
                    $product->product_reference_link = $request->new_product_reference_link;
                    $product->active = $request->active;
                    if(isset($request->show_in_catalog)){
                        $product->show_in_catalog = 1;
                    }else{
                        $product->show_in_catalog = 0;
                    }
                    if($request->active != 1){
                        $product->show_in_catalog = 0;
                    }
                    $product->fits_true_to_size = $request->fitsSizes;
                    $product->save();

                    if(isset($request->new_main_category_id)){
                        foreach($request->new_main_category_id as $new_main_category_id){
                            $productMainCategory= new ProductMainCategory();
                            $productMainCategory->product_id = $product->id;
                            $productMainCategory->main_category_id=$new_main_category_id;
                            $productMainCategory->save();
                        }
                    }

                    if ($request->new_default_price !== null) {
                        $defaultPrice = new Price();
                        $currentDate = Carbon::now();
                        $defaultPrice->product_id = $product->id;
                        $defaultPrice->price_type = 1;
                        $defaultPrice->price = $request->new_default_price;
                        $defaultPrice->start_date = $currentDate->format('Y-m-d');
                        $defaultPrice->save();
                    }
                    if ($request->new_default_price2 !== null) {
                        $defaultPrice = new Price();
                        $currentDate = Carbon::now();
                        $defaultPrice->product_id = $product->id;
                        $defaultPrice->price_type = $request->price_type_2;
                        $defaultPrice->price = $request->new_default_price2;
                        $defaultPrice->start_date = $currentDate->format('Y-m-d');
                        $defaultPrice->save();
                    }
                    if ($request->new_default_price3 !== null) {
                        $defaultPrice = new Price();
                        $currentDate = Carbon::now();
                        $defaultPrice->product_id = $product->id;
                        $defaultPrice->price_type = $request->price_type_3;
                        $defaultPrice->price = $request->new_default_price3;
                        $defaultPrice->start_date = $currentDate->format('Y-m-d');
                        $defaultPrice->save();
                    }
                    if ($request->new_default_price4 !== null) {
                        $defaultPrice = new Price();
                        $currentDate = Carbon::now();
                        $defaultPrice->product_id = $product->id;
                        $defaultPrice->price_type = $request->price_type_4;
                        $defaultPrice->price = $request->new_default_price4;
                        $defaultPrice->start_date = $currentDate->format('Y-m-d');
                        $defaultPrice->save();
                    }
                    if ($request->new_default_price5 !== null) {
                        $defaultPrice = new Price();
                        $currentDate = Carbon::now();
                        $defaultPrice->product_id = $product->id;
                        $defaultPrice->price_type = $request->price_type_5;
                        $defaultPrice->price = $request->new_default_price5;
                        $defaultPrice->start_date = $currentDate->format('Y-m-d');
                        $defaultPrice->save();
                    }


                    $sizeByType = Size::select('id')->where('size_type', $request->new_size_id)->get();
                    $sizeArray = array();
                    foreach($sizeByType as $sizes){
                        $newSize = array($sizes['id']);
                        $newSize = implode(', ', $newSize);
                        array_push($sizeArray, $newSize);
                    }

                    foreach($sizeArray as $sizes){
                        $productSize = new ProductSize();
                        $productSize->product_id = $product->id;
                        $productSize->size_id = $sizes;
                        $productSize->save();
                    }

                    if (is_array($request->new_sport) && !empty($request->new_sport)) {
                        foreach ($request->new_sport as $sport) {
                            $productSport = new ProductSport();
                            $productSport->product_id = $product->id;
                            $productSport->sport_id = $sport;
                            $productSport->save();
                        }
                    }

                    if(isset($request->new_product_category_id)){
                        foreach($request->new_product_category_id as $product_category){
                            $productCategoryList = new ProductCategoryList();
                            $productCategoryList->product_id = $product->id;
                            $productCategoryList->product_category_id=$product_category;
                            $productCategoryList->save();
                        }
                    }


                    if(isset($request->new_product_attribute_id)){
                        foreach($request->new_product_attribute_id as $product_attribute){
                            $productAttribute= new ProductAttribute();
                            $productAttribute->product_id = $product->id;
                            $productAttribute->attribute_id=$product_attribute;
                            $productAttribute->save();
                        }
                    }

                    if(isset($request->new_product_factory_id)){
                        foreach($request->new_product_factory_id as $product_factory){
                            $productFactory= new ProductFactory();
                            $productFactory->product_id = $product->id;
                            $productFactory->product_factory_id=$product_factory;
                            $productFactory->save();
                        }
                    }

                    if(isset($request->product_tagline_id)){
                        foreach($request->product_tagline_id as $product_tagline){
                            $productTaglineList= new ProductTaglineList();
                            $productTaglineList->product_id = $product->id;
                            $productTaglineList->tagline_id=$product_tagline;
                            $productTaglineList->save();
                        }
                    }

                    if(isset($request->product_fit_id)){
                        foreach($request->product_fit_id as $product_fit){
                            $productFit= new ProductFit();
                            $productFit->product_id = $product->id;
                            $productFit->fit_id=$product_fit;
                            $productFit->save();
                        }
                    }

                    if(isset($request->is_project_management)){
                        return redirect()->back()->with('success', 'Product PRO-' . $request->product_id . ' created successfully !');
                    } else {
                        return redirect()->route('edit_product', ['id' => $request->product_id])->with('success', 'Product PRO-' . $request->product_id . ' created successfully !');
                    }
            }
        }else{
            if(auth()->user()->can('edit product description')){
                $product = Product::where('id', $request->product_id)->first();
                if($product){
                    $product->description = $request->new_description;
                    $product->who_we_made_this_for = $request->who_we_made_this_for;
                    $product->product_features = $request->product_features;
                    $product->update();

                    if(isset($request->is_project_management)){
                        return redirect()->back()->with('success', 'Product PRO-' . $request->product_id . ' updated successfully !');
                    } else {
                        return redirect()->route('edit_product', ['id' => $request->product_id])->with('success', 'Product PRO-' . $request->product_id . ' updated successfully !');
                    }
                }else{
                    return redirect()->back()->withError('Product Not Found!');
                }
            }else{
                return redirect()->back()->withError('Permission Not Granted!');
            }
        }


    }

    public function create_product_temp(Request $request){
        if (auth()->user()->can('edit products')) {
            $project = Project::findOrFail($request->project_id);
            

            if ($project->product_level === 1) {
                $tempProduct = ProductTemp::findOrFail($project->product_id);

                $tempProduct->product_name = $request->new_product_name;
                $tempProduct->show_in_catalog_name = $request->show_in_catalog_name;
                $tempProduct->main_category_id = $request->new_main_category_id;
                $tempProduct->product_category_id = $request->new_product_category_id;
                // $tempProduct->product_no = $request->new_product_no;
                $tempProduct->pattern_code = $request->pattern_code;
                $tempProduct->gender = $request->new_gender;
                $tempProduct->default_price = $request->new_default_price;
                $tempProduct->MOQ = $request->MOQ;
                $tempProduct->description = $request->new_description;
                $tempProduct->who_we_made_this_for = $request->who_we_made_this_for;
                $tempProduct->product_features = $request->product_features;
                $tempProduct->notes = $request->new_notes;
                $tempProduct->product_reference_link = $request->new_product_reference_link;

                $tempProduct->fits_true_to_size = $request->fitsSizes;
                $tempProduct->fabric_ids = $request->new_fabric_id;
                $tempProduct->attribute_on_price = $request->attribute_on_price ?: null;

                $tempProduct->size_id = $request->new_size_id;
                $sizeIds = Size::where('size_type', $request->new_size_id)->pluck('id')->toArray();
                $tempProduct->size_ids = $sizeIds;
                
                $tempProduct->sport_ids = $request->new_sport ?: null;
                // $tempProduct->product_category_list_ids = $request->new_product_category_id ?: null;
                $tempProduct->product_attribute_ids = $request->new_product_attribute_id ?: null;
                $tempProduct->product_factory_ids = $request->new_product_factory_id ?: null;
                $tempProduct->product_tagline_ids = $request->product_tagline_id ?: null;
                $tempProduct->product_fit_ids = $request->product_fit_id ?: null;

                $tempProduct->active = 1;
                $tempProduct->show_in_catalog = 1;
                $tempProduct->save();

                // update project name
                $project->project_name = $request->new_product_name;
                $project->save();


                foreach($request->price as $typeId => $priceValue){        
                    if($priceValue === null || $priceValue === ''){
                        continue;
                    }

                    // deactivate old active price FIRST
                    PriceTemp::where('product_id',$tempProduct->id)
                        ->where('price_type',$typeId)
                        ->where('product_level',1)
                        ->where('active',1)
                        ->update([
                            'active'=>0,
                            'end_date'=>Carbon::today()
                        ]);

                    // insert new price
                    PriceTemp::create([
                        'product_id'=>$tempProduct->id,
                        'price_type'=>$typeId,
                        'product_level' => 1,
                        'price'=>$priceValue,
                        'start_date'=>Carbon::today(),
                        'active'=>1
                    ]);
                }
            } else {

                $subProduct = SubProductTemp::findOrFail($project->product_id);

                if ($subProduct) {
                    $subProduct->product_name = $request->new_product_name;
                    $subProduct->show_in_catalog_name = $request->show_in_catalog_name;
                    $subProduct->main_category_id = $request->new_main_category_id;
                    $subProduct->product_category_id = $request->new_product_category_id ?: null;
                    $subProduct->pattern_code = $request->pattern_code;
                    $subProduct->gender = $request->new_gender;
                    $subProduct->default_price = $request->new_default_price;
                    $subProduct->MOQ = $request->MOQ;
                    $subProduct->description = $request->new_description;
                    $subProduct->who_we_made_this_for = $request->who_we_made_this_for;
                    $subProduct->product_features = $request->product_features;
                    $subProduct->notes = $request->new_notes;
                    $subProduct->product_reference_link = $request->new_product_reference_link;

                    $subProduct->fits_true_to_size = $request->fitsSizes;

                    $subProduct->fabric_ids = $request->new_fabric_id;
                    $subProduct->fabric_id = $request->standard_fabric;
                    $subProduct->weight = $request->sub_product_weight;
                    $subProduct->attribute_on_price = $request->attribute_on_price ?: null;
                    $subProduct->embellishment_options = $request->embellishment_options;
                    $subProduct->colorIds = $request->new_available_colors;

                    $subProduct->size_id = $request->new_size_id ?: null;
                    $sizeIds = Size::where('size_type', $request->new_size_id)->pluck('id')->toArray();
                    $subProduct->size_ids = $sizeIds;

                    $subProduct->sport_ids = $request->new_sport ?: null;
                    
                    $subProduct->product_attribute_ids = $request->new_product_attribute_id ?: null;
                    $subProduct->product_factory_ids = $request->new_product_factory_id ?: null;
                    $subProduct->product_tagline_ids = $request->product_tagline_id ?: null;
                    $subProduct->product_fit_ids = $request->product_fit_id ?: null;

                    $subProduct->active = 1;
                    $subProduct->show_in_catalog = 1;
                    $subProduct->save();

                    // update project name from sub product
                    $project->project_name = $subProduct->product_name;
                    $project->save();

                    foreach($request->price as $typeId => $priceValue){

                        if($priceValue === null || $priceValue === ''){
                            continue;
                        }

                        // deactivate old active price FIRST
                        PriceTemp::where('product_id',$subProduct->id)
                            ->where('price_type',$typeId)
                            ->where('product_level',2)
                            ->where('active',1)
                            ->update([
                                'active'=>0,
                                'end_date'=>Carbon::today()
                            ]);

                        // insert new price
                        PriceTemp::create([
                            'product_id'=>$subProduct->id,
                            'price_type'=>$typeId,
                            'price'=>$priceValue,
                            'product_level' => 2,
                            'start_date'=>Carbon::today(),
                            'active'=>1
                        ]);
                    }
                }
            }
            
            if(isset($request->is_project_management)){
                return redirect()->back()->with('success', 'Product PRO-' . $request->product_id . ' updated successfully !');
            } else {
                return redirect()->route('edit_product', ['id' => $request->product_id])->with('success', 'Product PRO-' . $request->product_id . ' updated successfully !');
            }
        } else {
            if(auth()->user()->can('edit product description')){
                $tempProduct = ProductTemp::find($request->product_id);
                if($tempProduct){
                    $tempProduct->description = $request->new_description;
                    $tempProduct->who_we_made_this_for = $request->who_we_made_this_for;
                    $tempProduct->product_features = $request->product_features;
                    $tempProduct->update();

                    if(isset($request->is_project_management)){
                        return redirect()->back()->with('success', 'Product PRO-' . $request->product_id . ' updated successfully !');
                    } else {
                        return redirect()->route('edit_product', ['id' => $request->product_id])->with('success', 'Product PRO-' . $request->product_id . ' updated successfully !');
                    }
                }else{
                    return redirect()->back()->withError('Product Not Found!');
                }
            }else{
                return redirect()->back()->withError('Permission Not Granted!');
            }

        }

    }

    //newly created end

    public function create(Request $request){
        // dd($request->fitsSizes);
        try {
            $parentFolder = $this->parentFolder;
            if($request->product_id){
                $product = Product::find($request->product_id);
                if($product){
                    $product->product_name = $request->new_product_name;
                    $product->product_no = $request->new_product_no;
                    // $product->pattern_code = $request->new_pattern_code;
                    // $product->sport = $request->new_sport;
                    $product->gender = $request->new_gender;
                    $product->default_price = $request->new_default_price;
                    $product->MOQ = $request->MOQ;
                    $product->size_id = $request->new_size_id;
                    $product->fabric_id = $request->new_standard_fabric_id;
                    $product->description = $request->new_description;
                    $product->notes = $request->new_notes;
                    $product->product_reference_link = $request->new_product_reference_link;
                    $product->active = $request->active;
                    // $product->main_category_id = $request->new_main_category_id;
                    $product->fits_true_to_size =$request->fitsSizes;
                    $product->update();

                    ProductMainCategory::where('product_id', $request->product_id)->forceDelete();
                    if($request->new_main_category_id!=null){
                        foreach($request->new_main_category_id as $new_main_category_id){
                            $productMainCategory= new ProductMainCategory();
                            $productMainCategory->product_id = $product->id;
                            $productMainCategory->main_category_id=$new_main_category_id;
                            $productMainCategory->save();
                        }
                    }

                    // if($request->new_weight!=null){
                    //     $product->weight = $request->new_weight;
                    // }

                    $sizeByType = Size::select('id')->where('size_type', $request->new_size_id)->get();
                    $sizeArray = array();
                    foreach($sizeByType as $sizes){
                        $newSize = array($sizes['id']);
                        $newSize = implode(', ', $newSize);
                        array_push($sizeArray, $newSize);
                    }

                    $productSizes = ProductSize::where('product_id', $product->id)->get();
                    $productId = $product->id;
                    if ($productSizes) {
                        ProductSize::where('product_id', $product->id)->delete();
                        foreach($sizeArray as $sizes){
                            $productSize = new ProductSize();
                            $productSize->product_id = $productId;
                            $productSize->size_id = $sizes;
                            $productSize->save();
                        }
                    } else {
                        foreach($sizeArray as $sizes){
                            $productSize = new ProductSize();
                            $productSize->product_id = $product->id;
                            $productSize->size_id = $sizes;
                            $productSize->save();
                        }
                    }

                    ProductFabric::where('product_id', $request->product_id)->forceDelete();
                    if($request->new_fabric_id != null){
                        foreach($request->new_fabric_id as $fabrics){
                            $productFabric = new ProductFabric();
                            $productFabric->product_id = $product->id;
                            $productFabric->fabric_id = $fabrics;
                            $productFabric->save();
                        }
                    }

                    ProductSport::where('product_id', $request->product_id)->forceDelete();
                    if (is_array($request->new_sport) && !empty($request->new_sport)) {
                        foreach($request->new_sport as $sports){
                            $productSport = new ProductSport();
                            $productSport->product_id = $product->id;
                            $productSport->sport_id = $sports;
                            $productSport->save();
                        }
                    }

                    // ProductEmbellishmentType::where('product_id', $request->product_id)->forceDelete();
                    // if($request->new_embellishment_type_id != null){
                    //     foreach($request->new_embellishment_type_id as $embellishmentTypes){
                    //         $productEmbellishmentType = new ProductEmbellishmentType();
                    //         $productEmbellishmentType->product_id = $product->id;
                    //         $productEmbellishmentType->embellishment_type_id = $embellishmentTypes;
                    //         $productEmbellishmentType->save();
                    //     }
                    // }

                    ProductCategoryList::where('product_id', $request->product_id)->forceDelete();
                    foreach($request->new_product_category_id as $product_category){
                        $productCategoryList = new ProductCategoryList();
                        $productCategoryList->product_id = $product->id;
                        $productCategoryList->product_category_id=$product_category;
                        $productCategoryList->save();
                    }

                    ProductAttribute::where('product_id', $request->product_id)->forceDelete();
                    if($request->new_product_attribute_id!=null){
                        foreach($request->new_product_attribute_id as $product_attribute){
                            $productAttribute= new ProductAttribute();
                            $productAttribute->product_id = $product->id;
                            $productAttribute->attribute_id=$product_attribute;
                            $productAttribute->save();
                        }
                    }

                    ProductFactory::where('product_id', $request->product_id)->forceDelete();
                    if($request->new_product_factory_id!=null){
                        foreach($request->new_product_factory_id as $product_factory){
                            $productFactory= new ProductFactory();
                            $productFactory->product_id = $product->id;
                            $productFactory->product_factory_id=$product_factory;
                            $productFactory->save();
                        }
                    }

                    Price::where('product_id', $request->product_id)->get();
                        if ($request->new_default_price!=null) {
                            Price::where('product_id', $request->product_id)
                                ->update([
                                    'active' => 0,
                                    'end_date' => Carbon::now()->format('Y-m-d')
                                ]);

                            $newDefaultPrice= new Price();
                            $currentDate = Carbon::now();
                            $newDefaultPrice->product_id = $product->id;
                            $newDefaultPrice->price_type = 1;
                            $newDefaultPrice->price = $request->new_default_price;
                            $newDefaultPrice->start_date = $currentDate->format('Y-m-d');
                            $newDefaultPrice->save();
                        }
                        if ($request->new_default_price2!=null) {
                            // $defaultPrice = Price::where('product_id', $request->product_id)->first();
                            // if ($defaultPrice) {
                            //    $defaultPrice->active = 0;
                            //    $currentDate = Carbon::now();
                            //    $defaultPrice->end_date = $currentDate->format('Y-m-d');
                            //    $defaultPrice->update();

                            // }

                            $newDefaultPrice= new Price();
                            $currentDate = Carbon::now();
                            $newDefaultPrice->product_id = $product->id;
                            $newDefaultPrice->price_type =  $request->price_type_2;
                            $newDefaultPrice->price = $request->new_default_price2;
                            $newDefaultPrice->start_date = $currentDate->format('Y-m-d');
                            $newDefaultPrice->save();
                        }
                        if ($request->new_default_price3!=null) {
                            // $defaultPrice = Price::where('product_id', $request->product_id)->first();
                            // if ($defaultPrice) {
                            //    $defaultPrice->active = 0;
                            //    $currentDate = Carbon::now();
                            //    $defaultPrice->end_date = $currentDate->format('Y-m-d');
                            //    $defaultPrice->update();

                            // }

                            $newDefaultPrice= new Price();
                            $currentDate = Carbon::now();
                            $newDefaultPrice->product_id = $product->id;
                            $newDefaultPrice->price_type =  $request->price_type_3;
                            $newDefaultPrice->price = $request->new_default_price3;
                            $newDefaultPrice->start_date = $currentDate->format('Y-m-d');
                            $newDefaultPrice->save();
                        }
                        if ($request->new_default_price4!=null) {
                            // $defaultPrice = Price::where('product_id', $request->product_id)->first();
                            // if ($defaultPrice) {
                            //    $defaultPrice->active = 0;
                            //    $currentDate = Carbon::now();
                            //    $defaultPrice->end_date = $currentDate->format('Y-m-d');
                            //    $defaultPrice->update();

                            // }

                            $newDefaultPrice= new Price();
                            $currentDate = Carbon::now();
                            $newDefaultPrice->product_id = $product->id;
                            $newDefaultPrice->price_type =  $request->price_type_4;
                            $newDefaultPrice->price = $request->new_default_price4;
                            $newDefaultPrice->start_date = $currentDate->format('Y-m-d');
                            $newDefaultPrice->save();
                        }
                        if ($request->new_default_price5!=null) {
                            // $defaultPrice = Price::where('product_id', $request->product_id)->first();
                            // if ($defaultPrice) {
                            //    $defaultPrice->active = 0;
                            //    $currentDate = Carbon::now();
                            //    $defaultPrice->end_date = $currentDate->format('Y-m-d');
                            //    $defaultPrice->update();

                            // }

                            $newDefaultPrice= new Price();
                            $currentDate = Carbon::now();
                            $newDefaultPrice->product_id = $product->id;
                            $newDefaultPrice->price_type =  $request->price_type_5;
                            $newDefaultPrice->price = $request->new_default_price5;
                            $newDefaultPrice->start_date = $currentDate->format('Y-m-d');
                            $newDefaultPrice->save();
                        }

                    return json_encode([
                        'responce'=>'success',
                        'meessage'=>'Product Updated Successfully!',
                        'product_id'=>$product->id,
                    ]);

                } else {
                    return json_encode([
                        'responce'=>'error',
                        'meessage'=>'Invalid Product',
                        'product_id'=>null,
                    ]);
                }

            } else {

                $product = new Product();
                $product->product_name = $request->new_product_name;
                $product->product_no = $request->new_product_no;
                // $product->pattern_code = $request->new_pattern_code;
                // $product->sport = $request->new_sport;
                $product->gender = $request->new_gender;
                $product->default_price = $request->new_default_price;
                $product->size_id = $request->new_size_id;
                $product->MOQ = $request->MOQ;
                // $product->fabric_id = $request->new_standard_fabric_id;
                $product->description = $request->new_description;
                $product->notes = $request->new_notes;
                $product->product_reference_link = $request->new_product_reference_link;
                $product->active = $request->active;
                // $product->main_category_id = $request->new_main_category_id;
                $product->fits_true_to_size = $request->fitsSizes;
                $product->save();

                if($request->new_main_category_id!=null){
                    foreach($request->new_main_category_id as $new_main_category_id){
                        $productMainCategory= new ProductMainCategory();
                        $productMainCategory->product_id = $product->id;
                        $productMainCategory->main_category_id=$new_main_category_id;
                        $productMainCategory->save();
                    }
                }

                // if($request->new_weight!=null){
                //     $product->weight = $request->new_weight;
                // }


                if ($request->new_default_price!=null) {
                    $defaultPrice = new Price();
                    $currentDate = Carbon::now();
                    $defaultPrice->product_id = $product->id;
                    $defaultPrice->price_type = 1;
                    $defaultPrice->price = $request->new_default_price;
                    $defaultPrice->start_date = $currentDate->format('Y-m-d');
                    $defaultPrice->save();
                }
                if ($request->new_default_price2!=null) {
                    $defaultPrice = new Price();
                    $currentDate = Carbon::now();
                    $defaultPrice->product_id = $product->id;
                    $defaultPrice->price_type = $request->price_type_2;
                    $defaultPrice->price = $request->new_default_price2;
                    $defaultPrice->start_date = $currentDate->format('Y-m-d');
                    $defaultPrice->save();
                }
                if ($request->new_default_price3!=null) {
                    $defaultPrice = new Price();
                    $currentDate = Carbon::now();
                    $defaultPrice->product_id = $product->id;
                    $defaultPrice->price_type = $request->price_type_3;
                    $defaultPrice->price = $request->new_default_price3;
                    $defaultPrice->start_date = $currentDate->format('Y-m-d');
                    $defaultPrice->save();
                }
                if ($request->new_default_price4!=null) {
                    $defaultPrice = new Price();
                    $currentDate = Carbon::now();
                    $defaultPrice->product_id = $product->id;
                    $defaultPrice->price_type = $request->price_type_4;
                    $defaultPrice->price = $request->new_default_price4;
                    $defaultPrice->start_date = $currentDate->format('Y-m-d');
                    $defaultPrice->save();
                }
                if ($request->new_default_price5!=null) {
                    $defaultPrice = new Price();
                    $currentDate = Carbon::now();
                    $defaultPrice->product_id = $product->id;
                    $defaultPrice->price_type = $request->price_type_5;
                    $defaultPrice->price = $request->new_default_price5;
                    $defaultPrice->start_date = $currentDate->format('Y-m-d');
                    $defaultPrice->save();
                }


                $sizeByType = Size::select('id')->where('size_type', $request->new_size_id)->get();
                $sizeArray = array();
                foreach($sizeByType as $sizes){
                    $newSize = array($sizes['id']);
                    $newSize = implode(', ', $newSize);
                    array_push($sizeArray, $newSize);
                }

                foreach($sizeArray as $sizes){
                    $productSize = new ProductSize();
                    $productSize->product_id = $product->id;
                    $productSize->size_id = $sizes;
                    $productSize->save();
                }

                // if($request->new_fabric_id != null){
                //     foreach($request->new_fabric_id as $fabrics){
                //         $productFabric = new ProductFabric();
                //         $productFabric->product_id = $product->id;
                //         $productFabric->fabric_id = $fabrics;
                //         $productFabric->save();
                //     }
                // }

                if (is_array($request->new_sport) && !empty($request->new_sport)) {
                    foreach ($request->new_sport as $sport) {
                        $productSport = new ProductSport();
                        $productSport->product_id = $product->id;
                        $productSport->sport_id = $sport;
                        $productSport->save();
                    }
                }

                // if($request->new_embellishment_type_id != null){
                //     foreach($request->new_embellishment_type_id as $embellishmentTypes){
                //         $productEmbellishmentType = new ProductEmbellishmentType();
                //         $productEmbellishmentType->product_id = $product->id;
                //         $productEmbellishmentType->embellishment_type_id = $embellishmentTypes;
                //         $productEmbellishmentType->save();
                //     }
                // }

                foreach($request->new_product_category_id as $product_category){
                    $productCategoryList = new ProductCategoryList();
                    $productCategoryList->product_id = $product->id;
                    $productCategoryList->product_category_id=$product_category;
                    $productCategoryList->save();
                }

                if($request->new_product_attribute_id!=null){
                    foreach($request->new_product_attribute_id as $product_attribute){
                        $productAttribute= new ProductAttribute();
                        $productAttribute->product_id = $product->id;
                        $productAttribute->attribute_id=$product_attribute;
                        $productAttribute->save();
                    }
                }

                if($request->new_product_factory_id!=null){
                    foreach($request->new_product_factory_id as $product_factory){
                        $productFactory= new ProductFactory();
                        $productFactory->product_id = $product->id;
                        $productFactory->product_factory_id=$product_factory;
                        $productFactory->save();
                    }
                }



                // Get the product number from the request
                $productNumber = $request->input('new_product_no');

                // Get the folder ID of the destination folder in Google Drive
                $parentFolderId  = $this->parentFolder;

                // Create a subfolder within the destination folder using the product number
                $subfolderName = $productNumber;

                // Check if the subfolder exists, create it if not
                if (!Storage::disk('google')->exists($parentFolderId . '/' . $subfolderName)) {
                    // Create the subfolder
                    Storage::disk('google')->makeDirectory($parentFolderId . '/' . $subfolderName);
                }

                return json_encode([
                    'responce'=>'success',
                    'meessage'=>'Product Saved Successfully! Now You Can Upload Images!',
                    'product_id'=>$product->id,
                ]);
            }
        } catch (\Throwable $th) {
            return json_encode([
                'responce'=>'error',
                'meessage'=>$th->getMessage(),
                'product_id'=>null,
            ]);
        }

        // return redirect()->back()->withSuccess('Product Saved Successfully!');
    }

    public function getDirrectryId($parentFolder, $subFolderName){
        $directories = Storage::disk('google')->directories($parentFolder);

        foreach($directories as $directory){
            $folder = Storage::disk('google')->getMetadata($directory);
            if ($folder['name'] == $subFolderName) {
                return $folder['path'];
            }
        }
        return false;
    }

    public function uploadImage(Request $request){
        try {
            $parentFolder = $this->parentFolder;
            if($request->hasFile('image_uploaded')){
                $file = $request->file('image_uploaded');

                if(!isset($request->db_image_field)){
                    $directory_test = base_path('assets/Product Master/' . $request->product_no . '/' . $request->folder);

                    File::makeDirectory($directory_test, 0777, true, true);

                    $directory = '/Product Master'.'/'.$request->product_no.'/' .$request->folder ;

                    $FoundProduct = Product::where('product_no' , $request->product_no)->first();

                    if($request->db_field == 'mockup_img_1'){
                        $filename = 'front.' . $file->getClientOriginalExtension();
                    }elseif($request->db_field == 'mockup_img_2'){
                        $filename = 'side.' . $file->getClientOriginalExtension();
                    }elseif($request->db_field == 'mockup_img_3'){
                        $filename = 'back.' . $file->getClientOriginalExtension();
                    }elseif($request->db_field == '2D_mockup'){
                        $filename = $request->product_no .'_2D_mockup_template.' . $file->getClientOriginalExtension();
                    }elseif($request->db_field == '3D_mockup'){
                        $filename = $request->product_no .'_3D_mockup_template.' . $file->getClientOriginalExtension();
                    }elseif($request->db_field == 'tech_pack'){
                        $filename = $request->product_no .'_design_tech_pack.' . $file->getClientOriginalExtension();
                    }elseif($request->db_field == 'measurement'){
                        $filename = $request->product_no .'_measurement_chart.' . $file->getClientOriginalExtension();
                    }elseif($request->db_field == 'product_layout'){
                        $filename = $request->product_no .'_production_layouts.' . $file->getClientOriginalExtension();
                    }elseif($request->db_field == 'pattern'){
                        $filename = $request->product_no .'_pattern_file.' . $file->getClientOriginalExtension();
                    }elseif($request->db_field == 'technical_tech_pack'){
                        $filename = $request->product_no .'_technical_tech_pack.' . $file->getClientOriginalExtension();
                    }elseif($request->db_field == 'size_chart'){
                        $filename = $request->product_no .'_size_chart.' . $file->getClientOriginalExtension();
                    }

                    $file->move($directory_test, $filename);
                    $FoundProduct->{$request->db_field} = $directory.'/'.$filename;
                    $FoundProduct->save();

                    return json_encode([
                        'responce'=>'success',
                        'meessage'=>$request->file_category.' Image Uploaded Sucessfully',
                    ]);
                }else{

                    $fileName = $file->getClientOriginalName();

                    $directoryPath = base_path('assets/Product Master/' . $request->product_no . '/' . $request->folder);

                    $directory2 = 'assets/Product Master'.'/'.$request->product_no.'/' .$request->folder. '/' .$fileName ;

                    if (!File::exists($directoryPath)) {
                        File::makeDirectory($directoryPath, 0777, true, true);
                    }

                    $file->move($directoryPath, $fileName);

                    if (isset($request->db_image_field)) {
                        $productImage = new ProductImage();
                        $productImage->product_id = $request->product_id;
                        $productImage->{$request->db_image_field} = $directory2;

                        $image = $request->file('image_uploaded');
                         $imageName = $image->getClientOriginalName();
                         $productImage->image_name = $imageName;
                         if ($request->folder == '3D_Image') {
                             $productImage->image_type = 1;
                         } else if($request->folder == 'Close_Up_Image') {
                             $productImage->image_type = 3;
                         } else if($request->folder == 'Branding_Image') {
                             $productImage->image_type = 4;
                         } else if($request->folder == 'Studio_Image') {
                            $productImage->image_type = 5;
                        } else {
                             $productImage->image_type = 2;
                         }
                         $productImage->save();
                     }

                     return json_encode([
                        'responce'=>'success',
                        'meessage'=>$request->file_category.' Image Uploaded Sucessfully',
                    ]);

                    // if ($this->getDirrectryId($parentFolder, $request->product_no)) {
                    //     $productDirectoryId = $this->getDirrectryId($parentFolder, $request->product_no);
                    // } else {
                    //     // Create the subfolder
                    //     Storage::disk('google')->makeDirectory($parentFolder . '/' . $request->product_no);
                    //     $productDirectoryId = $this->getDirrectryId($parentFolder, $request->product_no);
                    // }
                    // if($productDirectoryId){
                    //     $productImagesFolder = $this->getDirrectryId($productDirectoryId, $request->folder);
                    //     if($productImagesFolder){
                    //         $productImagesFolderId = $productImagesFolder;
                    //     } else {
                    //         Storage::disk('google')->makeDirectory($productDirectoryId . '/' . $request->folder);
                    //         $productImagesFolderId = $this->getDirrectryId($productDirectoryId, $request->folder);
                    //     }

                    //     $stored_file = Storage::disk('google')->putFileAs($productImagesFolderId, $request->file('image_uploaded'), $fileName);
                    //     $url = Storage::disk('google')->url($stored_file);

                    //     $qry = Product::where('product_no', $request->product_no)->first();
                    //     $qry->update([$request->db_field=>$url]);

                    //     if (isset($request->db_image_field)) {
                    //        $productImage = new ProductImage();
                    //        $productImage->product_id = $request->product_id;
                    //        $productImage->{$request->db_image_field} = $url;

                    //        $image = $request->file('image_uploaded');
                    //         $imageName = $image->getClientOriginalName();
                    //         $productImage->image_name = $imageName;
                    //         if ($request->folder == '3D_Image') {
                    //             $productImage->image_type = 1;
                    //         } else if($request->folder == 'Close_Up_Image') {
                    //             $productImage->image_type = 3;
                    //         } else if($request->folder == 'Branding_Image') {
                    //             $productImage->image_type = 4;
                    //         } else {
                    //             $productImage->image_type = 2;
                    //         }
                    //         $productImage->save();
                    //     }

                    //     return json_encode([
                    //         'responce'=>'success',
                    //         'meessage'=>$request->file_category.' Image Uploaded Sucessfully',
                    //     ]);
                    // }
                }

            } else {
                return json_encode([
                    'responce'=>'error',
                    'meessage'=>$request->file_category.' File Not Found!',
                ]);
            }
        } catch (\Throwable $th) {
            return json_encode([
                'responce'=>'error',
                'meessage'=>$th->getMessage(),
            ]);
        }
    }

    public function uploadImage_temp(Request $request){
        try {
            $parentFolder = $this->parentFolder;
            $project = Project::findOrFail($request->project_id);
            if($request->hasFile('image_uploaded')){
                $file = $request->file('image_uploaded');

                if(!isset($request->db_image_field)){
                    $directory_test = base_path('assets/Product Master Temp/' . $request->project_id .'/'. $request->product_no. '/' . $request->folder);

                    File::makeDirectory($directory_test, 0777, true, true);

                    $directory = '/Product Master Temp'.'/'.$request->project_id.'/'. $request->product_no.'/' .$request->folder ;
                    
                    if ($project->product_level === 1) {
                        $targetModel = ProductTemp::findOrFail($project->product_id);
                    } else {
                        $targetModel = SubProductTemp::findOrFail($project->product_id);
                    }

                    if($request->db_field == 'mockup_img_1'){
                        $filename = 'front.' . $file->getClientOriginalExtension();
                    }elseif($request->db_field == 'mockup_img_2'){
                        $filename = 'side.' . $file->getClientOriginalExtension();
                    }elseif($request->db_field == 'mockup_img_3'){
                        $filename = 'back.' . $file->getClientOriginalExtension();
                    }elseif($request->db_field == '2D_mockup'){
                        $filename = $request->project_id .'-'. $request->product_no.'_2D_mockup_template.' . $file->getClientOriginalExtension();
                    }elseif($request->db_field == '3D_mockup'){
                        $filename = $request->project_id .'-'. $request->product_no.'_3D_mockup_template.' . $file->getClientOriginalExtension();
                    }elseif($request->db_field == 'tech_pack'){
                        $filename = $request->project_id .'-'. $request->product_no.'_design_tech_pack.' . $file->getClientOriginalExtension();
                    }elseif($request->db_field == 'measurement'){
                        $filename = $request->project_id .'-'. $request->product_no.'_measurement_chart.' . $file->getClientOriginalExtension();
                    }elseif($request->db_field == 'product_layout'){
                        $filename = $request->project_id .'-'. $request->product_no.'_production_layouts.' . $file->getClientOriginalExtension();
                    }elseif($request->db_field == 'pattern'){
                        $filename = $request->project_id .'-'. $request->product_no.'_pattern_file.' . $file->getClientOriginalExtension();
                    }elseif($request->db_field == 'technical_tech_pack'){
                        $filename = $request->project_id .'-'. $request->product_no.'_technical_tech_pack.' . $file->getClientOriginalExtension();
                    }elseif($request->db_field == 'size_chart'){
                        $filename = $request->project_id .'-'. $request->product_no.'_size_chart.' . $file->getClientOriginalExtension();
                    }

                    $file->move($directory_test, $filename);
                    $targetModel->{$request->db_field} = $directory.'/'.$filename;
                    $targetModel->save();

                    return json_encode([
                        'responce'=>'success',
                        'data' => $targetModel,
                        'meessage'=>$request->file_category.' Image Uploaded Sucessfully',
                    ]);
                }else{

                    $fileName = $file->getClientOriginalName();

                    $directoryPath = base_path('assets/Product Master Temp/' . $request->project_id .'/'.$request->product_no. '/' . $request->folder);

                    $directory2 = 'assets/Product Master Temp/'
                        . $request->project_id . '/' . $request->product_no . '/'
                        . $request->folder . '/'
                        . $fileName;

                    if (!File::exists($directoryPath)) {
                        File::makeDirectory($directoryPath, 0777, true, true);
                    }

                    $file->move($directoryPath, $fileName);

                    if (isset($request->db_image_field)) {
                        if ($project->product_level === 1) {
                            $productImage = new ProductImageTemp();
                        } else {
                            $productImage = new SubProductImageTemp();
                            $productImage->sub_product_no = $request->product_no;
                        }
                        
                        $productImage->product_id = $request->product_id;
                        $productImage->{$request->db_image_field} = '/'.$directory2;

                        $image = $request->file('image_uploaded');
                        $imageName = $image->getClientOriginalName();
                        $productImage->image_name = $imageName;
                        if ($request->folder == '3D_Image') {
                            $productImage->image_type = 1;
                        } else if($request->folder == 'Close_Up_Image') {
                            $productImage->image_type = 3;
                        } else if($request->folder == 'Branding_Image') {
                            $productImage->image_type = 4;
                        } else if($request->folder == 'Studio_Image') {
                        $productImage->image_type = 5;
                        } else {
                             $productImage->image_type = 2;
                        }
                        $productImage->save();
                    }

                     return json_encode([
                        'responce'=>'success',
                        'data' => $productImage,
                        'meessage'=>$request->file_category.' Image Uploaded Sucessfully',
                    ]);

                    
                }

            } else {
                return json_encode([
                    'responce'=>'error',
                    'meessage'=>$request->file_category.' File Not Found!',
                ]);
            }
        } catch (\Throwable $th) {
            return json_encode([
                'responce'=>'error',
                'meessage'=>$th->getMessage(),
            ]);
        }
    }

    public function delete($id) {
        // Check if there are orders for the product
        $hasOrders = OrderItem::where('product_id', $id)->exists();

        if ($hasOrders) {
            return redirect()->back()->with('error', 'This product is related to an order. Therefore, it cannot be deleted.');
        } else {
            // Find the product in the database
            $product = Product::find($id);

            if ($product) {
                // Update the 'active' column to '0'
                $product->active = 0; //Deleted
                $product->save();

                // return response()->json(['success' => 'Product Deleted Successfully!']);
                return redirect()->route('products')->with('success', 'Sub product ' . $id . ' deleted successfully !');
            }
        }

        // If the product was not found or an error occurred, return an error response
        return response()->json(['error' => 'Product deletion failed.']);
    }



    public function setStatus($id,$status){
        $product = Product::find($id);
        $product->active = $status;
        $product->update();

        return redirect()->back()->withSuccess('Status Updated Successfully!');
    }

    public function active($id){
        $product = Product::find($id);
        $product->active = 1;
        $product->update();

        return redirect()->back()->withSuccess('Product Activated Successfully!');
    }

    public function edit($id){

        $product = Product::orderBy('product_name')->find($id);
        // $productSize = ProductSize::where('product_id', $id)Storage::disk('google')->getMetadata($product->mockup_img_1)->get()->pluck('id');
        $productFabric = ProductFabric::where('product_id', $id)->get()->pluck('fabric_id');
        $productEmbellishmentType = ProductEmbellishmentType::where('product_id', $id)->get()->pluck('embellishment_type_id');
        $productCategoryList = ProductCategoryList::where('product_id', $id)->get()->pluck('product_category_id');
        $productAttributes = ProductAttribute::where('product_id', $id)->get()->pluck('attribute_id');
        $productMainCategory = ProductMainCategory::where('product_id', $id)->get()->pluck('main_category_id');
        $productFactories = ProductFactory::where('product_id', $id)->get()->pluck('product_factory_id');
        $productSports = ProductSport::where('product_id', $id)->get()->pluck('sport_id');
        // $mainCategories = MainCategory::get()->pluck('main_category_id');
        $productImagesList = ProductImage::where('product_id', $id)->get();
        $prices = Price::where('product_id', $id)->where('active', 1)->get();

        $data = [];
        if($product->mockup_img_1){
            $data['mockup_front_name'] = Storage::disk('google')->getMetadata( $this->getFileId($product->mockup_img_1) );
        }

        if($product->mockup_img_2){
            $data['mockup_side_name'] = Storage::disk('google')->getMetadata( $this->getFileId($product->mockup_img_2) );
        }

        if($product->mockup_img_3){
            $data['mockup_back_name'] = Storage::disk('google')->getMetadata( $this->getFileId($product->mockup_img_3) );
        }

        if($product['2D_mockup']){
            $data['2D_mockup'] = Storage::disk('google')->getMetadata( $this->getFileId($product['2D_mockup']) );
        }

        if($product['3D_mockup']){
            $data['3D_mockup'] = Storage::disk('google')->getMetadata( $this->getFileId($product['3D_mockup']) );
        }

        if($product->tech_pack){
            $data['tech_pack'] = Storage::disk('google')->getMetadata( $this->getFileId($product->tech_pack) );
        }

        if($product->measurement){
            $data['measurement'] = Storage::disk('google')->getMetadata( $this->getFileId($product->measurement) );
        }

        if($product->product_layout){
            $data['product_layout'] = Storage::disk('google')->getMetadata( $this->getFileId($product->product_layout) );
        }

        if($product->pattern){
            $data['pattern'] = Storage::disk('google')->getMetadata( $this->getFileId($product->pattern) );
        }
        if($product->technical_tech_pack){
            $data['technical_tech_pack'] = Storage::disk('google')->getMetadata( $this->getFileId($product->technical_tech_pack) );
        }

        return json_encode(array($product, $productFabric, $productEmbellishmentType, $productCategoryList, $productAttributes, $productFactories, $productSports, $data, $productImagesList, $prices, $productMainCategory));
    }

    public function getFileId($url){
        $queryString = parse_url($url, PHP_URL_QUERY);
        parse_str($queryString, $params);
        return $params['id'];
    }

    public function update(Request $request){
        // $category = array();
        // foreach($request->edit_product_category_id as $categories){
        //     $newCategory = array($categories);
        //     array_push($category, $newCategory);
        // }
        // $category = json_encode($category);

        $product = Product::find($request->product_id);
        $product->product_name = $request->edit_product_name;
        $product->product_no = $request->edit_product_no;
        $product->pattern_code = $request->edit_pattern_code;
        $product->MOQ = $request->MOQ;
        // $product->sport = $request->edit_sport;
        $product->gender = $request->edit_gender;
        $product->default_price = $request->edit_default_price;
        $product->description = $request->edit_description;
        $product->size_id = $request->edit_size_id;
        $product->fabric_id = $request->edit_standard_fabric_id;
        $product->weight = $request->edit_weight;
        $product->notes = $request->edit_notes;

        if($request->has('edit_mockup_img_1')){
            $mockup_img_1 = self::uploadMockupImg($request, $request->product_id, 1, 2);
            if($mockup_img_1 != "default_img.jpg"){
                $product->mockup_img_1 = $mockup_img_1;
            }
        }

        if($request->has('edit_mockup_img_2')){
            $mockup_img_2 = self::uploadMockupImg($request, $request->product_id, 2, 2);
            if($mockup_img_2 != "default_img.jpg"){
                $product->mockup_img_2 = $mockup_img_2;
            }
        }

        if($request->has('edit_mockup_img_3')){
            $mockup_img_3 = self::uploadMockupImg($request, $request->product_id, 3, 2);
            if($mockup_img_3 != "default_img.jpg"){
                $product->mockup_img_3 = $mockup_img_3;
            }
        }

        $product->update();

        $sizeByType = Size::select('id')->where('size_type', $request->edit_size_id)->get();
        $sizeArray = array();
        foreach($sizeByType as $sizes){
            $newSize = array($sizes['id']);
            $newSize = implode(', ', $newSize);
            array_push($sizeArray, $newSize);
        }

        $productSizes = ProductSize::where('product_id', $product->id)->get();
        $productId = $product->id;
        if ($productSizes) {
            ProductSize::where('product_id', $product->id)->delete();
            foreach($sizeArray as $sizes){
                $productSize = new ProductSize();
                $productSize->product_id = $productId;
                $productSize->size_id = $sizes;
                $productSize->save();
            }
        } else {
            foreach($sizeArray as $sizes){
                $productSize = new ProductSize();
                $productSize->product_id = $productId;
                $productSize->size_id = $sizes;
                $productSize->save();
            }
        }

        ProductFabric::where('product_id', $request->product_id)->delete();
        if($request->edit_fabric_id){
            foreach($request->edit_fabric_id as $fabrics){
                $productFabric = new ProductFabric();
                $productFabric->product_id = $product->id;
                $productFabric->fabric_id = $fabrics;
                $productFabric->save();
            }
        }

        ProductEmbellishmentType::where('product_id', $request->product_id)->delete();
        if($request->edit_embellishment_type_id){
            foreach($request->edit_embellishment_type_id as $embellishmentTypes){
                $productEmbellishmentType = new ProductEmbellishmentType();
                $productEmbellishmentType->product_id = $product->id;
                $productEmbellishmentType->embellishment_type_id = $embellishmentTypes;
                $productEmbellishmentType->save();
            }
        }

        ProductCategoryList::where('product_id', $request->product_id)->delete();
        if($request->edit_product_category_id){
            foreach($request->edit_product_category_id as $productCategory){
                $productCategoryList = new ProductCategoryList();
                $productCategoryList->product_id = $product->id;
                $productCategoryList->product_category_id = $productCategory;
                $productCategoryList->save();
            }
        }

        ProductAttribute::where('product_id', $request->product_id)->delete();
        if($request->edit_product_attribute_id){
            foreach($request->edit_product_attribute_id as $productAttributeID){
                $productAttribute = new ProductAttribute();
                $productAttribute->product_id = $product->id;
                $productAttribute->attribute_id = $productAttributeID;
                $productAttribute->save();
            }
        }

        ProductFactory::where('product_id', $request->product_id)->delete();
        if($request->edit_product_factory_id){
            foreach($request->edit_product_factory_id as $productFactoryID){
                $productFactory = new ProductFactory();
                $productFactory->product_id = $product->id;
                $productFactory->product_factory_id = $productFactoryID;
                $productFactory->save();
            }
        }

        return redirect()->route('products')->withSuccess('Product Updated Successfully!');
    }

    public function sortApphabet($id){
        $products = Product::where('product_name', 'LIKE', $id.'%')->where('active', 1)->orderBy('product_no')->get();

        return json_encode($products);
    }

    public function layout(Request $request)
    {
        $user_id = Auth::user()->id;
        $productLayout = ProductLayout::where('user_id', $user_id)->first();

        if (!$productLayout) {
            $productLayout = new ProductLayout();
            $productLayout->user_id = $user_id;
        }

        $productLayout->product_no = $request->has('product_no') ? $request->input('product_no') : $productLayout->product_no;
        $productLayout->product_name = $request->has('product_name') ? $request->input('product_name') : $productLayout->product_name;
        $productLayout->product_category_id = $request->has('product_category_id') ? $request->input('product_category_id') : $productLayout->product_category_id;
        $productLayout->main_category_id = $request->has('main_category_id') ? $request->input('main_category_id') : $productLayout->main_category_id;
        $productLayout->sport = $request->has('sport') ? $request->input('sport') : $productLayout->sport;
        $productLayout->gender = $request->has('gender') ? $request->input('gender') : $productLayout->gender;
        $productLayout->default_price = $request->has('default_price') ? $request->input('default_price') : $productLayout->default_price;
        $productLayout->pattern_code = $request->has('pattern_code') ? $request->input('pattern_code') : $productLayout->pattern_code;
        $productLayout->product_size = $request->has('product_size') ? $request->input('product_size') : $productLayout->product_size;
        $productLayout->standard_fabric = $request->has('standard_fabric') ? $request->input('standard_fabric') : $productLayout->standard_fabric;
        $productLayout->fabric_options = $request->has('fabric_options') ? $request->input('fabric_options') : $productLayout->fabric_options;
        $productLayout->embellishment_options = $request->has('embellishment_options') ? $request->input('embellishment_options') : $productLayout->embellishment_options;
        $productLayout->attributes = $request->has('attributes') ? $request->input('attributes') : $productLayout->attributes;
        $productLayout->weight = $request->has('weight') ? $request->input('weight') : $productLayout->weight;
        $productLayout->factories = $request->has('factories') ? $request->input('factories') : $productLayout->factories;
        $productLayout->status = $request->has('status') ? $request->input('status') : $productLayout->status;
        $productLayout->description = $request->has('description') ? $request->input('description') : $productLayout->description;
        $productLayout->notes = $request->has('notes') ? $request->input('notes') : $productLayout->notes;
        $productLayout->created_at = $request->has('created_at') ? $request->input('created_at') : $productLayout->created_at;
        $productLayout->updated_at = $request->has('updated_at') ? $request->input('updated_at') : $productLayout->updated_at;

        $productLayout->save();

        $successMsg = "Updated";
        return json_encode($successMsg);
    }

    // public function layout(Request $request){
    //     if(ProductLayout::where('user_id', Auth::user()->id)->first()){
    //         $productLayout = ProductLayout::find($request->layout_id);
    //         $productLayout->product_no = $request->product_no;
    //         $productLayout->product_name = $request->product_name;
    //         $productLayout->product_category_id = $request->product_category_id;
    //         $productLayout->main_category_id = $request->main_category_id;
    //         $productLayout->sport = $request->sport;
    //         $productLayout->gender = $request->gender;
    //         $productLayout->default_price = $request->default_price;

    //         $productLayout->pattern_code = $request->pattern_code;
    //         $productLayout->product_size = $request->product_size;
    //         $productLayout->standard_fabric = $request->standard_fabric;
    //         $productLayout->fabric_options = $request->fabric_options;
    //         $productLayout->embellishment_options = $request->embellishment_options;
    //         $productLayout->attributes = $request->pro_attributes;
    //         $productLayout->weight = $request->weight;
    //         $productLayout->factories = $request->factories;
    //         $productLayout->status = $request->status;

    //         $productLayout->description = $request->description;
    //         $productLayout->notes = $request->notes;
    //         $productLayout->created = $request->created_at;
    //         $productLayout->updated = $request->updated_at;
    //         $productLayout->update();

    //         $successMsg = "Updated";

    //     } else {
    //         $productLayout = new ProductLayout();
    //         $productLayout->user_id = Auth::user()->id;
    //         $productLayout->product_no = 1;
    //         $productLayout->product_name = 1;
    //         $productLayout->product_category_id = 1;
    //         $productLayout->main_category_id = 1;
    //         $productLayout->sport = 1;
    //         $productLayout->gender = 1;
    //         $productLayout->default_price = 1;

    //         $productLayout->pattern_code = 1;
    //         $productLayout->product_size = 1;
    //         $productLayout->standard_fabric = 1;
    //         $productLayout->fabric_options = 1;
    //         $productLayout->embellishment_options = 1;
    //         $productLayout->attributes = 1;
    //         $productLayout->weight = 1;
    //         $productLayout->factories = 1;
    //         $productLayout->status = 1;

    //         $productLayout->description = 1;
    //         $productLayout->notes = 1;
    //         $productLayout->created = 1;
    //         $productLayout->updated = 1;
    //         $productLayout->save();

    //         $successMsg = "Saved";
    //     }

    //     return json_encode($successMsg);
    // }

    public function uploadMockupImg(Request $request, $productID, $imageID, $typeID) {

        $file = null;

        if($typeID == 1){
            $file = $request->file('mockup_img_'.$imageID);
        }else if($typeID == 2){
            $file = $request->file('edit_mockup_img_'.$imageID);
        }

        if($file->getClientOriginalName() != "default_img.jpg"){
            $destinationPath = 'uploads/products/'.$productID;
            $file->move($destinationPath, $file->getClientOriginalName());
        }

        return $file->getClientOriginalName();
    }

    public function exportCsv()
    {
        $products = Product::where('active', 1)->get();
        $productSports = ProductSport::get();
        $sports = Sport::get();
        $mainCategories = MainCategory::get();
        $productMainCategories = ProductMainCategory::select('product_id', 'main_category_id')->groupBy('product_id', 'main_category_id')->get();
        $productStyleLists = ProductCategoryList::get();
        $productStyle = ProductCategory::get();
        $sizeTypes = SizeType::get();
        $productFabrics = ProductFabric::select('product_id', 'fabric_id')->groupBy('product_id', 'fabric_id')->get();
        $fabrics = Fabric::get();

        $productFactories = ProductFactory::select('product_id', 'product_factory_id')->groupBy('product_id', 'product_factory_id')->get();
        $factories = Factory::get();

        $productSportMap = [];
        $productStyleMap = [];
        $productFabricMap = [];

        // Create a mapping of product IDs to an array of sport IDs
        foreach ($productSports as $productSport) {
            $productSportMap[$productSport->product_id][] = $productSport->sport_id;
        }

        // Create a mapping of product IDs to an array of style IDs
        foreach ($productStyleLists as $productStyleList) {
            $productStyleMap[$productStyleList->product_id][] = $productStyleList->product_category_id;
        }

        // Create a mapping of product IDs to an array of fabric IDs
        foreach ($productFabrics as $productFabric) {
            $productFabricMap[$productFabric->product_id][] = $productFabric->fabric_id;
        }

        $csvContent = "Product No,Product Name,Pattern Code,Sports,Gender, Default Price ($), Product Category, Product Styles, Size, Statndard Fabric, Fabric Options, Factory, Weight\n";

        foreach ($products as $product) {
            // Get the sport IDs for the current product
            $sportIds = $productSportMap[$product->id] ?? [];

            // Get the style IDs for the current product
            $styleIds = $productStyleMap[$product->id] ?? [];

            // Get the fabric IDs for the current product
            $fabricIds = $productFabricMap[$product->id] ?? [];

            // Find the corresponding sport names using the sport IDs
            $uniqueSportNames = [];

            // Find the corresponding sport names using the style IDs
            $uniqueStyleNames = [];

            // Find the corresponding sport names using the style IDs
            $uniqueFabricNames = [];

            foreach ($sportIds as $sportId) {
                $sport = $sports->where('id', $sportId)->first();
                if ($sport) {
                    $uniqueSportNames[$sport->sport_name] = $sport->sport_name;
                }
            }

            foreach ($styleIds as $styleId) {
                $style = $productStyle->where('id', $styleId)->first();
                if ($style) {
                    $uniqueStyleNames[] = $style->product_category_name;
                }
            }

            foreach ($fabricIds as $fabricId) {
                $fabric = $fabrics->where('id', $fabricId)->first();
                if ($style) {
                    $uniqueFabricNames[] = $fabric->fabric_name;
                }
            }

            if (isset($product->sport)) {
                $uniqueSportNames[$product->sport] = $product->sport;
            }

            if (isset($product->product_category_id)) {
                $uniqueStyleNames[$product->product_category_id] = $product->product_category_id;
            }

            if (isset($product->fabric_options)) {
                $uniqueFabricNames[$product->fabric_options] = $product->fabric_options;
            }

            // Combine unique sport names
            $combinedSportNames = implode(', ', $uniqueSportNames);

            // Combine unique Style names
            $combinedStyleNames = implode(', ', $uniqueStyleNames);

            // Combine unique Fabric names
            $combinedFabricNames = implode(', ', $uniqueFabricNames);


            //Multiple main categories

            $mainCategoryIds = [];

            foreach ($productMainCategories as $productMainCategory){
                if($productMainCategory->product_id == $product->id){
                    foreach($mainCategories as $mainCategory){
                        if($productMainCategory->main_category_id == $mainCategory->id){
                            $mainCategoryIds[] = $mainCategory->category_name;
                        }
                    }
                }
            }


            if(count($mainCategoryIds) > 0){
                $mainCategoryName = implode(', ', $mainCategoryIds);
            }else{
                $mainCategory = $mainCategories->where('id', $product->main_category_id)->first();
                $mainCategoryName = $mainCategory ? $mainCategory->category_name : '';
            }

            //Multiple factories

            $factoryIds = [];

            foreach ($productFactories as $productFactory){
                if($productFactory->product_id == $product->id){
                    foreach($factories as $factory){
                        if($productFactory->product_factory_id == $factory->id){
                            $factoryIds[] = $factory->factory_code;
                        }
                    }
                }
            }


            if(count($factoryIds) > 0){
                $factoryName = implode(', ', $factoryIds);
            }else{
                $factoryName = $product->factory;
            }


            $productSize = $sizeTypes->where('id', $product->size_id)->first();
            $productSizeName = $productSize ? $productSize->type_name : '';

            // Remove square brackets and quotes from combined style names
            $combinedStyleNames = preg_replace('/\[\"(.*?)\"\]/', '$1', $combinedStyleNames);
            $combinedStyleNames = preg_replace('/\["(.*?)"\]/', '$1', $combinedStyleNames);

        // Remove any extra commas and spaces resulting from formatting
        $combinedStyleNames = preg_replace('/,\s*,/', ',', $combinedStyleNames);
        $combinedStyleNames = trim($combinedStyleNames, ', ');

            $csvContent .= "{$product->product_no},\"{$product->product_name}\",{$product->pattern_code},\"{$combinedSportNames}\",{$product->gender},\"{$product->default_price}\",\"{$mainCategoryName}\",\"{$combinedStyleNames}\",\"{$productSizeName}\",\"{$product->standard_fabric}\",\"{$combinedFabricNames}\",\"{$factoryName}\",\"{$product->weight}\"\n";
        }

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=products.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        return response()->stream(
            function () use ($csvContent) {
                echo $csvContent;
            },
            200,
            $headers
        );
    }
    public function removeImages(Request $request){

        $ProductImg = ProductImage::where('id', $request->imgID)->first();

        if($ProductImg){
        $ProductImg->active = 0; //Deleted status
        $ProductImg->update();

            return response()->json([
                'responce'=>'success',
                'meessage'=>'Image Deleted Sucessfully',
            ]);
        }else{
            return response()->json([
                'responce'=>'error',
                'meessage'=>'File Not Found!',
            ]);
        }

    }

    public function removeImagesTemp(Request $request)
    {
        try {

            $productImg = ProductImageTemp::find($request->imgID);

            if (!$productImg) {
                return response()->json([
                    'responce' => 'error',
                    'meessage' => 'File Not Found!',
                ]);
            }

            $relativePath = $productImg->image_link; 

            $fullPath = base_path($relativePath);

            if ($relativePath && File::exists($fullPath)) {
                File::delete($fullPath);
            }

            $productImg->delete();

            return response()->json([
                'responce' => 'success',
                'meessage' => 'Image Deleted Successfully',
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'responce' => 'error',
                'meessage' => $th->getMessage(),
            ]);
        }
    }

    public function getImageCaption(Request $request)
    {
        $productId = $request->input('productId');
        $imageCaptionType = $request->input('imageCaptionType');

        $productImageCaption = null;

        $product = Product::where('id', $productId)->first();

        if ($product) {
            if ($imageCaptionType == 'mockup_img_1') {
                $productImageCaption = $product->mockup_caption_1;
            }
            if ($imageCaptionType == 'mockup_img_2') {
                $productImageCaption = $product->mockup_caption_2;
            }
            if ($imageCaptionType == 'mockup_img_3') {
                $productImageCaption = $product->mockup_caption_3;
            }
        }

        return response()->json(['productImageCaption' => $productImageCaption]);
    }

    public function getImageCaptionTemp(Request $request) {

        $projectId = $request->input('projectId');
        $imageCaptionType = $request->input('imageCaptionType');

        $productImageCaption = null;

        $poject = Project::findOrFail($projectId);
        if ($poject->product_level == 1) {
            $productTemp = ProductTemp::findOrFail($poject->product_id);
            if ($productTemp) {
                $product = $productTemp;
            } else {
                return response()->json(['message' => 'Product not found'], 404); 
            }
        } else {
            $subProductTemp = SubProductTemp::findOrFail($poject->product_id);
            if ($subProductTemp) {
                $product = $subProductTemp;
            } else {
                return response()->json(['message' => 'Sub Product not found'], 404); 
            }
        }

        if ($product) {
            if ($imageCaptionType == 'mockup_img_1') {
                $productImageCaption = $product->mockup_caption_1;
            }
            if ($imageCaptionType == 'mockup_img_2') {
                $productImageCaption = $product->mockup_caption_2;
            }
            if ($imageCaptionType == 'mockup_img_3') {
                $productImageCaption = $product->mockup_caption_3;
            }
        }

        return response()->json(['productImageCaption' => $productImageCaption]);
    }

    public function getOtherImageCaption(Request $request)
    {
        $productId = $request->input('productId');
        $imageId = $request->input('imageId');

        $productImageCaption = null;

        $productImage = ProductImage::where('product_id', $productId)->where('id', $imageId)->first();

        if ($productImage) {
            $productImageCaption = $productImage->image_caption;
        }

        return response()->json(['productImageCaption' => $productImageCaption]);
    }

     public function getOtherImageCaptionTemp(Request $request) {
        $productId = $request->input('productId');
        $imageId = $request->input('imageId');

        $productImageCaption = null;

        $productImage = ProductImageTemp::where('product_id', $productId)->where('id', $imageId)->first();

        if ($productImage) {
            $productImageCaption = $productImage->image_caption;
        }

        return response()->json(['productImageCaption' => $productImageCaption]);
    }

    public function saveProductImageCaption(Request $request){

        $productId = $request->input('productId');
        $imageType = $request->input('imageType');
        $imageCaption = $request->input('caption');

        $product = Product::where('id', $productId)->first();

        if ($product) {
            if ($imageType == 'mockup_img_1') {
                $product->mockup_caption_1 = $imageCaption;
                $product->save();
            }
            if ($imageType == 'mockup_img_2') {
                $product->mockup_caption_2 = $imageCaption;
                $product->save();
            }
            if ($imageType == 'mockup_img_3') {
                $product->mockup_caption_3 = $imageCaption;
                $product->save();
            }
        }
    }

    public function saveProductImageCaptionTemp(Request $request)
    {
        $projectId    = $request->input('projectId');  
        $imageType    = $request->input('imageType');  
        $imageCaption = $request->input('caption');


        $poject = Project::findOrFail($projectId);
        if ($poject->product_level == 1) {
            $productTemp = ProductTemp::findOrFail($poject->product_id);
            if ($productTemp) {
                $target = $productTemp;
            } else {
                return response()->json(['message' => 'Product not found'], 404); 
            }
        } else {
            $subProductTemp = SubProductTemp::findOrFail($poject->product_id);
            if ($subProductTemp) {
                $target = $subProductTemp;
            } else {
                return response()->json(['message' => 'Sub Product not found'], 404); 
            }
        }

        switch ($imageType) {
            case 'mockup_img_1':
                $target->mockup_caption_1 = $imageCaption;
                break;

            case 'mockup_img_2':
                $target->mockup_caption_2 = $imageCaption;
                break;

            case 'mockup_img_3':
                $target->mockup_caption_3 = $imageCaption;
                break;

            default:
                return response()->json(['message' => 'Invalid image type'], 400);
        }

        $target->save();

        return response()->json(['message' => 'Caption saved successfully']);
    }

    public function saveOtherImageCaption(Request $request){

        $productId = $request->input('productId');
        $imageID = $request->input('imageID');
        $imageCaption = $request->input('caption');

        $productImage = ProductImage::where('product_id', $productId)->where('id', $imageID)->first();

        if ($productImage) {
            $productImage->image_caption = $imageCaption;
            $productImage->save();
        }
    }

    public function saveOtherImageCaptionTemp(Request $request)
    {
        $productId = $request->input('productId'); 
        $imageID   = $request->input('imageID');
        $caption   = $request->input('caption');


        $productTemp = ProductImageTemp::where('product_id', $productId)
            ->where('id', $imageID)
            ->first();


        if (!$productTemp) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $productTemp->image_caption = $caption;
        $productTemp->save();

        return response()->json(['message' => 'Caption updated successfully']);
        

    }

    public function deleteProductImageCaption(Request $request){

        $productId = $request->input('productId');
        $imageType = $request->input('imageType');

        $product = Product::where('id', $productId)->first();

        if ($product) {
            if ($imageType == 'mockup_img_1') {
                $product->mockup_caption_1 = null;
                $product->save();
            }
            if ($imageType == 'mockup_img_2') {
                $product->mockup_caption_2 = null;
                $product->save();
            }
            if ($imageType == 'mockup_img_3') {
                $product->mockup_caption_3 = null;
                $product->save();
            }
        }
    }

    public function deleteProductImageCaptionTemp(Request $request)
    {
        $projectId    = $request->input('projectId');    
        $imageType = $request->input('imageType'); 


        $poject = Project::findOrFail($projectId);
        if ($poject->product_level == 1) {
            $productTemp = ProductTemp::findOrFail($poject->product_id);
            if ($productTemp) {
                $target = $productTemp;
            } else {
                return response()->json(['message' => 'Product not found'], 404); 
            }
        } else {
            $subProductTemp = SubProductTemp::findOrFail($poject->product_id);
            if ($subProductTemp) {
                $target = $subProductTemp;
            } else {
                return response()->json(['message' => 'Sub Product not found'], 404); 
            }
        }

       
        switch ($imageType) {
            case 'mockup_img_1':
                $target->mockup_caption_1 = null;
                break;

            case 'mockup_img_2':
                $target->mockup_caption_2 = null;
                break;

            case 'mockup_img_3':
                $target->mockup_caption_3 = null;
                break;

            default:
                return response()->json(['message' => 'Invalid image type'], 400);
        }

        $target->save();

        return response()->json(['message' => 'Caption deleted successfully']);
    }

    public function deleteOtherImageCaption(Request $request){

        $productId = $request->input('productId');
        $imageID = $request->input('imageID');

        $productImage = ProductImage::where('product_id', $productId)->where('id', $imageID)->first();

        if ($productImage) {
            $productImage->image_caption = null;
            $productImage->save();
        }
    }


    public function deleteOtherImageCaptionTemp(Request $request){

        $productId = $request->input('productId');
        $imageID = $request->input('imageID');

        $productImage = ProductImageTemp::where('product_id', $productId)->where('id', $imageID)->first();

        if ($productImage) {
            $productImage->image_caption = null;
            $productImage->save();
        }
    }

    public function view_product_sports(){
        if(!Auth::user()->can('view product sports')){
            return redirect()->back()->with('error', 'You are not authorized to access this page.');
        }
        $products = Product::with('productsport')->where('active', 1)->orderBy('id')->get();
        $sports = Sport::where('active', 1)->orderBy('id')->get();
        return view('pages.masters.products.sub_products.product_sports', compact('products', 'sports'));
    }

    public function updateProductSports(Request $request)
    {

        ProductSport::where('product_id', $request->product_id)->forceDelete();
            if (is_array($request->sports) && !empty($request->sports)) {
                foreach($request->sports as $sports){
                    $productSport = new ProductSport();
                    $productSport->product_id = $request->product_id;
                    $productSport->sport_id = $sports;
                    $productSport->save();
                }
            }

        return response()->json(['success' => true]);
    }

    public function exportCsvProductSports()
    {
        $products = Product::with('productsport')->where('active', 1)->orderBy('id')->get();
        $sports = Sport::where('active', 1)->orderBy('id')->get();

        $csvContent = "Product No,Product Name,Sports\n";

        foreach ($products as $product) {
            $sportNames = [];

            foreach ($product->productsport as $productSport) {
                $sport = $sports->where('id', $productSport->sport_id)->first();
                if ($sport) {
                    $sportNames[] = $sport->sport_name;
                }
            }

            $combinedSportNames = implode(', ', $sportNames);

            $csvContent .= "{$product->product_no},\"{$product->product_name}\",\"{$combinedSportNames}\"\n";
        }

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=product_sports.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        return response()->stream(
            function () use ($csvContent) {
                echo $csvContent;
            },
            200,
            $headers
        );
    }

    public function product_move($id)
    {
        DB::beginTransaction();

        try {

            $project = Project::with(['productTemp','subProductTemp'])->findOrFail($id);

            if ($project->product_level == 1) {

                $product = ProductFacade::move_product($project->productTemp, $project->id, $project->product_level);

                $project->productTemp->update(['transferred'=>1, 'transferred_id' => $product->id]);

            } else {

                $product = ProductFacade::move_subproduct($project->subProductTemp, $project->id, $project->product_level);

                $project->subProductTemp->update(['transferred'=>1, 'transferred_id' => $product->id]);
            }

            $projectNo = str_pad((Project::max('id') ?? 0) + 1, 6, '0', STR_PAD_LEFT);

            Project::create([
                'project_name'=>$product->product_name,
                'project_no'=>$projectNo,
                'project_type_id'=>2,
                'product_id'=>$product->id,
                'created_by'=>Auth::id()
            ]);

            DB::commit();

            if ($project->product_level === 1) {
                return redirect()->route('product_process', [
                    'currentId' => $id, 
                    'newId' => $product->id,
                    'level' => $project->product_level
                ]);
            } else {
                return redirect()->route('product_process', [
                    'currentId' => $id, 
                    'newId' => $product->sub_product_no,
                    'level' => $project->product_level
                ]);
            }

        } catch (\Throwable $e) {

            DB::rollBack();
            return redirect()->back()->withError($e->getMessage());
        }
    }


    public function product_process($currentId, $newId, $level) {
        return view('pages.redirect.process', [
            'currentId' => $currentId,   
            'newId' => $newId,
            'level' => (int)$level 
        ]);
    }


    



    


}
