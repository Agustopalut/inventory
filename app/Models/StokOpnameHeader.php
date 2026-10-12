<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokOpnameHeader extends Model
{
    protected $table = 'stok_opname_header';

    protected $fillable =[
        'kd_opname',
        'tangga_opname',
        'keterangan',
        'user_id',
    ];

    protected $primaryKey = 'kd_opname';
    protected $keyType = 'string';

    public function user() {
        return $this->belongsTo(User::class,'user_id');
    }

    public function stok_opname_detail() {
        return $this->hasMany(StokOpnameDetail::class,'kd_opname');
    }
}
