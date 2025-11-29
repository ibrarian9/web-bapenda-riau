<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pajak extends Model
{
    protected $fillable = [
        'kendaraan_id',
        'njkb',
        'tenggat_jatuh_tempo',
        'status_awal'
    ];

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }

    public static $statusPajakList = [
        'Belum Bayar Pajak',
        'Sudah Bayar Pajak',
    ];
}
