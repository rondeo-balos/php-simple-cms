<?php
namespace simpl\model;

use Illuminate\Database\Eloquent\Model;

class Page extends Model {
    protected $table = 'pages';
    protected $fillable = ['title', 'description', 'visibility', 'path', 'blocks', 'fields', 'layout', 'status', 'author', 'token'];
}