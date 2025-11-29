<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    protected $fillable = [
        'wajib_pajak_id',
        'nopol',
        'merek',
        'tipe',
        'tahun_pembuatan',
        'warna',
        'nomor_mesin',
        'nomor_rangka'
    ];

    public function wajibPajak()
    {
        return $this->belongsTo(WajibPajak::class);
    }

    public function pajak()
    {
        return $this->hasOne(Pajak::class);
    }

    public function pembayaran()
    {
        return $this->hasOne(PembayaranPajak::class)->latestOfMany();
    }

    public static $tipeList = [
        'Sepeda Motor',
        'Mobil',
        'Pick Up',
        'Truk',
        'Bus'
    ];
}
