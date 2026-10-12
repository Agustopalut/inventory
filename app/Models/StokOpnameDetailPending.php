<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokOpnameDetailPending extends Model
{
    protected $table = 'stok_opname_detail_pending';

    protected $fillable = [
        'id_opname_detail_pending',
        'id_barang',
        'stok_fisik',
        'stok_sistem',
        'kd_opname_pending'
    ];

    protected $primaryKey = 'id_opname_detail_pending';
    protected $keyType = 'int';

    public function stok_opname_header_pending() {
        return $this->belongsTo(StokOpnameHeaderPending::class,"kd_opname_pending");
    }

    public function barang_master(){
        return $this->belongsTo(Barangmaster::class,'id_barang');
    }
}
