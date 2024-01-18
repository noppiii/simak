<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkemaModel extends Model
{
    use HasFactory;
    protected $table = 'skemas';
    protected $primaryKey = 'skema_id';
    protected $guarded = [];
    protected $casts = [
        'skema_id' => 'string',
    ];

    public function kkns()
    {
        return $this->hasMany(KknModel::class, 'skema_id');
    }
}