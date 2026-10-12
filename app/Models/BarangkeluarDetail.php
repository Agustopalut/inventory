<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangkeluarDetail extends Model
{
    protected $table = 'barang_keluar_detail';
    protected $primaryKey = 'id_detail';

    protected $fillable = [
        'id_detail',
        'kd_barang_keluar',
        'kd_barang_masuk',
        'jumlah_yang_diambil'
    ];

    protected $casts = [
        'jumlah_yang_diambil' => 'decimal:2',
    ];

    public function header() {
        return $this->belongsTo(BarangkeluarHeader::class);
    }

    public function barang_masuk() {
        return $this->belongsTo(Barangmasuk::class,'kd_barang_masuk');
    }
}
