<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangkeluarDetailPending extends Model
{
    protected $table = 'barang_keluar_detail_pending';
    protected $primaryKey = 'id_detail_pending';

    protected $fillable = [
        'kd_barang_keluar_pending',
        'kd_barang_masuk',
        'jumlah_yang_diambil'
    ];

    protected $casts = [
        'jumlah_yang_diambil' => 'decimal:2',
    ];

    public function header() {
        return $this->belongsTo(BarangkeluarHeaderPending::class);
    }

    public function barang_masuk(){
        return $this->belongsTo(Barangmasuk::class,'kd_barang_masuk');
    }
}
