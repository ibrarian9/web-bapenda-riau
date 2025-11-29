<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PembayaranPajak extends Model
{
    protected $fillable = [
        'kendaraan_id',
        'jenis_pajak',
        'tanggal_bayar',
        'jumlah_bayar'
    ];

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }

    public function rincian()
    {
        return $this->hasOne(RincianPembayaranPajak::class);
    }

    public static $jenisPajakList = [
        'Pajak 1 Tahun',
        'Pajak 5 Tahun',
    ];
}
