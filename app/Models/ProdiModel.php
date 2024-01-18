<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdiModel extends Model
{
    use HasFactory;
    protected $table = 'prodis';
    protected $primaryKey = 'prodi_id';
    protected $guarded = [];
    protected $casts = [
        'prodi_id' => 'string',
    ];

    public function fakultas()
    {
        return $this->belongsTo(FakultasModel::class, 'fakultas_id');
    }

    public function mahasiswas()
    {
        return $this->hasMany(MahasiswaModel::class, 'prodi_id');
    }

    public function dpls()
    {
        return $this->hasMany(DplModel::class, 'prodi_id');
    }
}