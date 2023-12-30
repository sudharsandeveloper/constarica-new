<?php

namespace App\Repository\Repositories;

use App\Repository\Interfaces\AreaRepositoryInterface;
use App\Models\Area;

class AreaRepository implements AreaRepositoryInterface 
{
    public function getAllAreas() 
    {
        return Area::all();
    }

    public function getAreaById($areaId) 
    {
        return Area::find($areaId);
    }

    public function deleteArea($areaId) 
    {
        Area::destroy($areaId);
    }

    public function createArea(array $areaDetails) 
    {
        return Area::create($areaDetails);
    }

    public function updateArea($areaId, array $newDetails) 
    {
        return Area::whereId($areaId)->update($newDetails);
    }
}
