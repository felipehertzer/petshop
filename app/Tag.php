<?php


namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tags';
    protected $dates = [
        'created_at', 'updated_at'
    ];
    protected $hidden = [
        'created_at', 'updated_at', 'petId'
    ];

    public function pet()
    {
        return $this->belongsTo('App\Pet');
    }
}
