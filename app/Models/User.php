<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function Barangmaster(){
        return $this->hasMany(Barangmaster::class,'user_id');
    }

    public function Barangmasuk() {
        return $this->hasMany(Barangmasuk::class,'user_id');
    }

    public function BarangmasukPending() {
        return $this->hasMany(BarangMasukPending::class,'user_id');
    }

    public function BarangkeluarHeader(){
        return $this->hasMany(BarangkeluarHeader::class,'user_id');
    }

    public function BarangkeluarHeaderPending() {
        return $this->hasMany(BarangkeluarHeaderPending::class,'user_id');
    }

    public function StokopnameHeader() {
        return $this->hasMany(StokOpnameHeader::class,'user_id');
    }
    public function StokopnameHeaderPending() {
        return $this->hasMany(StokOpnameHeaderPending::class,'user_id');
    }

    public function ApprovalRequest() {
        return $this->hasMany(ApprovalRequest::class,'user_id');
    }

    public function ProductionRequest() {
        return $this->hasMany(ProductionRequestHeader::class,'user_id');
    }
}
