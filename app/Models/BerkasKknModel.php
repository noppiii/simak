<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BerkasKknModel extends Model
{
    use HasFactory;
    protected $table = 'berkases';
    protected $primaryKey = 'berkas_id';
    protected $guarded = [];
    protected $casts = [
        'berkas_id' => 'string',
    ];

    public function luaran()
    {
        return $this->belongsTo(LuaranModel::class, 'luaran_id');
    }

    public function getDocumentUrlAttribute()
    {
        return url('storage/store/luaran-berkas/' . $this->file_berkas);
    }

    public function hasAdditionalAttachment()
    {
        return !empty($this->additionalAttachment); // Assuming additionalAttachment is a property in your Task model
    }
}