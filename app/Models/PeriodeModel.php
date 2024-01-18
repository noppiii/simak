<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodeModel extends Model
{
    use HasFactory;
    protected $table = 'periodes';
    protected $primaryKey = 'periode_id';
    protected $guarded = [];
    protected $casts = [
        'periode_id' => 'string',
    ];

    public function kkns()
    {
        return $this->hasMany(KknModel::class, 'periode_id');
    }
}