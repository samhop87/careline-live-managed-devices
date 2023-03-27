<?php

namespace Database\Factories;

use App\Enums\DeviceTypeEnum;
use App\Enums\OsEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Device>
 */
class DeviceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => DeviceTypeEnum::PHONE,
            'serial_number' => $this->faker->unique()->uuid,
            'IMEI' => $this->faker->unique()->uuid,
            'manufacturer' => $this->faker->company,
            'model' => $this->faker->word,
            'os' => OsEnum::ANDROID,
            'user_id' => User::factory(),
            'is_active' => true,
        ];
    }
}
