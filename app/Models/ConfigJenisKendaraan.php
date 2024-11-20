<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigJenisKendaraan extends Model
{
    use HasFactory;

    protected $table = 'ParkirConfigJenisKendaraan_TM';
    public $timestamps = false;

    protected $fillable = [
        'jenisKendaraan', 'biayaPerJam', 'maxBiaya', 'lastChangeDate'
    ];
}
