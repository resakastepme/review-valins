<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Data extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'datas';
    protected $fillable = [
        'timestamp_bawaan',
        'witel',
        'id_valins',
        'eviden1',
        'eviden2',
        'eviden3',
        'id_valins_lama',
        'approve_aso',
        'keterangan_aso',
        'ram3',
        'rekon',
        'keterangan_ram3'
    ];
    public $timestamps = true;
}
