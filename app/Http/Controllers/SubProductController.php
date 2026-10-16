<?php

namespace App\Http\Controllers;

use Storage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Size;
use App\Models\Price;
use App\Models\Sport;
use App\Models\Fabric;
use App\Models\Factory;
use App\Models\SizeType;
use App\Models\Product;
use App\Models\SubProduct;
use App\Models\SubProductImage;
use App\Models\Attribute;
use App\Models\PriceType;
use App\Models\MainCategory;
use App\Models\ProductCategory;
use App\Models\EmbellishmentType;
use App\Models\ColorMaster;
use App\Models\SubProductColor;
use App\Models\ProductMainCategory;
use App\Models\SubProductPrice;
use App\Models\SubProductEmbellishmentOptions;
use App\Models\AttributeOnUnitPrice;
use Illuminate\Support\Facades\File;

class SubProductController extends Controller
{

    protected $parentFolder;

    public function __construct()
    {
        $this->parentFolder = env('PARENT_FOLDER_ID');
    }

    public function index($id){

        $subProductImages = [];

        if($id == null || $id == 0){

        $selectedProduct = null;

        // $sizes = Size::orderBy('id')->where('active', 1)->get();

        // $productCategories = ProductCategory::orderBy('id')->where('active', 1)->get();

        $fabrics = Fabric::orderBy('fabric_name')->where('active', 1)->get();

        $embellishmentTypes = EmbellishmentType::orderBy('embellishment_name')->where('active', 1)->get();

        $productAttributes = Attribute::orderBy('attribute_name')->where('active', 1)->get();

        // $sports = Sport::where('active', 1)->orderBy('sport_name')->get();

        // $factories = Factory::where('active', 1)->orderBy('factory_name')->get();

        // $sizeTypes = SizeType::get();

        // $mainCategories = MainCategory::get();

        $priceTypes = PriceType::get();

        $products = Product::where('active', 1)->orderBy('id')->get();

        $isDisable = 0;

        $subProductCode = 0;

        $colorMasters = ColorMaster::get();

        $subProductColor = SubProductColor::where('sub_product_no', $id)->pluck('color_master_id')->toArray();

        }else{

        $selectedProduct = Product::where('id', $id)->first();

        // $mainCategories = MainCategory::get();

        // $sizes = Size::orderBy('id')->where('active', 1)->get();

        // $productCategories = ProductCategory::orderBy('id')->where('active', 1)->get();

        $fabrics = Fabric::orderBy('fabric_name')->where('active', 1)->get();

        $embellishmentTypes = EmbellishmentType::orderBy('embellishment_name')->where('active', 1)->get();

        $productAttributes = Attribute::orderBy('attribute_name')->where('active', 1)->get();

        // $sports = Sport::where('active', 1)->orderBy('sport_name')->get();

        // $factories = Factory::where('active', 1)->orderBy('factory_name')->get();

        // $sizeTypes = SizeType::get();

        $priceTypes = PriceType::get();

        $products = Product::where('active', 1)->orderBy('id')->get();

        $isDisable = 0;

        $tempCount = SubProduct::where('parent_product_id', $id)->count();
        $ActtempCount = $tempCount + 1;

        $subProductCode = 'PRO-'.$id .'.'.$ActtempCount;

        $colorMasters = ColorMaster::get();

        $subProductColor = SubProductColor::where('sub_product_no', $id)->pluck('color_master_id')->toArray();

        }

        return view('pages.masters.products.sub_products.index', [
            'fabrics'=>$fabrics, 'embellishmentTypes'=>$embellishmentTypes, 'subProductImages' => $subProductImages,
              'isDisable' => $isDisable,'priceTypes'=>$priceTypes, 'products'=>$products, 'selectedProduct'=>$selectedProduct,
             'subProductCode'=>$subProductCode, 'productAttributes'=>$productAttributes, 'colorMasters'=>$colorMasters, 'subProductColor'=>$subProductColor
        ]);
    }
    public function create(Request $request){

        if (auth()->user()->can('edit products')) {
            $requestSubProduct = SubProduct::where('sub_product_no', $request->sub_product_no)->first();
            if($requestSubProduct){

                $requestSubProduct->product_name = $request->sub_product_name;
                $requestSubProduct->show_in_catalog_name = !empty($request->show_in_catalog_name) ? $request->show_in_catalog_name : NULL;
                $requestSubProduct->standard_fabric = $request->standard_fabric;
                $requestSubProduct->pattern_code = $request->sub_product_pattern;
                $requestSubProduct->default_price = $request->price_1;
                $requestSubProduct->weight = $request->sub_product_weight;
                $requestSubProduct->active = $request->active;

                if (isset($request->show_in_catalog)) {
                    $requestSubProduct->show_in_catalog = 1;
                } else {
                    $requestSubProduct->show_in_catalog = 0;
                }

                $filtered_fabric = Fabric::where('fabric_name' ,  $request->standard_fabric)->first();
                if($filtered_fabric){
                    $requestSubProduct->fabric_id = $filtered_fabric->id;
                }

                // if (is_array($request->embellishment_options)) {
                //     $requestSubProduct->type_of_embellishment = implode(' / ', $request->embellishment_options);
                // } else {
                //     $requestSubProduct->type_of_embellishment = '';
                // }
                if (is_array($request->attribute_on_price)) {
                    $requestSubProduct->attribute_on_price = implode(' / ', $request->attribute_on_price);
                } else {
                    $requestSubProduct->attribute_on_price = '';
                }
                $requestSubProduct->notes = $request->sub_product_note;
                $requestSubProduct->description = $request->new_description;
                $requestSubProduct->who_we_made_this_for = $request->who_we_made_this_for;
                $requestSubProduct->product_features = $request->product_features;
                $requestSubProduct->update();

                if (!empty($request->embellishment_options)) {
                    SubProductEmbellishmentOptions::where('sub_product_id', $requestSubProduct->id)->delete();
                    foreach ($request->embellishment_options as $embellishment_option) {
                        $subProductEmbellishmentOptions = new SubProductEmbellishmentOptions();
                        $subProductEmbellishmentOptions->sub_product_id = $requestSubProduct->id;
                        $subProductEmbellishmentOptions->embellishment_option = $embellishment_option;
                        $subProductEmbellishmentOptions->save();
                    }
                }
                if (!empty($request->attribute_on_price)) {
                    AttributeOnUnitPrice::where('sub_product_id', $requestSubProduct->id)->delete();
                    foreach ($request->attribute_on_price as $attribute__id) {
                        $AttributeOnUnitPrice = new AttributeOnUnitPrice();
                        $AttributeOnUnitPrice->sub_product_id = $requestSubProduct->id;
                        $AttributeOnUnitPrice->attribute__id = $attribute__id;
                        $AttributeOnUnitPrice->save();
                    }
                }

                if ($request->price_1 != null) {

                    SubProductPrice::where('active', 1)->where('price_type' , 1)->where('sub_product_no', $request->sub_product_no)->update(['active' => 0,'end_date' => Carbon::now()->format('Y-m-d')]);

                    $currentDate = Carbon::now();
                    $price_1= new SubProductPrice();
                    $price_1->sub_product_no = $request->sub_product_no;
                    $price_1->price_type = 1;
                    $price_1->price = $request->price_1;
                    $price_1->start_date = $currentDate->format('Y-m-d');
                    $price_1->save();
                }
                if ($request->price_2 != null) {

                    SubProductPrice::where('active', 1)->where('price_type' , 2)->where('sub_product_no', $request->sub_product_no)->update(['active' => 0,'end_date' => Carbon::now()->format('Y-m-d')]);

                    $currentDate = Carbon::now();
                    $price_2= new SubProductPrice();
                    $price_2->sub_product_no = $request->sub_product_no;
                    $price_2->price_type = 2;
                    $price_2->price = $request->price_2;
                    $price_2->start_date = $currentDate->format('Y-m-d');
                    $price_2->save();
                }
                if ($request->price_3 != null) {

                    SubProductPrice::where('active', 1)->where('price_type' , 3)->where('sub_product_no', $request->sub_product_no)->update(['active' => 0,'end_date' => Carbon::now()->format('Y-m-d')]);

                    $currentDate = Carbon::now();
                    $price_3= new SubProductPrice();
                    $price_3->sub_product_no = $request->sub_product_no;
                    $price_3->price_type = 3;
                    $price_3->price = $request->price_3;
                    $price_3->start_date = $currentDate->format('Y-m-d');
                    $price_3->save();
                }
                if ($request->price_4 != null) {

                    SubProductPrice::where('active', 1)->where('price_type' , 4)->where('sub_product_no', $request->sub_product_no)->update(['active' => 0,'end_date' => Carbon::now()->format('Y-m-d')]);

                    $currentDate = Carbon::now();
                    $price_4= new SubProductPrice();
                    $price_4->sub_product_no = $request->sub_product_no;
                    $price_4->price_type = 4;
                    $price_4->price = $request->price_4;
                    $price_4->start_date = $currentDate->format('Y-m-d');
                    $price_4->save();
                }
                if ($request->price_5 != null) {

                    SubProductPrice::where('active', 1)->where('price_type' , 5)->where('sub_product_no', $request->sub_product_no)->update(['active' => 0,'end_date' => Carbon::now()->format('Y-m-d')]);

                    $currentDate = Carbon::now();
                    $price_5= new SubProductPrice();
                    $price_5->sub_product_no = $request->sub_product_no;
                    $price_5->price_type = 5;
                    $price_5->price = $request->price_5;
                    $price_5->start_date = $currentDate->format('Y-m-d');
                    $price_5->save();

                    SubProductPrice::where('active', 1)->where('price_type' , 3)->where('sub_product_no', $request->sub_product_no)->update(['active' => 0,'end_date' => Carbon::now()->format('Y-m-d')]);

                    $price_3= new SubProductPrice();
                    $price_3->sub_product_no = $request->sub_product_no;
                    $price_3->price_type = 3;
                    $price_3->price = number_format($price_5->price * 1.5, 2);
                    $price_3->start_date = $currentDate->format('Y-m-d');
                    $price_3->save();

                }

                SubProductColor::where('sub_product_no', $request->sub_product_no)->delete();

                if ($request->has('new_available_colors')) {
                    foreach ($request->new_available_colors as $colorId) {

                        $subProductColor= new SubProductColor();
                        $subProductColor->sub_product_no = $request->sub_product_no;
                        $subProductColor->color_master_id = $colorId;
                        $subProductColor->save();
                    }
                }

                return redirect()->route('sub_products.edit', ['id' => $request->sub_product_no])->with('success', 'Sub product ' . $request->sub_product_no . ' updated successfully !');

            }else{

                $subProduct = new SubProduct();
                $subProduct->parent_product_id = $request->product_name;
                $subProduct->show_in_catalog_name = !empty($request->show_in_catalog_name) ? $request->show_in_catalog_name : NULL;
                $subProduct->product_name = $request->sub_product_name;
                $subProduct->sub_product_no = $request->sub_product_no;
                $subProduct->standard_fabric = $request->standard_fabric;

                $filtered_fabric = Fabric::where('fabric_name' ,  $request->standard_fabric)->first();
                if($filtered_fabric){
                    $subProduct->fabric_id = $filtered_fabric->id;
                }

                $subProduct->pattern_code = $request->sub_product_pattern;
                $subProduct->weight = $request->sub_product_weight;

                if (is_array($request->embellishment_options)) {
                    $subProduct->type_of_embellishment = implode(' / ', $request->embellishment_options);
                } else {
                    $subProduct->type_of_embellishment = '';
                }
                if (is_array($request->attribute_on_price)) {
                    $subProduct->attribute_on_price = implode(' / ', $request->attribute_on_price);
                } else {
                    $subProduct->attribute_on_price = '';
                }
                $subProduct->notes = $request->sub_product_note;
                $subProduct->description = $request->new_description;
                $subProduct->who_we_made_this_for = $request->who_we_made_this_for;
                $subProduct->product_features = $request->product_features;
                $subProduct->active = $request->active;
                if (isset($request->show_in_catalog)) {
                    $subProduct->show_in_catalog = 1;
                }
                $subProduct->save();

                if (!empty($request->embellishment_options)) {
                    SubProductEmbellishmentOptions::where('sub_product_id', $subProduct->id)->delete();
                    foreach ($request->embellishment_options as $embellishment_option) {
                        $subProductEmbellishmentOptions = new SubProductEmbellishmentOptions();
                        $subProductEmbellishmentOptions->sub_product_id = $subProduct->id;
                        $subProductEmbellishmentOptions->embellishment_option = $embellishment_option;
                        $subProductEmbellishmentOptions->save();
                    }
                }

                if (!empty($request->attribute_on_price)) {
                    AttributeOnUnitPrice::where('sub_product_id', $subProduct->id)->delete();
                    foreach ($request->attribute_on_price as $attribute__id) {
                        $AttributeOnUnitPrice = new AttributeOnUnitPrice();
                        $AttributeOnUnitPrice->sub_product_id = $subProduct->id;
                        $AttributeOnUnitPrice->attribute__id = $attribute__id;
                        $AttributeOnUnitPrice->save();
                    }
                }

                if ($request->price_1 != null) {

                    $currentDate = Carbon::now();
                    $price_1= new SubProductPrice();
                    $price_1->sub_product_no = $request->sub_product_no;
                    $price_1->price_type = 1;
                    $price_1->price = $request->price_1;
                    $price_1->start_date = $currentDate->format('Y-m-d');
                    $price_1->save();
                }
                if ($request->price_2 != null) {

                    $currentDate = Carbon::now();
                    $price_2= new SubProductPrice();
                    $price_2->sub_product_no = $request->sub_product_no;
                    $price_2->price_type = 2;
                    $price_2->price = $request->price_2;
                    $price_2->start_date = $currentDate->format('Y-m-d');
                    $price_2->save();
                }
                if ($request->price_3 != null) {

                    $currentDate = Carbon::now();
                    $price_3= new SubProductPrice();
                    $price_3->sub_product_no = $request->sub_product_no;
                    $price_3->price_type = 3;
                    $price_3->price = $request->price_3;
                    $price_3->start_date = $currentDate->format('Y-m-d');
                    $price_3->save();
                }
                if ($request->price_4 != null) {

                    $currentDate = Carbon::now();
                    $price_4= new SubProductPrice();
                    $price_4->sub_product_no = $request->sub_product_no;
                    $price_4->price_type = 4;
                    $price_4->price = $request->price_4;
                    $price_4->start_date = $currentDate->format('Y-m-d');
                    $price_4->save();
                }
                if ($request->price_5 != null) {

                    $currentDate = Carbon::now();
                    $price_5= new SubProductPrice();
                    $price_5->sub_product_no = $request->sub_product_no;
                    $price_5->price_type = 5;
                    $price_5->price = $request->price_5;
                    $price_5->start_date = $currentDate->format('Y-m-d');
                    $price_5->save();

                    SubProductPrice::where('active', 1)->where('price_type' , 3)->where('sub_product_no', $request->sub_product_no)->update(['active' => 0,'end_date' => Carbon::now()->format('Y-m-d')]);

                    $price_3= new SubProductPrice();
                    $price_3->sub_product_no = $request->sub_product_no;
                    $price_3->price_type = 3;
                    $price_3->price = number_format($price_5->price * 1.5, 2);
                    $price_3->start_date = $currentDate->format('Y-m-d');
                    $price_3->save();
                }

                SubProductColor::where('sub_product_no', $request->sub_product_no)->delete();

                if ($request->has('new_available_colors')) {
                    foreach ($request->new_available_colors as $colorId) {

                        $subProductColor= new SubProductColor();
                        $subProductColor->sub_product_no = $request->sub_product_no;
                        $subProductColor->color_master_id = $colorId;
                        $subProductColor->save();
                    }
                }

                return redirect()->route('sub_products.edit', ['id' => $request->sub_product_no])->with('success', 'Sub product ' . $request->sub_product_no . ' created successfully !');

            }
        }else{
            if(auth()->user()->can('edit product description')){
                $product = SubProduct::where('sub_product_no', $request->sub_product_no)->first();
                if($product){
                    $product->description = $request->new_description;
                    $product->who_we_made_this_for = $request->who_we_made_this_for;
                    $product->product_features = $request->product_features;
                    $product->update();

                    return redirect()->route('sub_products.edit', ['id' => $request->sub_product_no])->with('success', 'Sub product ' . $request->sub_product_no . ' updated successfully !');
                }else{
                    return redirect()->back()->withError('Product Not Found!');
                }
            }else{
                return redirect()->back()->withError('Permission Not Granted!');
            }
        }


    }
    public function edit($id){

        $mainCategories = MainCategory::get();

        $sizes = Size::orderBy('id')->where('active', 1)->get();

        $productCategories = ProductCategory::orderBy('id')->where('active', 1)->get();

        $fabrics = Fabric::orderBy('fabric_name')->where('active', 1)->get();

        $embellishmentTypes = EmbellishmentType::orderBy('embellishment_name')->where('active', 1)->get();

        $productAttributes = Attribute::orderBy('attribute_name')->where('active', 1)->get();

        $sports = Sport::where('active', 1)->orderBy('sport_name')->get();

        $factories = Factory::where('active', 1)->orderBy('factory_name')->get();

        $sizeTypes = SizeType::get();

        $priceTypes = PriceType::get();

        $products = Product::where('active', 1)->orderBy('id')->get();

        $subProduct = SubProduct::where('sub_product_no', $id)->with('embellishmentTypes', 'attributeOnUnitPrice')->first();

        // $subProduct->attribute_on_price = array_map('trim', explode('/', $subProduct->attribute_on_price));

        $subProductCode = $subProduct->sub_product_no;

        $selectedProduct = Product::where('id', $subProduct->parent_product_id)->first();

        $subProductImages = SubProductImage::where('active', 1)->where('sub_product_no', $id)->get();

        $isDisable = 1;

        $subProductPrices = SubProductPrice::where('active', 1)->where('sub_product_no', $id)->get();

        $colorMasters = ColorMaster::get();

        $subProductColor = SubProductColor::where('sub_product_no', $id)->pluck('color_master_id')->toArray();

        return view('pages.masters.products.sub_products.index', [
            'sizes'=>$sizes, 'productCategories'=>$productCategories, 'subProduct'=>$subProduct, 'subProductPrices' => $subProductPrices,
            'fabrics'=>$fabrics, 'embellishmentTypes'=>$embellishmentTypes, 'sports'=>$sports,
            'productAttributes'=>$productAttributes, 'factories'=>$factories,'sizeTypes'=>$sizeTypes, 'isDisable' => $isDisable, 'subProductImages'=>$subProductImages,
            'mainCategories'=>$mainCategories, 'priceTypes'=>$priceTypes, 'products'=>$products, 'selectedProduct'=>$selectedProduct, 'subProductCode'=>$subProductCode,
            'colorMasters'=>$colorMasters, 'subProductColor'=>$subProductColor
        ]);
    }
    public function subProductEmbellishmentUpdate(){

        $subProducts = SubProduct::get();

        foreach ($subProducts as $subProduct) {
            SubProductEmbellishmentOptions::where('sub_product_id', $subProduct->id)->delete();
            AttributeOnUnitPrice::where('sub_product_id', $subProduct->id)->delete();

            $type_of_embellishments = array_map('trim', explode('/', $subProduct->type_of_embellishment));
            $attribute_on_unit_price = array_map('trim', explode('/', $subProduct->attribute_on_price));
            if (!empty($type_of_embellishments)) {
                foreach ($type_of_embellishments as $type_of_embellishment) {
                    $embellishment = EmbellishmentType::where('embellishment_name', $type_of_embellishment)->first();
                    if ($embellishment) {
                        $subProductEmbellishmentOptions = new SubProductEmbellishmentOptions();
                        $subProductEmbellishmentOptions->sub_product_id = $subProduct->id;
                        $subProductEmbellishmentOptions->embellishment_option = $embellishment->id;
                        $subProductEmbellishmentOptions->save();
                    }

                }
            }
            if (!empty($attribute_on_unit_price)) {
                foreach ($attribute_on_unit_price as $attribute) {

                        $attri_record = new AttributeOnUnitPrice();
                        $attri_record->sub_product_id = $subProduct->id;
                        $attri_record->attribute__id = $attribute;
                        $attri_record->save();

                }
            }
        }

        dd('Done');

    }
    public function delete($id){

        $subProduct = SubProduct::where('sub_product_no', $id)->first();
        $subProduct->active = 3; //Deleted status
        $subProduct->update();

        // return response()->json(['message'=> 'Success !']);
        return redirect()->route('products')->with('success', 'Sub product ' . $id . ' deleted successfully !');

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
    public function uploadImages(Request $request)
    {
        try {
            if ($request->hasFile('image_uploaded')) {
                $file = $request->file('image_uploaded');
                $fileName = $file->getClientOriginalName();
                $fileName = preg_replace('/[^A-Za-z0-9._-]/', '', $fileName);
                $productFolder = 'PRO-' . $request->main_product_no;

                $directory_test = base_path('assets/Product Master/' . $productFolder . '/Sub Products/' . $request->sub_product_no . '/' . $request->folder_name);
                File::makeDirectory($directory_test, 0777, true, true);
                if ($request->db_coloumn_name == 'mockup_img_1' || $request->db_coloumn_name == 'mockup_img_2' || $request->db_coloumn_name == 'mockup_img_3') {
                    $directory = '/Product Master/' . $productFolder . '/Sub Products/' . $request->sub_product_no . '/' . $request->folder_name;
                }else{
                    $directory = '/assets/Product Master/' . $productFolder . '/Sub Products/' . $request->sub_product_no . '/' . $request->folder_name;
                }

                $FoundProduct = SubProduct::where('sub_product_no', $request->sub_product_no)->first();

                $uniqueId = uniqid();
                $extension = $file->getClientOriginalExtension();

                // Set the filename based on db_coloumn_name
                switch ($request->db_coloumn_name) {
                    case 'mockup_img_1':
                        $filename = "front_{$uniqueId}.{$extension}";
                        break;
                    case 'mockup_img_2':
                        $filename = "side_{$uniqueId}.{$extension}";
                        break;
                    case 'mockup_img_3':
                        $filename = "back_{$uniqueId}.{$extension}";
                        break;
                    case 'technical_tech_pack':
                        $filename = "{$request->sub_product_no}_technical_tech_pack_{$uniqueId}.{$extension}";
                        break;
                    case 'pattern_file':
                        $filename = "{$request->sub_product_no}_pattern_file_{$uniqueId}.{$extension}";
                        break;
                    case 'size_chart':
                        $filename = "{$request->sub_product_no}_size_chart_{$uniqueId}.{$extension}";
                        break;
                    case '3d':
                        $filename = "{$fileName}_{$uniqueId}.{$extension}";
                        break;
                    case 'lifestyle':
                        $filename = "{$fileName}_{$uniqueId}.{$extension}";
                        break;
                    case 'closeup':
                        $filename = "{$fileName}_{$uniqueId}.{$extension}";
                        break;
                    case 'branding':
                        $filename = "{$fileName}_{$uniqueId}.{$extension}";
                        break;
                    case 'studio':
                        $filename = "{$fileName}_{$uniqueId}.{$extension}";
                        break;
                    default:
                        return json_encode([
                            'responce' => 'error',
                            'meessage' => 'Invalid db_coloumn_name value.',
                        ]);
                }

                // Move the file to the directory
                $file->move($directory_test, $filename);

                // Save the file path or create SubProductImage record
                if (in_array($request->db_coloumn_name, ['mockup_img_1', 'mockup_img_2', 'mockup_img_3', 'technical_tech_pack', 'pattern_file', 'size_chart'])) {
                    $FoundProduct->{$request->db_coloumn_name} = $directory . '/' . $filename;
                    $FoundProduct->save();
                } else {
                    $subProductImage = new SubProductImage();
                    $subProductImage->sub_product_no = $request->sub_product_no;
                    $subProductImage->image_link = $directory . '/' . $filename;
                    $subProductImage->image_name = $filename;

                    // Map image type to integer values
                    $imageTypeMap = [
                        '3d' => 1,
                        'lifestyle' => 2,
                        'closeup' => 3,
                        'branding' => 4,
                        'studio' => 5,
                    ];

                    $subProductImage->image_type = $imageTypeMap[$request->db_coloumn_name] ?? null;
                    $subProductImage->active = 1;
                    $subProductImage->save();
                }

                return json_encode([
                    'responce' => 'success',
                    'meessage' => 'File Uploaded Successfully',
                ]);
            } else {
                return json_encode([
                    'responce' => 'error',
                    'meessage' => 'File Not Found!',
                ]);
            }
        } catch (\Throwable $th) {
            return json_encode([
                'responce' => 'error',
                'meessage' => $th->getMessage(),
            ]);
        }
    }

    public function removeImages(Request $request){

        $subProductImg = SubProductImage::where('id', $request->imgID)->first();

        if($subProductImg){
        $subProductImg->active = 0; //Deleted status
        $subProductImg->update();

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
    public function gold_price(){
        $sub_product_prices = SubProductPrice::where('active' , 1)->where('price_type' , 5)->get();
        foreach ($sub_product_prices as $sub_product_price) {
            $gold_price= new SubProductPrice();
            $gold_price->sub_product_no = $sub_product_price->sub_product_no;
            $gold_price->price_type = 3;
            $gold_price->price = number_format($sub_product_price->price * 1.5, 2);
            $gold_price->active = 1;
            $gold_price->start_date = $sub_product_price->start_date;
            $gold_price->end_date = $sub_product_price->end_date;
            $gold_price->save();
        }
    }
}
