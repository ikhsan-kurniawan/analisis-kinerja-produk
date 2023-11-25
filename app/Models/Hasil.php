<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hasil extends Model
{
    use HasFactory;
    protected $table = 'hasil';

    protected $fillable = [
        'periode',
        // 'kode_hasil',
        // 'kode_barang',
        // 'nama_barang',
        // 'peringkat',
    ];

    public function hasilDetail()
    {
        return $this->hasMany(HasilDetail::class, 'id_hasil');
    }
}
