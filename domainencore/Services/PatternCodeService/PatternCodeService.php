<?php

namespace domainencore\Services\PatternCodeService;

use App\Models\PatternCode;
use App\Models\Product;
use App\Models\SubProduct;
use App\Models\ProductCategory;
use App\Models\Attribute;
use App\Models\AttributeGroupAttribute;
use App\Models\OrderItem;
use App\Models\OrderItemSubAttribute;
use App\Models\ProductCategoryList;

class PatternCodeService
{
    protected $patternCode;
    protected $product;
    protected $subProduct;
    protected $productCategory;
    protected $productCategoryList;
    protected $attribute;
    protected $groupedAttribute;

    public function __construct()
    {
        $this->patternCode = new PatternCode();
        $this->product = new Product();
        $this->subProduct = new SubProduct();
        $this->productCategory = new ProductCategory();
        $this->productCategoryList = new ProductCategoryList();
        $this->attribute = new Attribute();
        $this->groupedAttribute = new AttributeGroupAttribute();
    }

    public function getAttributeByProduct($productId)
    {
        $productCategories = $this->productCategoryList->where('product_id', $productId)->pluck('product_category_id');

        $groupedAttributes = [];

        foreach ($productCategories as $productCategory) {
            $attributes = $this->groupedAttribute
                ->where('product_category_id', 'LIKE', '%"' . $productCategory . '"%')
                ->pluck('attribute_id')
                ->toArray();

            $groupedAttributes = array_merge($groupedAttributes, $attributes);
        }
        $groupedAttributes = array_unique($groupedAttributes);
        return $this->attribute->whereIn('id', $groupedAttributes)->get();
    }

    public function getAttributeNameById($attributeId)
    {
        $attribute = $this->attribute->find($attributeId);
        return $attribute->attribute_name;
    }

    public function getOrderItemPatternCodeByOrderItemId($orderItemId)
    {
        $sub_product_no = '';
        $attribute_ids = [];
        $orderItem = OrderItem::find($orderItemId);
        if($orderItem){
            $sub_product_no = $orderItem->sub_product_no;
            $attribute_ids = OrderItemSubAttribute::where('order_item_id', $orderItemId)->pluck('attribute_id')->toArray();
        }
        $patterCode = $this->getOrderItemPatternCode($sub_product_no, $attribute_ids);
        return $patterCode[0];
    }

    public function getOrderItemPatternCode($sub_product_no, $attribute_ids)
    {
        $subProduct = $this->subProduct->where('sub_product_no', $sub_product_no)->first();
        // If attribute_ids is empty, return the default pattern code
        if (empty($attribute_ids)) {
            if($subProduct->pattern_code){
                return array($subProduct->pattern_code);
            } else {
                $parentProduct = $this->product->find($subProduct->parent_product_id);
                return array($parentProduct->pattern_code);
            }
        }

        // Get all pattern codes for this sub product
        $patternCodes = $this->patternCode->where('sub_product_id', $subProduct->id)->get();

        // Find the matching pattern code by comparing arrays
        $matchingPatternCode = $patternCodes->first(function($patternCode) use ($attribute_ids) {
            $storedAttributes = json_decode($patternCode->pattern_attribute, true);
            return $this->areArraysEqual($storedAttributes, $attribute_ids);
        });

        if($matchingPatternCode){
            return array($matchingPatternCode->pattern_code);
        } else {
            if($subProduct->pattern_code){
                return array($subProduct->pattern_code);
            } else {
                $parentProduct = $this->product->find($subProduct->parent_product_id);
                return array($parentProduct->pattern_code);
            }
        }
    }

    /**
     * Compare two arrays for exact match regardless of order
     * @param array $array1
     * @param array $array2
     * @return bool
     */
    private function areArraysEqual($array1, $array2)
    {
        // Handle empty arrays
        if (empty($array1) && empty($array2)) {
            return true;
        }

        if (count($array1) !== count($array2)) {
            return false;
        }

        // Convert all values to strings for comparison
        $array1 = array_map('strval', $array1);
        $array2 = array_map('strval', $array2);

        // Sort both arrays
        sort($array1);
        sort($array2);

        return $array1 === $array2;
    }
}
