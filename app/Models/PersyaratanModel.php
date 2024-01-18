<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersyaratanModel extends Model
{
    use HasFactory;
    protected $table = 'persyaratans';
    protected $primaryKey = 'persyaratan_id';
    protected $guarded = [];
    protected $casts = [
        'persyaratan_id' => 'string',
    ];

    public function kkn()
    {
        return $this->belongsTo(KknModel::class, 'kkn_id');
    }
}
