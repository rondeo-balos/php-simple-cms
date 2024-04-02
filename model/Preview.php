<?php
namespace simpl\model;

use Illuminate\Database\Eloquent\Model;

class Preview extends Model {
    protected $table = 'previews';
    protected $fillable = ['token', 'data'];
}