<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilAnalisis extends Model
{
    use HasFactory;

    protected $table = 'hasil_analisis';

    protected $fillable = [
        'id_pasien', 'skor_pretest', 'skor_posttest', 'kesimpulan',
    ];

    public function pasien() {
        return $this->belongsTo(Pasien::class, 'id_pasien');
    }
}
