<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeviceIndexRequest;
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
    /**
     * @group Devices
     *
     * Get all Devices from the API.
     *
     * @queryParam operating_system Filter the devices by operating system. Example: ['android']
     *
     * @apiResourceCollection App\Http\Resources\DeviceResource
     * @apiResourceModel App\Models\Device
     */
    public function index(DeviceIndexRequest $request): AnonymousResourceCollection
    {
        $data = Device::query()
            ->when($request->operating_system, function ($query, $operating_system) {
                $query->whereIn('os', $operating_system);
            })->get();
        return DeviceResource::collection($data);
    }

    /**
     * @group Devices
     *
     * Create a new device
     *
     * @bodyParam user_id int required The id of the user to associate the device with. Example: 1
     * @bodyParam name string required The name of the device. Example: iPhone 12
     * @bodyParam type string required The type of the device. Example: phone
     * @bodyParam serial_number string required The serial number of the device. Example: 123456789
     * @bodyParam imei string required The IMEI of the device. Example: 123456789
     * @bodyParam manufacturer string required The manufacturer of the device. Example: Apple
     * @bodyParam os string required The operating system of the device. Example: ios
     *
     * @response 201 {
     *  "message": "Device created successfully",
     * "data": {
     * "id": 24,
     * "type": 1,
     * "serial_number": "2adaac76-0b2c-3603-91bf-462af2b80086",
     * "IMEI": "7107bf1d-4e42-31b2-aecc-ee95bedd3308",
     * "manufacturer": "Ebert, Jaskolski and Littel",
     * "model": "illum",
     * "os": "maemo",
     * "current_user": [],
     * "is_active": true
     * }
     * }
     */
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

    public function show(Device $device): DeviceResource
    {
        return new DeviceResource($device);
    }
}
