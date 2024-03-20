<?php
namespace simpl\model;

use Illuminate\Database\Eloquent\Model;

class Media extends Model {
    protected $table = 'pages';
    protected $fillable = ['title', 'alt', 'filepath' ];
}