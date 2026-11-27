<?php

namespace App\Http\Controllers\Concerns;

use domainencore\Facades\OrdersCommenFacade\OrdersCommenFacade;

trait LoadsInventoryOrganizationIds
{
    private ?array $inventoryOrgIds = null;

    protected function inventoryOrganizationIds(): array
    {
        return $this->inventoryOrgIds ??= OrdersCommenFacade::getEncoreOrgIds()->toArray();
    }
}
