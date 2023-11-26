<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reviewer extends Model
{
    use HasFactory;
    protected $table = 'reviewers';
    protected $fillable = [
        'id_assignments',
        'id_datas',
        'finish'
    ];
}
