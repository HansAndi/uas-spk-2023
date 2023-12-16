<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kriteria extends Model
{
    use HasFactory;
    protected $table = 'kriterias';
    protected $fillable = ['nama_kriteria', 'bobot', 'tipe'];

    public function alternatif_kriteria()
    {
        return $this->hasMany(alternatif_kriteria::class);
    }

    public function sub_kriteria()
    {
        return $this->hasMany(sub_kriteria::class);
    }
}
