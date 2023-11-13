<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreviewData extends Model
{
    use HasFactory;
    protected $table = 'preview_datas';
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
        'keterangan_ram3',
        'unique_id',
        'isValid',
        'isSubmit',
        'upload_by'
    ];
    public $timestamps = true;
}
