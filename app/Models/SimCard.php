<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimCard extends Model
{
    use HasFactory;

    public function phoneNumber()
    {
        return $this->hasOne(PhoneNumber::class);
    }
}
