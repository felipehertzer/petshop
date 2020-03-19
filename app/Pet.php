<?php


namespace App;

use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    protected $table = 'pets';
    protected $dates = [
        'created_at', 'updated_at'
    ];
}
