<?php

namespace domainencore\Services\ProductService;

use App\Models\Product;
use App\Models\ProductSize;
use App\Models\ProductFabric;
use App\Models\ProductSport;
use App\Models\ProductEmbellishmentType;
use App\Models\ProductCategoryList;
use App\Models\ProductAttribute;
use App\Models\ProductFactory;
use App\Models\ProductMainCategory;
use App\Models\Price;
use App\Models\PriceTemp;
use App\Models\ProductFit;
use App\Models\ProductImage;
use App\Models\ProductImageTemp;
use App\Models\ProductTaglineList;
use App\Models\ProductTemp;
use App\Models\Size;
use App\Models\SubProduct;
use App\Models\SubProductColor;
use App\Models\SubProductEmbellishmentOptions;
use App\Models\SubProductImage;
use App\Models\SubProductImageTemp;
use App\Models\SubProductPrice;
use App\Models\SubProductTemp;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class ProductService
{
    protected $product;
    protected $productTemp;
    protected $subProduct;
    protected $productSize;
    protected $productFabric;
    protected $productSport;
    protected $productEmbellishmentType;
    protected $productCategoryList;
    protected $productAttribute;
    protected $productFactory;
    protected $productTaglineList;
    protected $productFit;
    protected $productMainCategory;
    protected $productPrice;
    protected $productPriceTemp;

    public function __construct()
    {
        $this->product = new Product();
        $this->productTemp = new ProductTemp();
        $this->subProduct = new SubProduct();
        $this->productSize = new ProductSize();
        $this->productFabric = new ProductFabric();
        $this->productSport = new ProductSport();
        $this->productEmbellishmentType = new ProductEmbellishmentType();
        $this->productCategoryList = new ProductCategoryList();
        $this->productAttribute = new ProductAttribute();
        $this->productFactory = new ProductFactory();
        $this->productTaglineList = new ProductTaglineList();
        $this->productFit = new ProductFit();
        $this->productMainCategory = new ProductMainCategory();
        $this->productPrice = new Price();
        $this->productPriceTemp = new PriceTemp();
    }

    public function createNewProduct()
    {
        $maxId = Product::max('id');
        $productNo = 'PRO-'.($maxId+1);

        $this->product->product_no = $productNo;
        $this->product->save();

        return $this->product->id;
    }

    public function createExistingProduct($existingProId)
    {
        $maxId = Product::max('id');
        $productNo = 'PRO-'.($maxId+1);

        $existProduct = $this->product->find($existingProId);

        if($existProduct){
            $proName = $existProduct->product_name.'_copy';
            $this->product->product_name = $proName;
            $this->product->product_no = $productNo;
            $this->product->pattern_code = $existProduct->pattern_code;
            $this->product->gender = $existProduct->gender;
            $this->product->default_price = $existProduct->default_price;
            $this->product->size_id = $existProduct->size_id;
            $this->product->MOQ = $existProduct->MOQ;
            // $this->product->fabric_id = $existProduct->fabric_id;
            $this->product->description = $existProduct->description;
            $this->product->who_we_made_this_for = $existProduct->who_we_made_this_for;
            $this->product->product_features = $existProduct->product_features;
            $this->product->notes = $existProduct->notes;
            $this->product->product_reference_link = $existProduct->product_reference_link;
            $this->product->active = $existProduct->active;
            $this->product->show_in_catalog =$existProduct->show_in_catalog;
            $this->product->save();

            $sub_products = SubProduct::where('parent_product_id', $existingProId)->get();
            foreach ($sub_products as $existSubProduct) {
                $subMaxId = 1;
                $subProductNo = 'PRO-'.$this->product->id.'.'.$subMaxId;
                $subProName = $existSubProduct->product_name.'_copy';

                $this->subProduct->parent_product_id = $this->product->id;
                $this->subProduct->product_name = $subProName;
                $this->subProduct->sub_product_no = $subProductNo;
                $this->subProduct->pattern_code = $existSubProduct->pattern_code;
                $this->subProduct->default_price = $existSubProduct->default_price;
                $this->subProduct->standard_fabric = $existSubProduct->standard_fabric;
                $this->subProduct->type_of_embellishment = $existSubProduct->type_of_embellishment;
                $this->subProduct->attribute_on_price = $existSubProduct->attribute_on_price;
                $this->subProduct->description = $existSubProduct->description;
                $this->subProduct->who_we_made_this_for = $existSubProduct->who_we_made_this_for;
                $this->subProduct->product_features = $existSubProduct->product_features;
                $this->subProduct->notes = $existSubProduct->notes;
                $this->subProduct->fabric_id = $existSubProduct->fabric_id;
                $this->subProduct->weight = $existSubProduct->weight;
                $this->subProduct->mockup_img = $existSubProduct->mockup_img;
                $this->subProduct->mockup_img_1 = $existSubProduct->mockup_img_1;
                $this->subProduct->mockup_img_2 = $existSubProduct->mockup_img_2;
                $this->subProduct->mockup_img_3 = $existSubProduct->mockup_img_3;
                $this->subProduct->product_reference_link = $existSubProduct->product_reference_link;
                $this->subProduct->pattern_file = $existSubProduct->pattern_file;
                $this->subProduct->technical_tech_pack = $existSubProduct->technical_tech_pack;
                $this->subProduct->active = $existSubProduct->active;
                $this->subProduct->show_in_catalog = $existSubProduct->show_in_catalog;
                $this->subProduct->save();
                $subMaxId++;
            }

            $existProductMainCategory = $this->productMainCategory->where('product_id', $existProduct->id)->get();
            if ( count($existProductMainCategory) > 0) {
                foreach($existProductMainCategory as $new_main_category_id){
                    $this->productMainCategory->product_id = $this->product->id;
                    $this->productMainCategory->main_category_id=$new_main_category_id->main_category_id;
                    $this->productMainCategory->save();
                }
            }



            $existProductSizes = $this->productSize->where('product_id', $existProduct->id)->get();
            if ( count($existProductSizes) > 0) {
                foreach($existProductSizes as $sizes){
                    $this->productSize->product_id = $this->product->id;
                    $this->productSize->size_id = $sizes->size_id;
                    $this->productSize->save();
                }
            }

            $existProductFabric = $this->productFabric->where('product_id', $existProduct->id)->get();
            if( count($existProductFabric) > 0 ){
                foreach($existProductFabric as $fabrics){
                    $this->productFabric->product_id = $this->product->id;
                    $this->productFabric->fabric_id = $fabrics->fabric_id;
                    $this->productFabric->save();
                }
            }

            $existProductSport = $this->productSport->where('product_id', $existProduct->id)->get();
            if (count($existProductSport) > 0) {
                foreach($existProductSport as $sports){
                    $this->productSport->product_id = $this->product->id;;
                    $this->productSport->sport_id = $sports->sport_id;
                    $this->productSport->save();
                }
            }

            // $existProductEmbellishmentType = $this->productEmbellishmentType->where('product_id', $existProduct->id)->get();
            // if(count($existProductEmbellishmentType) > 0){
            //     foreach($existProductEmbellishmentType as $embellishmentTypes){
            //         $this->productEmbellishmentType->product_id = $this->product->id;;
            //         $this->productEmbellishmentType->embellishment_type_id = $embellishmentTypes->embellishment_type_id;
            //         $this->productEmbellishmentType->save();
            //     }
            // }

            $existProductCategoryList = $this->productCategoryList->where('product_id', $existProduct->id)->get();
            if(count($existProductCategoryList) > 0){
                foreach($existProductCategoryList as $product_category){
                    $this->productCategoryList->product_id = $this->product->id;;
                    $this->productCategoryList->product_category_id=$product_category->product_category_id;
                    $this->productCategoryList->save();
                }
            }

            $existProductAttribute = $this->productAttribute->where('product_id', $existProduct->id)->get();
            if(count($existProductAttribute) > 0){
                foreach($existProductAttribute as $product_attribute){
                    $this->productAttribute->product_id = $this->product->id;;
                    $this->productAttribute->attribute_id=$product_attribute->attribute_id;
                    $this->productAttribute->save();
                }
            }

            $existProductFactory = $this->productFactory->where('product_id', $existProduct->id)->get();
            if(count($existProductFactory) > 0){
                foreach($existProductFactory as $product_factory){
                    $this->productFactory->product_id = $this->product->id;;
                    $this->productFactory->product_factory_id=$product_factory->product_factory_id;
                    $this->productFactory->save();
                }
            }

            $existProductTaglineList = $this->productTaglineList->where('product_id', $existProduct->id)->get();
            if(count($existProductTaglineList) > 0){
                foreach($existProductTaglineList as $product_tagline_list){
                    $this->productTaglineList->product_id = $this->product->id;;
                    $this->productTaglineList->tagline_id = $product_tagline_list->tagline_id;
                    $this->productTaglineList->save();
                }
            }

            $existProductFit = $this->productFit->where('product_id', $existProduct->id)->get();
            if(count($existProductFit) > 0){
                foreach($existProductFit as $product_fit){
                    $this->productFit->product_id = $this->product->id;;
                    $this->productFit->fit_id = $product_fit->fit_id;
                    $this->productFit->save();
                }
            }

            $existPrice = $this->productPrice->where('product_id', $existProduct->id)->get();
            if(count($existPrice) > 0){
                foreach($existPrice as $price){
                    $this->productPrice->product_id = $this->product->id;
                    $this->productPrice->price_type =  $price->price_type;
                    $this->productPrice->price = $price->price;
                    $this->productPrice->start_date = Carbon::now()->format('Y-m-d');
                    $this->productPrice->save();
                }
            }

            return $this->product->id;
        } else {
            return null;
        }
    }


   public function createNewProductTemp()
   {
        return DB::transaction(function () {

            $maxProductNo = Product::selectRaw("
                MAX(CAST(SUBSTRING(product_no, 5) AS UNSIGNED)) as max_no
            ")->value('max_no') ?? 0;


            $maxTempNo = ProductTemp::selectRaw("
                MAX(CAST(SUBSTRING(product_no, 5) AS UNSIGNED)) as max_no
            ")->value('max_no') ?? 0;

            $nextId = max($maxProductNo, $maxTempNo) + 1;

            $productNo = 'PRO-' . $nextId;

            while (ProductTemp::where('product_no', $productNo)->exists()) {
                $nextId++;
                $productNo = 'PRO-' . $nextId;
            }

            // Save
            $product = new ProductTemp();
            $product->product_no = $productNo;
            $product->active = 1;
            $product->transferred = 0;
            $product->save();

            return $product->id;
        });
    }



    public function createExistingProductTemp($existingProId)
    {
        return DB::transaction(function () use ($existingProId) {
            $existProduct = Product::find($existingProId);

            if (!$existProduct) {
                return null;
            }

            $maxProductId = Product::max('id') ?? 0;
            $maxTempId = ProductTemp::max('id') ?? 0;

            $nextId = max($maxProductId, $maxTempId) + 1;

            while (ProductTemp::where('product_no', 'PRO-' . $nextId)->exists()) {
                $nextId++;
            }


            $productNo = 'PRO-' . $nextId;

            $product = new ProductTemp();
            $product->product_no = $productNo;
            $product->product_name = $existProduct->product_name ? $existProduct->product_name . '_copy' : null;
            $product->product_id = $existProduct->id;
            $product->pattern_code = $existProduct->pattern_code;
            $product->gender = $existProduct->gender;
            $product->MOQ = $existProduct->MOQ;
            $product->default_price = $existProduct->default_price;
            $product->standard_fabric = $existProduct->standard_fabric;
            $product->fabric_options = $existProduct->fabric_options;
            $product->type_of_embellishment = $existProduct->type_of_embellishment;
            $product->description = $existProduct->description;
            $product->who_we_made_this_for = $existProduct->who_we_made_this_for;
            $product->product_features = $existProduct->product_features;
            $product->notes = $existProduct->notes;
            $product->weight = $existProduct->weight;
            $product->mockup_img = $existProduct->mockup_img;
            $product->mockup_img_1 = $existProduct->mockup_img_1;
            $product->mockup_img_2 = $existProduct->mockup_img_2;
            $product->mockup_img_3 = $existProduct->mockup_img_3;
            $product->mockup_caption_1 = $existProduct->mockup_caption_1;
            $product->mockup_caption_2 = $existProduct->mockup_caption_2;
            $product->mockup_caption_3 = $existProduct->mockup_caption_3;
            $product->product_reference_link = $existProduct->product_reference_link;
            $product->{'2D_mockup'} = $existProduct->{'2D_mockup'};
            $product->{'3D_mockup'} = $existProduct->{'3D_mockup'};
            $product->tech_pack = $existProduct->tech_pack;
            $product->measurement = $existProduct->measurement;
            $product->product_layout = $existProduct->product_layout;
            $product->pattern = $existProduct->pattern;
            $product->technical_tech_pack = $existProduct->technical_tech_pack;
            $product->show_in_catalog = $existProduct->show_in_catalog;
            $product->fits_true_to_size = $existProduct->fits_true_to_size;
            $product->size_id = $existProduct->size_id;
            $product->active = 1;
            $product->transferred = 0;


            $productmainCategory = ProductMainCategory::where('product_id', $existProduct->id)
            ->pluck('main_category_id')
            ->toArray();
            $productCategories = ProductCategoryList::where('product_id', $existProduct->id)
            ->pluck('product_category_id')
            ->toArray();
            $sports = ProductSport::where('product_id', $existProduct->id)
            ->pluck('sport_id')
            ->toArray();
            $sizes = Size::where('size_type', $existProduct->size_id)
            ->pluck('id')
            ->toArray();
            $fabrics = ProductFabric::where('product_id', $existProduct->id)
            ->pluck('fabric_id')
            ->toArray();
            $attribute = ProductAttribute::where('product_id', $existProduct->id)
            ->pluck('attribute_id')
            ->toArray();
            $attributePrice = SubProduct::where('parent_product_id',$existProduct->id)
            ->pluck('attribute_on_price')
            ->toArray();
            $factories = ProductFactory::where('product_id', $existProduct->id)
            ->pluck('product_factory_id')
            ->toArray();
            $taglineLists = ProductTaglineList::where('product_id', $existProduct->id)
            ->pluck('tagline_id')
            ->toArray();
            $productFits = ProductFit::where('product_id', $existProduct->id)
            ->pluck('fit_id')
            ->toArray();

            //category
            $product->main_category_id = $productmainCategory;
            //style
            $product->product_category_id = $productCategories;
            $product->sport_ids = $sports;
            $product->size_ids =  $sizes;
            $product->fabric_ids = $fabrics;
            $product->product_attribute_ids = $attribute;
            $product->product_factory_ids = $factories;
            $product->product_tagline_ids = $taglineLists;
            $product->product_fit_ids = $productFits;
            $product->attribute_on_price = $attributePrice ?: [];
            $product->save();


            $existPrices = Price::where('product_id', $existProduct->id)->where('active', 1)->get();
            foreach ($existPrices as $price) {
                PriceTemp::create([
                    'product_id' => $product->id,
                    'price_type' => $price->price_type,
                    'price'      => $price->price,
                    'active'     => $price->active,
                    'product_level' => 1,
                    'start_date' => now()->format('Y-m-d'),
                    'end_date'   => $price->end_date,
                ]);
            }

            $productImages = ProductImage::where('product_id', $existProduct->id)->get();
            foreach ($productImages as $image) {
                ProductImageTemp::create([
                    'product_id' => $product->id,
                    'image_type' => $image->image_type,
                    'image_link' => $image->image_link,
                    'image_name' => $image->image_name,
                    'image_caption' => $image->image_caption,
                    'active'     => $image->active ?? 1,
                ]);
            }

            return $product->id;
        });
    }



    public function createSubProductTemp($productId)
    {
        $existProduct = Product::find($productId);

        if (!$existProduct) {
            return null;
        }

        return DB::transaction(function () use ($existProduct) {


            $existingProductNo = $existProduct->product_no;

            $versions = SubProductTemp::where('product_no', 'like', $existingProductNo . '.%')
                ->pluck('product_no')
                ->map(function ($no) {
                    $parts = explode('.', $no);
                    return isset($parts[1]) ? (int) $parts[1] : 0;
                })
                ->filter()
                ->toArray();

            $nextVersion = !empty($versions) ? max($versions) + 1 : 1;

            $newProductNo = $existingProductNo . '.' . $nextVersion;


            $product = new SubProductTemp();

            $product->product_no = $newProductNo;
            $product->product_name = $existProduct->product_name
                ? $existProduct->product_name . '_copy'
                : null;

            $product->product_id = $existProduct->id;

            $product->pattern_code = $existProduct->pattern_code;
            $product->gender = $existProduct->gender;
            $product->MOQ = $existProduct->MOQ;
            $product->size_id = $existProduct->size_id;
            $product->default_price = $existProduct->default_price;
            $product->standard_fabric = $existProduct->standard_fabric;
            $product->fabric_options = $existProduct->fabric_options;
            $product->type_of_embellishment = $existProduct->type_of_embellishment;
            $product->description = $existProduct->description;
            $product->who_we_made_this_for = $existProduct->who_we_made_this_for;
            $product->product_features = $existProduct->product_features;
            $product->notes = $existProduct->notes;
            $product->weight = $existProduct->weight;
            $product->fabric_id = $existProduct->fabric_id;
            $product->mockup_img = $existProduct->mockup_img;
            $product->mockup_img_1 = $existProduct->mockup_img_1;
            $product->mockup_img_2 = $existProduct->mockup_img_2;
            $product->mockup_img_3 = $existProduct->mockup_img_3;

            $product->mockup_caption_1 = $existProduct->mockup_caption_1;
            $product->mockup_caption_2 = $existProduct->mockup_caption_2;
            $product->mockup_caption_3 = $existProduct->mockup_caption_3;

            $product->product_reference_link = $existProduct->product_reference_link;

            $product->{'2D_mockup'} = $existProduct->{'2D_mockup'};
            $product->{'3D_mockup'} = $existProduct->{'3D_mockup'};

            $product->tech_pack = $existProduct->tech_pack;
            $product->measurement = $existProduct->measurement;
            $product->product_layout = $existProduct->product_layout;
            $product->pattern = $existProduct->pattern;
            $product->technical_tech_pack = $existProduct->technical_tech_pack;

            $product->show_in_catalog = $existProduct->show_in_catalog;
            $product->fits_true_to_size = $existProduct->fits_true_to_size;

            $product->active = 1;

            $productmainCategory = ProductMainCategory::where('product_id', $existProduct->id)
            ->pluck('main_category_id')
            ->toArray();
            $productCategories = ProductCategoryList::where('product_id', $existProduct->id)
            ->pluck('product_category_id')
            ->toArray();
            $sports = ProductSport::where('product_id', $existProduct->id)
            ->pluck('sport_id')
            ->toArray();
            $sizes = Size::where('size_type', $existProduct->size_id)
            ->pluck('id')
            ->toArray();
            $fabrics = ProductFabric::where('product_id', $existProduct->id)
            ->pluck('fabric_id')
            ->toArray();
            $attribute = ProductAttribute::where('product_id', $existProduct->id)
            ->pluck('attribute_id')
            ->toArray();

            $attributePrice = SubProduct::where('parent_product_id',$existProduct->id)
            ->pluck('attribute_on_price')
            ->toArray();

            $factories = ProductFactory::where('product_id', $existProduct->id)
            ->pluck('product_factory_id')
            ->toArray();
            $taglineLists = ProductTaglineList::where('product_id', $existProduct->id)
            ->pluck('tagline_id')
            ->toArray();
            $productFits = ProductFit::where('product_id', $existProduct->id)
            ->pluck('fit_id')
            ->toArray();
            $embellishmentIds = ProductEmbellishmentType::where('product_id', $existProduct->id)
            ->pluck('embellishment_type_id')
            ->toArray();

            $product->main_category_id = $productmainCategory;
            $product->product_category_id = $productCategories;
            $product->sport_ids = $sports;
            $product->size_ids =  $sizes;
            $product->fabric_ids = $fabrics;
            $product->product_attribute_ids = $attribute;
            $product->product_factory_ids = $factories;
            $product->product_tagline_ids = $taglineLists;
            $product->product_fit_ids = $productFits;
            $product->attribute_on_price = $attributePrice ?: [];
            $product->embellishment_options = $embellishmentIds;
            $product->transferred = 0;

            $product->save();

            $existPrices = Price::where('product_id', $existProduct->id)->where('active', 1)->get();
            foreach ($existPrices as $price) {
                PriceTemp::create([
                    'product_id' => $product->id,
                    'price_type' => $price->price_type,
                    'price'      => $price->price,
                    'active'     => $price->active,
                    'product_level' => 1,
                    'start_date' => now()->format('Y-m-d'),
                    'end_date'   => $price->end_date,
                ]);
            }

            $subProductImages = ProductImage::where('product_id', $existProduct->id)->get();
            foreach ($subProductImages as $image) {
                SubProductImageTemp::create([
                    'product_id' => $product->id,
                    'sub_product_no'=> $newProductNo,
                    'image_type' => $image->image_type,
                    'image_link' => $image->image_link,
                    'image_name' => $image->image_name,
                    'active'     => $image->active ?? 1,
                ]);
            }

        
            return $product->id;
        });
    }




    public function createExistingSubProductTemp($existingSubId)
    {
        $existSub = SubProduct::find($existingSubId);

        if (!$existSub) {
            return null;
        }

        return DB::transaction(function () use ($existSub) {

            $parentProduct = Product::find($existSub->parent_product_id);

            if (!$parentProduct) {
                throw new \Exception('Parent product not found');
            }

            $baseProductNo = $parentProduct->product_no;

            $subVersions = SubProduct::where('parent_product_id', $parentProduct->id)
                ->pluck('sub_product_no')
                ->map(function ($no) use ($baseProductNo) {
                    return (int) str_replace($baseProductNo.'.', '', $no);
                })
                ->filter()
                ->toArray();

            $tempVersions = SubProductTemp::where('product_no', 'like', $baseProductNo.'.%')
                ->pluck('product_no')
                ->map(function ($no) use ($baseProductNo) {
                    return (int) str_replace($baseProductNo.'.', '', $no);
                })
                ->filter()
                ->toArray();


            $allVersions = array_merge($subVersions, $tempVersions);

            $nextVersion = !empty($allVersions) ? max($allVersions) + 1 : 1;

            $newProductNo = $baseProductNo.'.'.$nextVersion;

            $product = new SubProductTemp();

            $product->product_no = $newProductNo;
            $product->product_id = $parentProduct->id;
            $product->sub_product_id = $existSub->id;
            $product->product_name = $existSub->product_name
                ? $existSub->product_name.'_copy'
                : null;

            $product->pattern_code = $existSub->pattern_code;
            $product->gender = $existSub->gender;
            $product->MOQ = $existSub->MOQ;
            $product->size_id = $existSub->size_id;
            $product->default_price = $existSub->default_price;
            $product->standard_fabric = $existSub->standard_fabric;
            $product->fabric_options = $existSub->fabric_options;
            $product->type_of_embellishment = $existSub->type_of_embellishment;
            $product->description = $existSub->description;
            $product->who_we_made_this_for = $existSub->who_we_made_this_for;
            $product->product_features = $existSub->product_features;
            $product->notes = $existSub->notes;
            $product->weight = $existSub->weight;
            $product->fabric_id = $existSub->fabric_id;

            $product->mockup_img = $existSub->mockup_img;
            $product->mockup_img_1 = $existSub->mockup_img_1;
            $product->mockup_img_2 = $existSub->mockup_img_2;
            $product->mockup_img_3 = $existSub->mockup_img_3;

            $product->mockup_caption_1 = $existSub->mockup_caption_1;
            $product->mockup_caption_2 = $existSub->mockup_caption_2;
            $product->mockup_caption_3 = $existSub->mockup_caption_3;

            $product->product_reference_link = $existSub->product_reference_link;

            // optional extra fields if exist
            $product->technical_tech_pack = $existSub->technical_tech_pack ?? null;
            $product->tech_pack = $existSub->tech_pack ?? null;
            $product->measurement = $existSub->measurement ?? null;
            $product->product_layout = $existSub->product_layout ?? null;
            $product->pattern = $existSub->pattern ?? null;

            $productmainCategory = ProductMainCategory::where('product_id', $existSub->parent_product_id)
            ->pluck('main_category_id')
            ->toArray();
            $productCategories = ProductCategoryList::where('product_id', $existSub->id)
            ->pluck('product_category_id')
            ->toArray();
            $sports = ProductSport::where('product_id', $existSub->id)
            ->pluck('sport_id')
            ->toArray();
            $sizes = Size::where('size_type', $existSub->size_id)
            ->pluck('id')
            ->toArray();
            $fabrics = ProductFabric::where('product_id', $existSub->id)
            ->pluck('fabric_id')
            ->toArray();
            $attribute = ProductAttribute::where('product_id', $existSub->id)
            ->pluck('attribute_id')
            ->toArray();

            $attributePrice = SubProduct::where('parent_product_id',$existSub->id)
            ->pluck('attribute_on_price')
            ->toArray();

            $factories = ProductFactory::where('product_id', $existSub->id)
            ->pluck('product_factory_id')
            ->toArray();
            $taglineLists = ProductTaglineList::where('product_id', $existSub->id)
            ->pluck('tagline_id')
            ->toArray();
            $productFits = ProductFit::where('product_id', $existSub->id)
            ->pluck('fit_id')
            ->toArray();
            $embellishmentIds = SubProductEmbellishmentOptions::where('sub_product_id', $existSub->id)
            ->pluck('embellishment_option')
            ->toArray();
            $subProductColor = SubProductColor::where('sub_product_no', $existSub->sub_product_no)
            ->pluck('color_master_id')
            ->toArray();

            $product->main_category_id = $productmainCategory;
            $product->product_category_id = $productCategories;
            $product->sport_ids = $sports;
            $product->size_ids =  $sizes;
            $product->fabric_ids = $fabrics;
            $product->transferred = 0;
            $product->product_attribute_ids = $attribute;
            $product->product_factory_ids = $factories;
            $product->product_tagline_ids = $taglineLists;
            $product->product_fit_ids = $productFits;
            $product->attribute_on_price = $attributePrice ?: [];
            $product->embellishment_options = $embellishmentIds;
            $product->colorIds = $subProductColor;

            $product->save();

            $existPrices = SubProductPrice::where('sub_product_no', $existSub->sub_product_no)->where('active', 1)->get();
            foreach ($existPrices as $price) {
                PriceTemp::create([
                    'product_id' => $product->id,
                    'price_type' => $price->price_type,
                    'price'      => $price->price,
                    'active'     => $price->active,
                    'product_level' => 2,
                    'start_date' => now()->format('Y-m-d'),
                    'end_date'   => $price->end_date,
                ]);
            }

            $subProductImages = SubProductImage::where('sub_product_no', $existSub->sub_product_no)->get();
            foreach ($subProductImages as $image) {
                SubProductImageTemp::create([
                    'product_id' => $product->id,
                    'sub_product_no'=> $newProductNo,
                    'image_type' => $image->image_type,
                    'image_link' => $image->image_link,
                    'image_name' => $image->image_name,
                    'active'     => $image->active ?? 1,
                ]);
            }

            return $product->id;
        });
    }


    public function move_product($temp, $projectId, $level)
    {
        return DB::transaction(function () use ($temp, $projectId, $level) {

            $maxId = Product::max('id') ?? 0;
            $productNo = 'PRO-' . ($maxId + 1);

            $product = new Product(); 

            $product->product_name = $temp->product_name;
            $product->show_in_catalog_name = $temp->show_in_catalog_name;
            $product->product_no = $productNo;
            $product->pattern_code = $temp->pattern_code;
            $product->gender = $temp->gender;
            $product->MOQ = $temp->MOQ;
            $product->size_id = $temp->size_id;
            $product->default_price = $temp->default_price;
            $product->standard_fabric = $temp->standard_fabric;
            $product->fabric_options = $temp->fabric_options;
            $product->type_of_embellishment = $temp->type_of_embellishment;
            $product->description = $temp->description;
            $product->who_we_made_this_for = $temp->who_we_made_this_for;
            $product->product_features = $temp->product_features;
            $product->notes = $temp->notes;
            $product->weight = $temp->weight;
            $product->fabric_id = $temp->fabric_id;

            $product->mockup_img = $temp->mockup_img;
            $product->mockup_img_1 = $temp->mockup_img_1;
            $product->mockup_img_2 = $temp->mockup_img_2;
            $product->mockup_img_3 = $temp->mockup_img_3;

            $product->mockup_caption_1 = $temp->mockup_caption_1;
            $product->mockup_caption_2 = $temp->mockup_caption_2;
            $product->mockup_caption_3 = $temp->mockup_caption_3;

            $product->{'2D_mockup'} = $temp->{'2D_mockup'};
            $product->{'3D_mockup'} = $temp->{'3D_mockup'};
            $product->tech_pack = $temp->tech_pack;
            $product->measurement = $temp->measurement;
            $product->product_layout = $temp->product_layout;
            $product->pattern = $temp->pattern;
            $product->technical_tech_pack = $temp->technical_tech_pack;

            $product->product_reference_link = $temp->product_reference_link;
            $product->active = 1;

            $product->save();
            

            $categoryIds = $temp->main_category_id ?? []; 
            foreach ($categoryIds as $catId) {
                ProductMainCategory::create([
                    'product_id' => $product->id,
                    'main_category_id' => $catId
                ]);
            }


            $productCategoryIds =  $temp->product_category_id ?? [];
            foreach ($productCategoryIds as $proCatId) {
                ProductCategoryList::create([
                    'product_id' => $product->id,
                    'product_category_id' => $proCatId
                ]);
            }


            $sportIds = $temp->sport_ids ?? [];
            foreach ($sportIds as $sportId) {
                ProductSport::create([
                    'product_id' => $product->id,
                    'sport_id' => $sportId
                ]);
            }

            $fabricsIds = $temp->fabric_ids ?? [];
            foreach ($fabricsIds as $fabricId) {
                ProductFabric::create([
                    'product_id' => $product->id,
                    'product_factory_id' => $fabricId
                ]);
            }


            $productAttributeIds = $temp->attribute_on_price ?? [];
            foreach ($productAttributeIds as $attribId) {
                ProductAttribute::create([
                    'product_id' => $product->id,
                    'attribute_id' => $attribId
                ]);
            }


            $factoriesIds = $temp->product_factory_ids ?? [];
            foreach ($factoriesIds as $factyId) {
                ProductFactory::create([
                    'product_id' => $product->id,
                    'product_factory_id' => $factyId
                ]);
            }

            $productTaglineListIds = $temp->product_tagline_ids ?? [];
            foreach ($productTaglineListIds as $productListIds) {
                ProductTaglineList::create([
                    'product_id' => $product->id,
                    'tagline_id' => $productListIds
                ]);
            }

            $productFitsIds = $temp->product_fit_ids ?? [];
            foreach ($productFitsIds as $productFitId) {
                ProductFit::create([
                    'product_id' => $product->id,
                    'fit_id' => $productFitId
                ]);
            }
            
            $product->save();

            $existPrices = PriceTemp::where('product_id', $temp->id)->where('product_level', 1)->where('active', 1)->get();
            foreach ($existPrices as $price) {
                Price::create([
                    'product_id' => $product->id,
                    'price_type' => $price->price_type,
                    'price'      => $price->price,
                    'active'     => $price->active,
                    'start_date' => now()->format('Y-m-d'),
                    'end_date'   => $price->end_date,
                ]);
            }

            
            $productImages = ProductImageTemp::where('product_id', $temp->id)->get();
            foreach ($productImages as $image) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_type' => $image->image_type,
                    'image_link' => $image->image_link,
                    'image_name' => $image->image_name,
                    'image_caption' => $image->image_caption,
                    'active'     => $image->active ?? 1,
                ]);
            }


            $this->moveImagesAndSyncDB($projectId, $temp->product_no, $product, $temp->id, $level);

            return $product;
        });

       
    }



    public function move_subproduct($temp, $projectId, $level){
        return DB::transaction(function () use ($temp, $projectId, $level) {

            $parentProduct = Product::findOrFail($temp->product_id);
            $baseProductNo = $parentProduct->product_no;

            $tempVersion = (int) str_replace($baseProductNo.'.','',$temp->product_no);

            $exists = SubProduct::where('parent_product_id',$parentProduct->id)
                ->where('sub_product_no',$temp->product_no)
                ->exists();

            if(!$exists){
                $finalVersion = $tempVersion;
            }else{
                $versions = SubProduct::where('parent_product_id',$parentProduct->id)
                    ->pluck('sub_product_no')
                    ->map(fn($no)=> (int) str_replace($baseProductNo.'.','',$no))
                    ->filter()->sort()->values()->toArray();

                $next=1;
                foreach($versions as $v){
                    if($v==$next) $next++;
                    else break;
                }
                $finalVersion=$next;
            }

            $newProductNo=$baseProductNo.'.'.$finalVersion;

            $subProduct=new SubProduct();

            $subProduct->sub_product_no=$newProductNo;
            $subProduct->product_name=$temp->product_name;
            $subProduct->parent_product_id=$temp->product_id;
            $subProduct->pattern_code=$temp->pattern_code;
            $subProduct->default_price=$temp->default_price;
            $subProduct->standard_fabric=$temp->standard_fabric;
            $subProduct->type_of_embellishment=$temp->type_of_embellishment;
            $subProduct->description=$temp->description;
            $subProduct->who_we_made_this_for=$temp->who_we_made_this_for;
            $subProduct->product_features=$temp->product_features;
            $subProduct->notes=$temp->notes;
            $subProduct->weight=$temp->weight;
            $subProduct->fabric_id=$temp->fabric_id;

            $subProduct->mockup_img=$temp->mockup_img;
            $subProduct->mockup_img_1=$temp->mockup_img_1;
            $subProduct->mockup_img_2=$temp->mockup_img_2;
            $subProduct->mockup_img_3=$temp->mockup_img_3;
        
            $subProduct->technical_tech_pack = $temp->tech_pack;
            $subProduct->pattern_file = $temp->pattern;
        

            $subProduct->product_reference_link=$temp->product_reference_link;
            $subProduct->active=1;

            $subProduct->save(); 


            $productCategoryIds =  $temp->product_category_id ?? [];
            foreach ($productCategoryIds as $proCatId) {
                ProductCategoryList::create([
                    'product_id' => $subProduct->id,
                    'product_category_id' => $proCatId
                ]);
            }


            $sportIds = $temp->sport_ids ?? [];
            foreach ($sportIds as $sportId) {
                ProductSport::create([
                    'product_id' => $subProduct->id,
                    'sport_id' => $sportId
                ]);
            }

            $fabricsIds = $temp->fabric_ids ?? [];
            foreach ($fabricsIds as $fabricId) {
                ProductFabric::create([
                    'product_id' => $subProduct->id,
                    'product_factory_id' => $fabricId
                ]);
            }


            $productAttributeIds = $temp->attribute_on_price ?? [];
            foreach ($productAttributeIds as $attribId) {
                ProductAttribute::create([
                    'product_id' => $subProduct->id,
                    'attribute_id' => $attribId
                ]);
            }


            $factoriesIds = $temp->product_factory_ids ?? [];
            foreach ($factoriesIds as $factyId) {
                ProductFactory::create([
                    'product_id' => $subProduct->id,
                    'product_factory_id' => $factyId
                ]);
            }

            $productTaglineListIds = $temp->product_tagline_ids ?? [];
            foreach ($productTaglineListIds as $productListIds) {
                ProductTaglineList::create([
                    'product_id' => $subProduct->id,
                    'tagline_id' => $productListIds
                ]);
            }

            $productFitsIds = $temp->product_fit_ids ?? [];
            foreach ($productFitsIds as $productFitId) {
                ProductFit::create([
                    'product_id' => $subProduct->id,
                    'fit_id' => $productFitId
                ]);
            }

            $embellishmentIds = $temp->embellishment_options ?? [];
            foreach ($embellishmentIds as $embellishment) {
                SubProductEmbellishmentOptions::create([
                    'sub_product_id' => $subProduct->id,
                    'embellishment_option' => $embellishment
                ]);
            }
            $colorIds = $temp->colorIds ?? [];
            foreach ($colorIds as $color) {
                SubProductColor::create([
                    'sub_product_no' => $newProductNo,
                    'color_master_id' => $color
                ]);
            }


            $existPrices = PriceTemp::where('product_id', $temp->id)->where('product_level', 2)->where('active', 1)->get();
            foreach ($existPrices as $price) {
                SubProductPrice::create([
                    'sub_product_no' => $newProductNo,
                    'price_type' => $price->price_type,
                    'price'      => $price->price,
                    'active'     => $price->active,
                    'start_date' => now()->format('Y-m-d'),
                    'end_date'   => $price->end_date,
                ]);
            }

            $subProductImages = SubProductImageTemp::where('sub_product_no', $newProductNo)->get();
            foreach ($subProductImages as $image) {
                SubProductImage::create([
                    'product_id' => $subProduct->id,
                    'sub_product_no'=> $newProductNo,
                    'image_type' => $image->image_type,
                    'image_link' => $image->image_link,
                    'image_name' => $image->image_name,
                    'active'     => $image->active ?? 1,
                ]);
            }

            $this->moveImagesAndSyncDB($projectId, $temp->product_no, $subProduct, $temp->id, $level);

            return $subProduct;
        });
        
    }



    private function moveImagesAndSyncDB($projectId, $productNo, $model, $tempId = null, $level)
    {
        $tempPath   = base_path("assets/Product Master Temp/{$projectId}/{$productNo}");
        $masterPath = base_path("assets/Product Master/{$projectId}/{$productNo}");

        if (File::exists($tempPath)) {

            File::ensureDirectoryExists(dirname($masterPath));
            File::copyDirectory($tempPath, $masterPath);

        } else {

            Log::info("No temp image folder found, skipping copy: ".$tempPath);

        }

      
        foreach ($model->getAttributes() as $field => $value) {

            if (is_string($value) && str_contains($value,'/Product Master Temp/')) {

                $model->$field = str_replace(
                    '/Product Master Temp/',
                    '/Product Master/',
                    $value
                );
            }
        }

        $model->save();

       
        if ($level === 1) {
            if ($tempId) {

                $tempImages = ProductImageTemp::where('product_id', $tempId)->get();

                foreach ($tempImages as $img) {

                    $new = new ProductImage();


                    $new->product_id = $model->id;

                    foreach ($img->getAttributes() as $field => $value) {

                        if (in_array($field, ['id','product_id','sub_product_no','created_at','updated_at']))
                            continue;

                        if (is_string($value) && str_contains($value,'Product Master Temp')) {

                            $new->$field = str_replace(
                                'Product Master Temp',
                                'Product Master',
                                $value
                            );

                        } else {

                            $new->$field = $value;
                        }
                    }

                    $new->save();
                }
            }
        } else {
            if ($tempId) {
                $tempImages = SubProductImageTemp::where('sub_product_no', $productNo)->get();
                foreach ($tempImages as $img) {

                    $new = new SubProductImage();

                    $new->sub_product_no = $model->sub_product_no;

                    foreach ($img->getAttributes() as $field => $value) {

                        if (in_array($field, ['id','product_id','sub_product_no','created_at','updated_at']))
                            continue;

                        if (is_string($value) && str_contains($value,'Product Master Temp')) {

                            $new->$field = str_replace(
                                'Product Master Temp',
                                'Product Master',
                                $value
                            );

                        } else {

                            $new->$field = $value;
                        }
                    }

                    $new->save();
                }
            }
        }
        
    }
    


}
