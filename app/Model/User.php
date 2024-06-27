<?php

namespace App\Model;

use Hyperf\DbConnection\Model\Model;

class User extends Model
{
    protected $table = 'users';


    protected $primaryKey = 'id';


    protected $keyType = 'int';

    // If the primary key is not incrementing, set this to false
    public $incrementing = true;


    protected $fillable = [
        'name',
        'email',
        'password',
        'created_at',
    ];

    // Specify the fields that should be hidden for arrays
    protected $hidden = [
        'password',
    ];
}
