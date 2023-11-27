<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;
    protected $table = 'assignments';
    protected $fillable = [
        'id_reviewer',
        'reviewer',
        'tugas_dari',
        'komentar'
    ];

    public function getUsers()
    {
        return $this->belongsTo(User::class, 'tugas_dari', 'id');
    }

    public function getReviewers()
    {
        return $this->belongsTo(User::class, 'reviewer', 'id');
    }
}
