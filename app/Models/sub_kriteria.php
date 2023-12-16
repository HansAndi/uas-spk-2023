<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sub_kriteria extends Model
{
    use HasFactory;

    protected $table = 'sub_kriterias';
    protected $fillable = [
        'kriteria_id',
        'range_kriteria',
        'value'
    ];

    public function kriteria()
    {
        return $this->belongsTo(kriteria::class);
    }
}
