<?php
/**
 * Created by PhpStorm.
 * User: arslaan
 * Date: 9/6/2017
 * Time: 3:22 PM
 */

namespace App\Libs\Utils;


class Random
{
    public static function string($length = 10, $extra='') {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'.$extra;
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function number($min = 0, $max = 10) {
        return rand($min,$max);
    }

}