<?php

namespace App\Models;

use Emadadly\LaravelUuid\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pesanan extends Model
{
    use HasFactory, Uuids, SoftDeletes;

    public function keranjang()
    {
        return $this->hasMany(Keranjang::class, 'id_pesanan');
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_pesanan');
    }
}
