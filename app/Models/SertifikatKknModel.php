<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SertifikatKknModel extends Model
{
    use HasFactory;
    protected $table = 'sertifikats';
    protected $primaryKey = 'sertifikat_id';
    protected $guarded = [];
    protected $casts = [
        'sertifikat_id' => 'string',
    ];

    public function kknMahasiswa()
    {
        return $this->belongsTo(KknMahasiswaModel::class, 'kkn_mhs_id');
    }
}