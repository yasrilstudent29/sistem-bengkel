<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mekanik extends Model
{
    protected $table = 'mekanik';

    protected $fillable = [
        'nama',
        'no_telepon',
        'spesialisasi',
        'status',
    ];

    public function servis()
    {
        return $this->hasMany(Servis::class);
    }
}