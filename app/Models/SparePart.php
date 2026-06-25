<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SparePart extends Model
{
    protected $fillable = [
        'nama',
        'kode',
        'stok',
        'harga',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
    ];

    public function servis()
    {
        return $this->belongsToMany(Servis::class, 'servis_spare_parts')
            ->withPivot('jumlah', 'harga_satuan')
            ->withTimestamps();
    }
}