<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class alternatif extends Model
{
    use HasFactory;
    protected $table = 'alternatifs';
    protected $fillable = ['nama_alternatif'];

    public function alternatif_kriteria()
    {
        return $this->hasMany(alternatif_kriteria::class);
    }
}
