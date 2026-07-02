<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    protected $table = 'kendaraan';

    protected $fillable = [
        'user_id',
        'merek',
        'model',
        'tahun',
        'odometer',
        'warna',
        'plat_nomor',
        'vin',
        'jenis',
        'foto',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function servis()
    {
        return $this->hasMany(Servis::class);
    }

    public function getNamaLengkapAttribute()
    {
        return "{$this->tahun} {$this->merek} {$this->model}";
    }
}