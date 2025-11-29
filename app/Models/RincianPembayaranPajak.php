<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RincianPembayaranPajak extends Model
{
    protected $fillable = [
        'pembayaran_pajak_id',
        'jatuh_tempo',
        'pkb',
        'swdkllj',
        'denda',
        'total_bayar'
    ];

    public function pembayaran()
    {
        return $this->belongsTo(PembayaranPajak::class);
    }
}
