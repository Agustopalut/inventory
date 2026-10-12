<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductionRequestDetail extends Model
{
    protected $table = 'production_request_detail';

    protected $fillable = [
        'id_detail_production_request',
        'kd_production_request',
        'id_barang',
        'jumlah_yang_diminta'
    ];
    protected $primaryKey = 'id_detail_production_request';
    protected $keyType = 'int';
    public $incrementing = true;

    public function production_request_header() {
        return $this->belongsTo(ProductionRequestHeader::class,'kd_production_request');
    }

    public function barang_master(){
        return $this->belongsTo(Barangmaster::class,'id_barang');
    }
}
