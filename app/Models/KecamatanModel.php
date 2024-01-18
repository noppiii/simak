<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KecamatanModel extends Model
{
    use HasFactory;
    protected $table = 'kecamatans';
    protected $primaryKey = 'kecamatan_id';
    protected $guarded = [];
    protected $casts = [
        'kecamatan_id' => 'string',
    ];

    public function desas()
    {
        return $this->hasMany(DesaModel::class, 'kecamatan_id');
    }

    public function kabupaten()
    {
        return $this->belongsTo(KabupatenModel::class, 'kabupaten_id');
    }
}