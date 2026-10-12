<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangkeluarHeaderPending extends Model
{
     protected $table = 'barang_keluar_header_pending';

    protected $fillable = [
        'kd_barang_keluar_pending',
        'tanggal_keluar',
        'user_id',
        'keterangan',
        'tujuan',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function detail() {
        return $this->hasMany(BarangkeluarDetailPending::class,'kd_barang_keluar_pending');
    }
}
