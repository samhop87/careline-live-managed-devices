<?php

namespace App\Http\Requests;

use App\Types\DeviceType;
use App\Types\OS;
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

        return [
            'imei' => $standardRule,
            'sim_card_id' => ['required', 'integer', 'exists:sim_cards,id'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'model' => $standardRule,
            'manufacturer' => $standardRule,
            'os' => $standardRule,
            'type' => ['required', 'string', 'in:'. DeviceType::typesCollection()->implode(',')],
            'serial_number' => $standardRule,
        ];
    }

    public function passedValidation()
    {
        $data = $this->validated();

        $data['os'] = OS::toInt($this->os);
        $data['type'] = DeviceType::toInt($this->type);

        $this->replace($data);
    }
}
