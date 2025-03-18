<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cvs extends Model
{
    /** @use HasFactory<\Database\Factories\CvsFactory> */
    use HasFactory;

    protected $fillable = [
        'candidate_id',
        'file_path',
        'file_type',
        'file_size',
        'summary',
        'uploaded_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
