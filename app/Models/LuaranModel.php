<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LuaranModel extends Model
{
    use HasFactory;
    protected $table = 'luarans';
    protected $primaryKey = 'luaran_id';
    protected $guarded = [];
    protected $casts = [
        'luaran_id' => 'string',
    ];

    public function kknMahasiswa()
    {
        return $this->belongsTo(KknMahasiswaModel::class, 'kkn_mhs_id');
    }

    public function berkasKkn()
    {
        return $this->hasMany(BerkasKknModel::class, 'luaran_id');
    }
}
