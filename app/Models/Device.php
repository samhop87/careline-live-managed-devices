<?php

namespace App\Models;

use App\Enums\DeviceTypeEnum;
use App\Enums\OsEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Device extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'type' => DeviceTypeEnum::class,
        'os' => OsEnum::class,
    ];

    public function user(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_devices');
    }

    public function simCard(): HasOne
    {
        return $this->hasOne(SimCard::class);
    }
}
