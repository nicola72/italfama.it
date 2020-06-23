<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;


class Catalog extends Model implements Sortable
{

    use SortableTrait;

    public $sortable = [
        'order_column_name' => 'order',
        'sort_when_creating' => true,
    ];

    protected $fillable = [
        'id',
        'nome_it',
        'nome_en',
        'nome_de',
        'nome_fr',
        'nome_es',
        'nome_ru',
        'visibile',
        'order',
    ];

    public function images()
    {
        return $this->morphMany('App\Model\File','fileable');
    }

    public function cover()
    {
        $images = $this->morphMany('App\Model\File','fileable');
        if($images)
        {
            $images = $images->orderBy('order');
            $prima_img = $images->where('type',1)->first();
            if(is_object($prima_img))
            {
                return $images->first()->path;
            }
        }
        return 'pdf.png';
    }

    public function pdf()
    {
        $images = $this->morphMany('App\Model\File','fileable');
        if($images)
        {
            $images = $images->orderBy('order');
            $prima_img = $images->where('type',2)->first();
            if(is_object($prima_img))
            {
                return $images->first()->path;
            }
        }
        return 'pdf.png';
    }
}
