<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    protected $fillable = [
        'restroom_id',
        'path',
        'caption',
    ];

    public function restroom()
    {
        return $this->belongsTo(Restroom::class);
    }
}