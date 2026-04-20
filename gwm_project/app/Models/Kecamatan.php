<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    protected $table = 'kecamatan';

    protected $fillable = ['nama_kecamatan'];

    public function kelurahan()
    {
        return $this->hasMany(Kelurahan::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
