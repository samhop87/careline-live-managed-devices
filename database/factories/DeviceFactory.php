<?php

namespace Database\Factories;

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
            'type' => $this->faker->numberBetween(0,1),
            'serial_number' => $this->faker->unique()->uuid,
            'IMEI' => $this->faker->unique()->uuid,
            'manufacturer' => $this->faker->company,
            'model' => $this->faker->word,
            'os' => $this->faker->numberBetween(0, 5),
            'user_id' => User::factory(),
            'is_active' => true,
        ];
    }
}
