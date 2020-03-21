<?php


namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $dates = [
        'created_at', 'updated_at', 'shipDate'
    ];

    public function pet()
    {
        return $this->belongsTo('App\Pet');
    }
}
