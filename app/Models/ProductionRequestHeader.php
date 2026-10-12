<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductionRequestHeader extends Model
{
    protected $table = 'production_request_header';

    protected $fillable = [
        'kd_production_request',
        'tanggal_request',
        'user_id',
        'keterangan'
    ];

    protected $primaryKey = 'kd_production_request';
    protected $keyType = 'string';
    public $incrementing = 'false';

    public function user() {
        return $this->belongsTo(User::class,'user_id');
    }
    public function production_request_detail() {
        return $this->hasMany(ProductionRequestDetail::class,'kd_production_request');
    }
}
