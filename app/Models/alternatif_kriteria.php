<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class alternatif_kriteria extends Model
{
    use HasFactory;
    protected $table = 'alternatif_kriterias';
    protected $fillable = ['alternatif_id', 'kriteria_id', 'value'];
}
