<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servis extends Model
{
    protected $table = 'servis';

    protected $fillable = [
        'kendaraan_id',
        'mekanik_id',
        'tanggal_masuk',
        'tanggal_selesai',
        'keluhan',
        'catatan_mekanik',
        'status',
        'total_biaya',
    ];

    protected $casts = [
        'tanggal_masuk' => 'date',
        'tanggal_selesai' => 'date',
        'total_biaya' => 'decimal:2',
    ];

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }

    public function mekanik()
    {
        return $this->belongsTo(Mekanik::class);
    }

    public function spareParts()
    {
        return $this->belongsToMany(SparePart::class, 'servis_spare_parts')
            ->withPivot('jumlah', 'harga_satuan')
            ->withTimestamps();
    }
}