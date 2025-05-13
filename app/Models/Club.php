<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'logo',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function members()
    {
        return $this->hasMany(ClubMember::class);
    }

    public function applications()
    {
        return $this->hasMany(ClubApplication::class);
    }
}
