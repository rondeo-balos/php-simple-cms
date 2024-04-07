<?php
namespace simpl\model;

use Illuminate\Database\Eloquent\Model;

class Collections extends Model {
    protected $table = 'collections';
    protected $fillable = ['name', 'data'];
}