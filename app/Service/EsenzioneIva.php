<?php
namespace App\Service;


class EsenzioneIva
{
    public static function get($nazione)
    {
        $esenzione_iva = 0;

        //EUROPA Extra UE
        if($nazione->is_europa == 1 && $nazione->eu == 0)
        {
            $esenzione_iva = 1;
        }
        //NON EUROPA
        elseif($nazione->is_europa == 0)
        {
            $esenzione_iva = 1;
        }

        return $esenzione_iva;
    }
}