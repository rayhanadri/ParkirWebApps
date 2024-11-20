<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiketConfig extends Model
{
    use HasFactory;

    protected $table = 'ParkirTiketConfig_TM';
    public $timestamps = false;

    protected $fillable = [
        'id', 'jenisTiket', 'tiketTextTemplate', 'lastChangeDate'
    ];
}
