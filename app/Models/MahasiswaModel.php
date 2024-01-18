<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MahasiswaModel extends Model
{
    use HasFactory;
    protected $table = 'mahasiswas';
    protected $primaryKey = 'mahasiswa_id';
    protected $guarded = [];
    protected $casts = [
        'mahasiswa_id' => 'string',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function prodi()
    {
        return $this->belongsTo(ProdiModel::class, "prodi_id");
    }

    public function kknMahasiswa()
    {
        return $this->hasOne(KknMahasiswaModel::class, 'mahasiswa_id');
    }
}