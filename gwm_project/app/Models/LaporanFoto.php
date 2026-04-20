<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanFoto extends Model
{
    protected $table = 'laporan_foto';

    protected $fillable = ['laporan_id', 'path_foto'];

    public $timestamps = false;

    public function laporan()
    {
        return $this->belongsTo(Laporan::class);
    }
}
