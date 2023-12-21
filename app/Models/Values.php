<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Values extends Model
{
    use HasFactory;

    protected $table = 'values';
    protected $fillable =[
        'keterngan_ram3'
    ];

    public $timestamps = true;
}
