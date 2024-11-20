<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $table = 'ParkirTransaction_TT';
    public $timestamps = false;

    protected $fillable = [
        'waktu', 'status', 'jenisKendaraan', 'nomorPolisi'
    ];
}
