<?php
namespace simpl\model;

use Illuminate\Database\Eloquent\Model;

class Page extends Model {
    protected $table = 'pages';
    protected $fillable = ['title', 'slug', 'author', 'content', 'fields', 'status'];
}