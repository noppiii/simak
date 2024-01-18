<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DesaModel extends Model
{
    use HasFactory;
    protected $table = 'desas';
    protected $primaryKey = 'desa_id';
    protected $guarded = [];
    protected $casts = [
        'desa_id' => 'string',
    ];

    public function kecamatan()
    {
        return $this->belongsTo(KecamatanModel::class, 'kecamatan_id');
    }
    public function kkns()
    {
        return $this->hasMany(KknModel::class, 'desa_id');
    }
}