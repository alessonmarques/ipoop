<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'restroom_id', 'reason', 'resolved'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function restroom() {
        return $this->belongsTo(Restroom::class);
    }
}