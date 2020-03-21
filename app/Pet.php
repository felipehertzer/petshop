<?php


namespace App;

use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    protected $table = 'pets';
    protected $dates = [
        'created_at', 'updated_at'
    ];
    protected $hidden = [
        'created_at', 'updated_at', 'categoryId'
    ];

    public function category()
    {
        return $this->hasOne('App\Category', 'id', 'categoryId');
    }

    public function tags()
    {
        return $this->hasMany('App\Tag', 'petId', 'id');
    }

    public function photos()
    {
        return $this->hasMany('App\Photo', 'petId', 'id');
    }
}
