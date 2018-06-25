<?php
/**
 * Created by PhpStorm.
 * User: arslaan
 * Date: 4/5/18
 * Time: 7:28 PM
 */

namespace App\Libs;


class GooglePageSpeed
{
    public static function curl($url){
        $newUrl = "https://www.googleapis.com/pagespeedonline/v4/runPagespeed?url=$url&key=AIzaSyBMJCb2uLy_P5Wh2_WoWJfKQ0Fwezl2uno";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $newUrl);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec ($ch);

        curl_close ($ch);

        return $server_output;
//        if ($server_output == "OK") {
//            return ["data"=>$server_output, "status"=>1];
//        } else {
//            return ["data"=>$server_output, "status"=>0];
//        }

    }
}