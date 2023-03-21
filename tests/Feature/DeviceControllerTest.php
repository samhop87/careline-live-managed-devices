<?php

use App\Models\Device;
use App\Models\SimCard;
use App\Models\User;

it('returns a list of devices from the index method', function () {
    Device::factory()->count(5)->create();

    $response = $this->get('/api/v1/devices');
    expect($response)
        ->status()->toBe(200)
        ->and($response->json()['data'])
        ->toHaveCount(5);
});

it('can store a new device, associated to an existing user and sim card', function() {
    $user = User::factory()->create();

    $sim = SimCard::factory()->create();

    $response = $this->post('/api/v1/devices', [
        'type' => 0,
        'serial_number' => $this->faker->unique()->uuid,
        'IMEI' => $this->faker->unique()->uuid,
        'network_provider' => 'Orange',
        'manufacturer' => 'Apple',
        'model' => 'iPhone 12',
        'OS' => 0,
        'user_id' => $user->id,
        'sim_card_id' => $sim->id,
    ]);

    expect($response)
        ->status()->toBe(201)
        ->and($response->json()['data'])
        ->toHaveKeys([
            'id',
            'type',
            'serial_number',
            'IMEI',
            'manufacturer',
            'model',
            'OS',
            'user_id',
            'is_active',
        ])
        ->and($response->json()['data']['user_id'])
        ->toBe($user->id);
});
