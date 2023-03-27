<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeviceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'serial_number' => $this->serial_number,
            'IMEI' => $this->IMEI,
            'manufacturer' => $this->manufacturer,
            'model' => $this->model,
            'os' => $this->os,
            'current_user' => new UserResource($this->user),
            'is_active' => $this->is_active,
        ];
    }
}
