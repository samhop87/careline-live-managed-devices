<?php

use App\Models\Device;
use App\Models\SimCard;
use App\Models\User;
use App\Types\DeviceType;
use App\Types\OS;

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
        'type' => DeviceType::typesCollection()->random(),
        'serial_number' => $this->faker->unique()->uuid,
        'imei' => $this->faker->unique()->uuid,
        'manufacturer' => 'Apple',
        'model' => 'iPhone 12',
        'os' => OS::typesCollection()->random(),
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
            'current_user',
            'is_active',
        ])
        ->and($response->json()['data']['current_user'][0]['id'])
        ->toBe($user->id);
});
