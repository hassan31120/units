<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUnit;
use App\Http\Requests\UpdateUnit;
use App\Http\Resources\UnitResource;
use App\Models\Unit;
use Illuminate\Support\Facades\DB;

class UnitController extends Controller
{
    public function index()
    {
        $units = auth()->user()->units;
        if ($units->count() == 0) {
            return response()->json([
                "success" => true,
                "message" => "No units yet",
                "data" => [],
            ]);
        } else {
            return response()->json([
                "success" => true,
                "message" => "Units retrieved successfully",
                "data" => UnitResource::collection($units),
            ]);
        }
    }

    public function store(StoreUnit $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->except('images', 'contract');
            $unit = auth()->user()->units()->create($data);
            $unit->addMedia($request['contract'])->toMediaCollection('contract');
            $unit->addMultipleMediaFromRequest(['images'])
                ->each(function ($image) {
                    $image->toMediaCollection('images');
                });
            DB::commit();
            return response()->json([
                "success" => true,
                "message" => "Unit created successfully",
                "data" => new UnitResource($unit),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                "success" => false,
                "message" => $e->getMessage(),
                "data" => [],
            ], 500);
        }
    }

    public function update(UpdateUnit $request, $id)
    {
        DB::beginTransaction();

        try {
            $unit = Unit::find($id);

            if (!$unit) {
                return response()->json([
                    "success" => false,
                    "message" => "Unit not found",
                    "data" => [],
                ], 404);
            }

            if ($unit->owner_id !== auth()->id()) {
                return response()->json([
                    "success" => false,
                    "message" => "Unauthorized",
                    "data" => [],
                ], 403);
            }

            $unit->update($request->except(['images', 'contract']));

            if ($request->hasFile('images')) {
                $unit->clearMediaCollection('images');
                $unit->addMultipleMediaFromRequest(['images'])
                    ->each(function ($image) {
                        $image->toMediaCollection('images');
                    });
            }

            if ($request->hasFile('contract')) {
                $unit->clearMediaCollection('contract');
                $unit->addMediaFromRequest('contract')->toMediaCollection('contract');
            }

            DB::commit();

            return response()->json([
                "success" => true,
                "message" => "Unit updated successfully",
                "data" => new UnitResource($unit->load('media')),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                "success" => false,
                "message" => $e->getMessage(),
                "data" => [],
            ], 500);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $unit = Unit::find($id);

            if (!$unit) {
                return response()->json([
                    "success" => false,
                    "message" => "Unit not found",
                    "data" => [],
                ], 404);
            }

            if ($unit->owner_id !== auth()->id()) {
                return response()->json([
                    "success" => false,
                    "message" => "Unauthorized",
                    "data" => [],
                ], 403);
            }

            $unit->delete();
            DB::commit();
            return response()->json([
                "success" => true,
                "message" => "Unit deleted successfully",
                "data" => [],
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                "success" => false,
                "message" => $e->getMessage(),
                "data" => [],
            ], 500);
        }
    }
}