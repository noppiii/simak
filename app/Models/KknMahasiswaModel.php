<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KknMahasiswaModel extends Model
{
    use HasFactory;
    protected $table = 'kkn_mahasiswas';
    protected $primaryKey = 'kkn_mhs_id';
    protected $guarded = [];
    protected $casts = [
        'kkn_mhs_id' => 'string',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(MahasiswaModel::class, 'mahasiswa_id');
    }

    public function dpl()
    {
        return $this->belongsTo(DplModel::class, 'dpl_id');
    }

    public function kelompok()
    {
        return $this->belongsTo(KelompokModel::class, 'kelompok_id');
    }

    public function kkn()
    {
        return $this->belongsTo(KknModel::class, 'kkn_id');
    }

    // public function berkasKkn()
    // {
    //     return $this->hasMany(BerkasKknModel::class, 'kkn_mhs_id');
    // }

    public function luaran()
    {
        return $this->hasOne(LuaranModel::class, 'kkn_mhs_id');
    }

    public function sertifikatKkn()
    {
        return $this->hasOne(SertifikatKknModel::class, 'kkn_mhs_id');
    }
}
