<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StokOpnameDetail extends Model
{
    protected $table = 'stok_opname_detail';

    protected $fillable = [
        'id_opname_detail',
        'id_barang',
        'stok_fisik',
        'stok_sistem',
        'kd_opname'
    ];

    protected $primaryKey = 'id_opname_detail';

    protected $keyType = 'int';


    public function stok_opname_header() {
        return $this->belongsTo(StokOpnameHeader::class,'kd_opname');
    }

    public function barang_master() {
        return $this->BelongsTo(Barangmaster::class,'id_barang');
    }
}
