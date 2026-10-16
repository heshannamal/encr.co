<?php

namespace domainencore\Services\SystemApiService;

use App\Models\SystemAPIs;

class SystemApiService
{
    protected $api;

    public function __construct()
    {
        $this->api = new SystemAPIs();
    }

    public function getAllSystemAPIs()
    {
        return $this->api->all();
    }

    public function getSystemAPIById($id)
    {
        return $this->api->find($id);
    }

    public function storeSystemAPI($data)
    {
        return $this->api->create($data);
    }

    public function updateSystemAPI($data, $id)
    {
        $systemApi = $this->api->find($id);
        return $systemApi->update($data);
    }

    public function destroySystemAPIById($id)
    {
        $this->api->find($id)->delete();
    }
}
