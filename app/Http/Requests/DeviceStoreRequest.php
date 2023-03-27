<?php

namespace App\Http\Requests;

use App\Enums\DeviceTypeEnum;
use Illuminate\Foundation\Http\FormRequest;

class DeviceStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $standardRule = ['required', 'string', 'max:255'];

        $values = collect(DeviceTypeEnum::cases())->map(function ($type) {
            return $type->value;
        })->implode(',');

        return [
            'imei' => $standardRule,
            'sim_card_id' => ['required', 'integer', 'exists:sim_cards,id'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'model' => $standardRule,
            'manufacturer' => $standardRule,
            'os' => $standardRule,
            'type' => ['required', 'string', 'in:'. $values],
            'serial_number' => $standardRule,
        ];
    }
}
