<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tiket extends Model
{
    use HasFactory;
    protected $table = 'ParkirTiket_TT';
    public $timestamps = false;

    protected $fillable = [
        'id', 'jenisTiket', 'transactionIdMasuk', 'transactionIdKeluar', 'jenisKendaraan', 'configControlId', 'parkirTiketConfigId', 'totalBiaya', 'tiketText'
    ];
}
