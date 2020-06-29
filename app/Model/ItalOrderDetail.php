<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ItalOrderDetail extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'codice',
        'nome_prodotto',
        'qta',
        'prezzo',
        'totale',
    ];

    public function order()
    {
        return $this->belongsTo('App\Model\ItalOrder','order_id');
    }

    public function product()
    {
        return $this->belongsTo('App\Model\Product');
    }
}