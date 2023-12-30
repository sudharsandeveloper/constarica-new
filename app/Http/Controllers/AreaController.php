<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Http\Requests\StoreAreaRequest;
use App\Http\Requests\UpdateAreaRequest;
use App\Repository\Interfaces\AreaRepositoryInterface;
use Illuminate\Http\Response;

class AreaController extends Controller
{
    private AreaRepositoryInterface $areaRepository;

    public function __construct(AreaRepositoryInterface $areaRepository) 
    {
        $this->areaRepository = $areaRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'data' => $this->areaRepository->getAllAreas()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAreaRequest   $request)
    {
        // dd($request->all());
        $areaDetails = $request->only([
            'area_name',
            'status'
        ]);

        return response()->json(
            [
                'data' => $this->areaRepository->createArea($areaDetails)
            ],
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Area $area)
    {
        $areaId = $area->id;

        return response()->json([
            'data' => $this->areaRepository->getAreaById($areaId)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Area $area)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAreaRequest $request, Area $area)
    {
        $areaId = $area->id;
        $newDetails = $request->only([
            'area_name',
            'status'
        ]);

        return response()->json([
            'data' => $this->areaRepository->updateArea($areaId, $newDetails)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Area $area)
    {
        $areaId = $area->id;
        $this->areaRepository->deleteArea($areaId);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
