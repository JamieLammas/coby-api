<?php

namespace App;

use App\Traits\Orderable;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    Use Orderable;
    
    protected $fillable = ['title', 'file_photo'];

    public function hanger()
    {
        return $this->belongsTo(Hanger::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
