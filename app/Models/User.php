<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Ramsey\Uuid\Uuid;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    protected $guarded = [];
    protected $casts = [
        'user_id' => 'string',
    ];

    public function getAuthIdentifierName()
    {
        return 'user_id';
    }

    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getRememberToken()
    {
        return $this->{$this->getRememberTokenName()};
    }

    public function setRememberToken($value)
    {
        $this->{$this->getRememberTokenName()} = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    public function role()
    {
        return $this->belongsTo(RoleModel::class, 'role_id');
    }

    public function admin()
    {
        return $this->hasOne(AdminModel::class, 'user_id');
    }
    public function pimpinan()
    {
        return $this->hasOne(PimpinanModel::class, 'user_id');
    }

    public function mahasiswa()
    {
        return $this->hasOne(MahasiswaModel::class, 'user_id');
    }
    public function staff()
    {
        return $this->hasOne(StaffModel::class, 'user_id');
    }

    public function dpl()
    {
        return $this->hasOne(DplModel::class, 'user_id');
    }
}
