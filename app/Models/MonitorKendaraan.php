<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonitorKendaraan extends Model
{
    use HasFactory;

    protected $table = 'MonitorKendaraan_TT';
    public $timestamps = false;

    protected $fillable = [
        'waktuMasuk', 'waktuKeluar', 'jenisKendaraan', 'nomorPolisi', 'status', 'lastChangeDate'
    ];
}
