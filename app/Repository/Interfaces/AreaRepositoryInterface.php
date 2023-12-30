<?php

namespace App\Repository\Interfaces;

interface AreaRepositoryInterface 
{
    public function getAllAreas();
    public function getAreaById($areaId);
    public function deleteArea($areaId);
    public function createArea(array $areaDetails);
    public function updateArea($areaId, array $newDetails);
}
