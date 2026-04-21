<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $fillable = [
        'user_id', 'kecamatan', 'kelurahan', 'kondisi_air', 
        'warga_terdampak', 'durasi_kekeringan', 'foto', 
        'keterangan', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
