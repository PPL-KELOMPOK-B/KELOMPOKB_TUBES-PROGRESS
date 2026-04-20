<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $table = 'laporan';

    protected $fillable = [
        'user_id', 'kecamatan_id', 'kelurahan_id', 'kondisi_air',
        'jumlah_terdampak', 'durasi_hari', 'status', 'level', 'catatan'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class);
    }

    public function fotos()
    {
        return $this->hasMany(LaporanFoto::class);
    }

    public function validasi()
    {
        return $this->hasOne(Validasi::class);
    }
}
