<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'nama_pendek',
        'no_telepon',
        'alamat',
        'catatan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}