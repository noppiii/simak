<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelompokModel extends Model
{
    use HasFactory;
    protected $table = 'kelompoks';
    protected $primaryKey = 'kelompok_id';
    protected $guarded = [];
    protected $casts = [
        'kelompok_id' => 'string',
    ];

    public function kknMahasiswas()
    {
        return $this->hasMany(KknMahasiswaModel::class, 'kelompok_id');
    }
}