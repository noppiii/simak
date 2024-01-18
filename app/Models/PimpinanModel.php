<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PimpinanModel extends Model
{
    use HasFactory;
    protected $table = 'pimpinans';
    protected $primaryKey = 'pimpinan_id';
    protected $guarded = [];
    protected $casts = [
        'pimpinan_id' => 'string',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}