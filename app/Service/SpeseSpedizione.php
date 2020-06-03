<?php
namespace App\Service;


use App\Model\Country;

class SpeseSpedizione
{
    public static function get(Country $nazione, $peso, $importo)
    {
        $extra_dogana = [186,137,12,16,46,2,5,28,30,71,26,123,93,113,117,128,130,150,170,196,198];

        //per ITALIA
        if($nazione->id == "101")
        {
            if($peso > 0 && $peso < 1)
            {
                return 9;
            }

            if($importo < 49)
            {
                return 9;
            }
            return 0;
        }
        //per USA
        elseif($nazione->id == "181")
        {
            if($peso > 0 && $peso <= 5)
            {
                return 59;
            }
            elseif ($peso > 5 && $peso <= 10)
            {
                return 79;
            }
            elseif($peso > 10 && $peso <= 15)
            {
                return 119;
            }
            elseif($peso > 15 && $peso <= 20)
            {
                return 159;
            }
            elseif($peso > 20 && $peso <= 30)
            {
                return 189;
            }
            elseif($peso > 30 && $peso <= 50)
            {
                return 239;
            }
            elseif($peso > 50 && $peso <= 100)
            {
                return 390;
            }
            else
            {
                return 690;
            }
        }
        //per EUROPA DELLA COMUNITA'
        elseif($nazione->is_europa == 1 && $nazione->eu == 1)
        {
            if($peso > 0 && $peso <= 5)
            {
                if(in_array($nazione->id,$extra_dogana)){ return 39 + 50; }
                return 39;
            }
            if($peso > 5 && $peso <= 15)
            {
                if(in_array($nazione->id,$extra_dogana)){ return 48 + 50; }
                return 48;
            }
            elseif($peso > 15 && $peso <= 20)
            {
                if(in_array($nazione->id,$extra_dogana)){ return 59 + 50; }
                return 59;
            }
            elseif($peso > 20 && $peso <= 30)
            {
                if(in_array($nazione->id,$extra_dogana)){ return 69 + 50; }
                return 69;
            }
            elseif($peso > 30 && $peso <= 50)
            {
                if(in_array($nazione->id,$extra_dogana)){ return 89 + 50; }
                return 89;
            }
            elseif($peso > 50 && $peso <= 100)
            {
                if(in_array($nazione->id,$extra_dogana)){ return 129 + 50; }
                return 129;
            }
            else
            {
                if(in_array($nazione->id,$extra_dogana)){ return 290 + 50; }
                return 290;
            }
        }
        //PER EUROPA EXTRA CE
        elseif($nazione->is_europa == 1 && $nazione->eu == 0)
        {

            if($peso > 0 && $peso <= 5)
            {
                if(in_array($nazione->id,$extra_dogana)){ return 89 + 50; }
                return 89;
            }
            elseif($peso > 5 && $peso <= 15)
            {
                if(in_array($nazione->id,$extra_dogana)){ return 98 + 50; }
                return 98;
            }
            elseif($peso > 15 && $peso <= 20)
            {
                if(in_array($nazione->id,$extra_dogana)){ return 109 + 50; }
                return 109;
            }
            elseif($peso > 20 && $peso <= 30)
            {
                if(in_array($nazione->id,$extra_dogana)){ return 119 + 50; }
                return 119;
            }
            elseif($peso > 30 && $peso <= 50)
            {
                if(in_array($nazione->id,$extra_dogana)){ return 139 + 50; }
                return 139;
            }
            elseif($peso > 50 && $peso <= 100)
            {
                if(in_array($nazione->id,$extra_dogana)){ return 179 + 50; }
                return 179;
            }
            else
            {
                return 390;
            }
        }
        // NON EUROPA
        else
        {
            if($peso > 0 && $peso <= 1)
            {
                return 69;
            }
            elseif($peso > 1 && $peso <= 5)
            {
                return 89;
            }
            elseif ($peso > 5 && $peso <= 10)
            {
                return 119;
            }
            elseif($peso > 10 && $peso <= 15)
            {
                return 169;
            }
            elseif($peso > 15 && $peso <= 20)
            {
                return 229;
            }
            elseif($peso > 20 && $peso <= 30)
            {
                return 269;
            }
            elseif($peso > 30 && $peso <= 50)
            {
                return 329;
            }
            elseif($peso > 50 && $peso <= 100)
            {
                return 590;
            }
            else
            {
                return 980;
            }
        }
    }
}