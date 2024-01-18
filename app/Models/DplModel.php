<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DplModel extends Model
{
    use HasFactory;
    protected $table = 'dpls';
    protected $primaryKey = 'dpl_id';
    protected $guarded = [];
    protected $casts = [
        'dpl_id' => 'string',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function prodi()
    {
        return $this->belongsTo(ProdiModel::class, 'prodi_id');
    }

    public function kknMahasiswas()
    {
        return $this->hasMany(KknMahasiswaModel::class, 'dpl_id');
    }
}