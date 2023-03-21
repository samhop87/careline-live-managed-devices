<?php

use App\Models\Device;
use App\Models\User;

it('a user can have multiple devices', function () {
    $user = User::factory()->create();
    $count = $this->faker->randomNumber(1);
    $devices = Device::factory()->count($count)->create();
    $user->devices()->attach($devices);

    expect($user->devices)->toHaveCount($count);
    $this->assertDatabaseCount('user_devices', $count);
});
