<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    protected $table = 'kendaraan';

    protected $fillable = [
        'user_id',
        'nama_kendaraan',
        'merek',
        'model',
        'tahun',
        'plat_nomor',
        'jenis',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function servis()
    {
        return $this->hasMany(Servis::class);
    }
}