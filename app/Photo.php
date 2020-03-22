<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $table = 'photos';
    protected $dates = [
        'created_at', 'updated_at'
    ];
    protected $hidden = [
        'created_at', 'updated_at', 'petId', 'additionalMetadata'
    ];

    public function pet()
    {
        return $this->belongsTo('App\Pet');
    }
}
