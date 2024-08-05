<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model {
    protected $table = 'media';
    protected $fillable = [ 'title', 'alt', 'file' ];

    use HasFactory;
}
