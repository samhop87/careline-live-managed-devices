<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeviceStoreRequest;
use App\Http\Resources\DeviceResource;
use App\Models\Device;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class DeviceController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return DeviceResource::collection(Device::all());
    }

    public function store(DeviceStoreRequest $request): JsonResponse
    {// create new device
        $device = DB::transaction(function () use ($request) {
            $device = Device::create($request->all());

            $user = User::findOrFail($request->user_id);

            $user->devices()->attach($device);

            return $device;
        });

        if (!$device) {
            return response()->json([
                'message' => 'Device could not be created',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'message' => 'Device created successfully',
            'data' => new DeviceResource($device),
        ], Response::HTTP_CREATED);
    }
}
