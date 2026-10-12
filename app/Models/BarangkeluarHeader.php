<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangkeluarHeader extends Model
{
    protected $table = 'barang_keluar_header';
    protected $primaryKey = 'kd_barang_keluar';

    protected $keyType = 'string'; 

    protected $fillable = [
        'kd_barang_keluar',
        'tanggal_keluar',
        'user_id',
        'keterangan',
        'tujuan',
    ];

    public function users() {
        return $this->belongsTo(User::class,'user_id');
    }

    public function detail(){
        return $this->hasMany(BarangkeluarDetail::class,'kd_barang_keluar');
    }
}

