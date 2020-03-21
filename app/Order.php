<?php


namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $dates = [
        'created_at', 'updated_at', 'shipDate'
    ];
    protected $hidden = [
        'created_at', 'updated_at', 'pet'
    ];
    protected $casts = [
        'shipDate' => 'datetime:Y-m-d\TH:i:s.v\Z',
    ];

    public function pet()
    {
        return $this->hasOne('App\Pet', 'id', 'petId');
    }
}
