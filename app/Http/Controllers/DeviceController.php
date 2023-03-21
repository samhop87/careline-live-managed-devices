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
    {
        dd($request->validated());
        // create new device
        $device = DB::transaction(function () use ($request) {
            $device = Device::create($request->validated());

            $user = User::findOrFail($request->user_id);

            $user->devices()->attach($device);

            $device->simCard()->attach($request->sim_card_id);

            return $device;
        });

        if (!$device) {
            dd('hit');
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
