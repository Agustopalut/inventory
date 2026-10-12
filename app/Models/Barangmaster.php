<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barangmaster extends Model
{
    protected $table = 'barang_master';
    protected $primaryKey = 'id_barang';
    protected $fillable =[  
        'id_barang',
        'nama_barang',
        'stok',
        'satuan',
        'user_id'
    ];

    protected $casts = [
        'stok' => 'decimal:2',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function stok_opname_detail() {
        return $this->hasMany(StokOpnameDetail::class,'id_barang');
    }
    public function stok_opname_detail_pending() {
        return $this->hasMany(StokOpnameDetailPending::class,'id_barang');
    }

    public function barang_masuk() {
        return $this->hasMany(Barangmasuk::class,'id_barang');
    }
    public function barang_masuk_pending() {
        return $this->hasMany(BarangMasukPending::class,'id_barang');
    }
    public function production_request_detail() {
        return $this->hasMany(ProductionRequestDetail::class,'id_barang');
    }
}
