<?php

function kursuSumma($cena, $skaits, $atlaide_no, $atlaide){

    $starpsumma = $cena * $skaits;

    if ($skaits >= $atlaide_no ){
        $atlaides_summa = ($cena * $skaits) - (($cena * $skaits) * ((100 - $atlaide) / 100));
        $atlaide = $atlaide;
    } else {
        $atlaides_summa = 0;
        $atlaide = 0; 
    }

    $gala_summa = ($cena * $skaits) * ((100 - $atlaide) / 100);


    return [
        'starpsumma' => (float)number_format($starpsumma,2), 
        'atlaide' => (float)number_format($atlaides_summa,2), 
        'gala_summa' => (float)number_format($gala_summa,2)
        ];

}