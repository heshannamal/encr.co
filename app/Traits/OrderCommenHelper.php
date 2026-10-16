<?php

namespace App\Traits;

use App\Models\ProductCategory;
use domainencore\Facades\OrdersCommenFacade\OrdersCommenFacade;
use domainencore\Facades\PatternCodeFacade\PatternCodeFacade;

trait OrderCommenHelper
{
    public function isInventoryOrder($organizationId)
    {
        $inventoryOrgIds = OrdersCommenFacade::getEncoreOrgIds()->toArray();
        if(in_array($organizationId, $inventoryOrgIds))
        {
            return true;
        } else {
            return false;
        }
    }

    public function isNotInventoryOrder($organizationId)
    {
        $inventoryOrgIds = OrdersCommenFacade::getEncoreOrgIds()->toArray();
        if(in_array($organizationId, $inventoryOrgIds))
        {
            return false;
        } else {
            return true;
        }
    }

    public function isStatusEditable($statusId, $orderStatusId)
    {
        if (auth()->user()->hasRole('Super Admin') || auth()->user()->hasRole('Admin')) {
            return true;
        } else {
            if($statusId < $orderStatusId){
                return false;
            } else {
                return true;
            }
        }
    }

    public function getAttributeNameById($attributeId)
    {
        return PatternCodeFacade::getAttributeNameById($attributeId);
    }

    public function getProductCategoryIdInArray($data)
    {
        $categories = [];
        if($data){
            if(is_array(json_decode($data))){
                $categories = json_decode($data);
            } else {
                $categories = [$data];
            }
        }
        return $categories;
    }

    public function getProductCategoryNameById($productCategoryId)
    {
        $productCategory = ProductCategory::find($productCategoryId);
        if($productCategory){
            return $productCategory->product_category_name;
        } else {
            return null;
        }
    }

    public function getProductCategoryNameInArray($data)
    {
        $categories = $this->getProductCategoryIdInArray($data);
        $categoryNames = [];
        foreach($categories as $category){
            $categoryNames[] = $this->getProductCategoryNameById($category);
        }
        return $categoryNames;
    }
}
