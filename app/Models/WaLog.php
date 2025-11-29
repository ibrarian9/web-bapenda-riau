<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WaLog extends Model
{
    protected $fillable = [
        'kendaraan_id',
        'wajib_pajak_id',
        'nama_wajib_pajak',
        'nomor_hp',
        'pesan',
        'status',
        'response_api',
    ];

    protected $casts = [
        'response_api' => 'array',
        'status' => 'boolean'
    ];
}
