<?php
namespace simpl\model;

use Illuminate\Database\Eloquent\Model;

class Media extends Model {
    protected $table = 'media';
    protected $fillable = ['title', 'alt', 'type', 'filepath', 'thumb' ];
}