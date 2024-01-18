<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KabupatenModel extends Model
{
    use HasFactory;
    protected $table = 'kabupatens';
    protected $primaryKey = 'kabupaten_id';
    protected $guarded = [];
    protected $casts = [
        'kabupaten_id' => 'string',
    ];

    public function kecamatans()
    {
        return $this->hasMany(KecamatanModel::class, 'kabupaten_id');
    }
}