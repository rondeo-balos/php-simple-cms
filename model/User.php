<?php
namespace simpl\model;

use Illuminate\Database\Eloquent\Model;

class User extends Model {
    protected $table = 'users';
    protected $fillable = ['email', 'password', 'firstname', 'lastname', 'token'];
}