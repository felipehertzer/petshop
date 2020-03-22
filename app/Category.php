<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $dates = [
        'created_at', 'updated_at'
    ];
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    /**
     * Get Pets
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pets()
    {
        return $this->hasMany('App\Pet');
    }
}
