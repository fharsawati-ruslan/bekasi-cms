<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
public function vouchers()
{
    return $this->hasMany(\App\Models\Voucher::class);
}
}
