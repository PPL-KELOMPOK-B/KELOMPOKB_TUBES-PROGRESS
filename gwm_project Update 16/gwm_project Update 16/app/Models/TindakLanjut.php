<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TindakLanjut extends Model
{
    protected $table = 'tindak_lanjuts';
    protected $fillable = ['laporan_id', 'deskripsi_aksi', 'deskripsi_selesai', 'tanggal', 'status'];

    public function laporan()
    {
        return $this->belongsTo(Laporan::class);
    }
}
