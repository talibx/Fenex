<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Note extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'details',
        'tags',
        'user_id',
        'photos', // ✅ ADD THIS
    ];

    protected $casts = [
        'tags' => 'string',
         'photos' => 'array', // ✅ ADD THIS
    ];

    // relationships
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
