<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApprovalRequest extends Model
{
    protected $table = 'approval_request';
    protected $primaryKey = 'id_request';

    protected $keyType = 'int';
    protected $fillable =[
        'id_request',
        'kd_transaksi_pending',
        'user_id',
        'modul',
        'tanggal_request',
        'aksi',
        'status'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
