<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangMasukPending extends Model
{
    protected $table = 'barang_masuk_pending';

    protected $primaryKey='kd_barang_masuk_pending';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable =[
        'kd_barang_masuk_pending',
        'id_barang',
        'jumlah',
        'sisa',
        'harga_satuan',
        'tanggal_masuk',
        'user_id',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function barang_master() {
        return $this->belongsTo(Barangmaster::class,'id_barang');
    }
}
