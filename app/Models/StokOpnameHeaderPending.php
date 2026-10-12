<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokOpnameHeaderPending extends Model
{
    protected $table = 'stok_opname_header_pending';

    protected $fillable =[
        'kd_opname_pending',
        'tangga_opname',
        'keterangan',
        'user_id',
    ];

    protected $primaryKey = 'kd_opname_pending';
    protected $keyType = 'string';

    public function user() {
        return $this->belongsTo(User::class,'user_id');
    }

    public function stok_opname_detail_pending() {
        return $this->hasMany(StokOpnameDetailPending::class,'kd_opname_pending');
    }
}
