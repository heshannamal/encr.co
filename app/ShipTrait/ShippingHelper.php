<?php

namespace App\ShipTrait;

use domainencore\Facades\ShippingFacade\ShippingFacade;

trait ShippingHelper
{
    public function getShipping($orderId, $orderItemId, $orderItemDetailId, $sizeId, $hasBlank, $hasBlankName, $seqNumber, $seqName, $searchField)
    {
        $shippingField = ShippingFacade::get($orderId, $orderItemId, $orderItemDetailId, $sizeId, $hasBlank, $hasBlankName, $seqNumber, $seqName, $searchField);
        return $shippingField;
    }

    public function getBackOrderedShipping($orderId, $orderItemId, $orderItemDetailId, $sizeId, $hasBlank, $seqNumber)
    {
        $shippingDetail = ShippingFacade::getBackOrderedShipping($orderId, $orderItemId, $orderItemDetailId, $sizeId, $hasBlank, $seqNumber);
        return $shippingDetail;
    }

    public function getNotifiedBy($orderId, $orderItemId, $orderItemDetailId, $sizeId, $hasBlank, $hasBlankName, $seqNumber, $seqName)
    {
        $shippingField = ShippingFacade::getNotifiedBy($orderId, $orderItemId, $orderItemDetailId, $sizeId, $hasBlank, $hasBlankName, $seqNumber, $seqName);
        return $shippingField;
    }

    public function getNotifiedByBackOrdered($orderItemDetailId)
    {
        $shippingField = ShippingFacade::getNotifiedByBackOrdered($orderItemDetailId);
        return $shippingField;
    }

    public function getMainShipQty($orderId, $orderItemId)
    {
        $shippingField = ShippingFacade::getMainShipQty($orderId, $orderItemId);
        return $shippingField;
    }
}
