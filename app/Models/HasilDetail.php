<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilDetail extends Model
{
    use HasFactory;
    protected $table = 'hasil_detail';

    protected $fillable = [
        'id_hasil',
        'kode_barang',
        'nama_barang',
        'peringkat',
    ];

    public function hasil()
    {
        return $this->belongsTo(Hasil::class, 'id_hasil');
    }
}
