<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ItalOrder extends Model
{
    //decommentare per fare sincronizzazione
    //public $timestamps = false;

    protected $fillable = [
        'user_id',
        'sconto',
        'imponibile',
        'iva',
        'importo',
        'locale'
    ];

    public function orderDetails()
    {
        return $this->hasMany('App\Model\OrderDetail');
    }

    public function orderShipping()
    {
        return $this->hasOne('App\Model\OrderShipping');
    }

    public function user()
    {
        return $this->belongsTo('App\Model\Website\User');
    }
}