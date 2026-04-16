<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resume extends Model
{
     protected $fillable = [
        'file_name',
        'matched_keywords',
        'score'
    ];
}
