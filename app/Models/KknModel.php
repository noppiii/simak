<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KknModel extends Model
{
    use HasFactory;
    protected $table = 'kkns';
    protected $primaryKey = 'kkn_id';
    protected $guarded = [];
    protected $casts = [
        'kkn_id' => 'string',
    ];

    public function desa()
    {
        return $this->belongsTo(DesaModel::class, 'desa_id');
    }

    public function skema()
    {
        return $this->belongsTo(SkemaModel::class, 'skema_id');
    }

    public function periode()
    {
        return $this->belongsTo(PeriodeModel::class, 'periode_id');
    }

    public function persyaratans()
    {
        return $this->hasMany(PersyaratanModel::class, 'kkn_id');
    }
    public function kknMahasiswas()
    {
        return $this->hasMany(KknMahasiswaModel::class, 'kkn_id');
    }
}