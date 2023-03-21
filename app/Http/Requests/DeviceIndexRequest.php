<?php

namespace App\Http\Requests;

use App\Types\OS;
use Illuminate\Foundation\Http\FormRequest;

class DeviceIndexRequest extends FormRequest
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
        return [
            'operating_system' => 'array',
        ];
    }

    public function passedValidation()
    {
        $data = $this->validated();

        if (!isset($data['operating_system'])) {
            return;
        }

        $operating_system  = [];
        foreach($data['operating_system'] as $os) {
            $operating_system[] = OS::toInt($os);
        }

        $data['operating_system'] = $operating_system;

        $this->replace($data);
    }
}
