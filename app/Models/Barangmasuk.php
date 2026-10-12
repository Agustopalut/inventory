<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barangmasuk extends Model
{
    protected $table = 'barang_masuk';

    protected $primaryKey = 'kd_barang_masuk';
    protected $keyType = 'string';

    public $incrementing = false;
    protected $fillable =[
        'kd_barang_masuk',
        'id_barang',
        'jumlah',
        'sisa',
        'harga_satuan',
        'tanggal_masuk',
        'user_id',
    ];

    protected $casts = [
        'jumlah' => 'decimal:2',
        'sisa' => 'decimal:2'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function barang_keluar_detail() {
        return $this->hasMany(BarangkeluarDetail::class,'kd_barang_masuk');
    }

    public function barang_keluar_detail_pending() {
        return $this->hasMany(BarangkeluarDetailPending::class,'kd_barang_masuk');
    }

    public function barang_master() {
        return $this->belongsTo(Barangmaster::class,'id_barang');
    }

    
}
