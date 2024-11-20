<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParkirControl extends Model
{
    use HasFactory;

    protected $table = 'ParkirControl_TM';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'minMenitStlh1Jam',
        'lastChangeDate'
    ];
}