<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WajibPajak extends Model
{
    protected $fillable = [
        'nik',
        'nama',
        'alamat',
        'nomor_hp'
    ];

    public function kendaraans()
    {
        return $this->hasMany(Kendaraan::class);
    }
}
