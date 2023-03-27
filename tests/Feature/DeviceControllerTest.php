<?php

use App\Enums\DeviceTypeEnum;
use App\Enums\OsEnum;
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

it('returns a list of devices filtered by operating system', function () {
    $droidCount = $this->faker->randomNumber(1);
    $appleCount = $this->faker->randomNumber(1);
    $blackberryCount = $this->faker->randomNumber(1);

    Device::factory()->count($droidCount)->create([
        'os' => OsEnum::ANDROID
    ]);

    Device::factory()->count($appleCount)->create([
        'os' => OsEnum::IOS
    ]);

    Device::factory()->count($blackberryCount)->create([
        'os' => OsEnum::BLACKBERRY
    ]);

    $arrayParam = [
        'operating_system' => [OsEnum::ANDROID->value]
    ];

    $response = $this->getJson(route('devices.index', $arrayParam));

    expect($response)
        ->status()->toBe(200)
        ->and($response->json()['data'])
        ->toHaveCount($droidCount);

    $arrayParam = [
        'operating_system' => [OsEnum::ANDROID->value, OsEnum::BLACKBERRY->value]
    ];

    $response = $this->getJson(route('devices.index', $arrayParam));

    expect($response)
        ->status()->toBe(200)
        ->and($response->json()['data'])
        ->toHaveCount($droidCount + $blackberryCount);

});

it('can store a new device, associated to an existing user and sim card', function() {
    $user = User::factory()->create();

    $sim = SimCard::factory()->create();

    $response = $this->post('/api/v1/devices', [
        'type' => collect(DeviceTypeEnum::cases())->random()->value,
        'serial_number' => $this->faker->unique()->uuid,
        'imei' => $this->faker->unique()->uuid,
        'manufacturer' => 'Apple',
        'model' => 'iPhone 12',
        'os' => collect(OsEnum::cases())->random()->value,
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
            'os',
            'current_user',
            'is_active',
        ])
        ->and($response->json()['data']['current_user'][0]['id'])
        ->toBe($user->id);
});
