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

    /**
     * Get Category
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function category()
    {
        return $this->hasOne('App\Category', 'id', 'categoryId');
    }

    /**
     * Get Tags
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tags()
    {
        return $this->hasMany('App\Tag', 'petId', 'id');
    }

    /**
     * Get Photos
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function photoUrls()
    {
        return $this->hasMany('App\Photo', 'petId', 'id');
    }
}
