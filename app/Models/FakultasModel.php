<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FakultasModel extends Model
{
    use HasFactory;
    protected $table = 'fakultases';
    protected $primaryKey = 'fakultas_id';
    protected $guarded = [];
    protected $casts = [
        'fakultas_id' => 'string',
    ];

    public function prodis()
    {
        return $this->hasMany(ProdiModel::class, 'fakultas_id');
    }
}