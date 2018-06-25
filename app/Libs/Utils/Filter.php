<?php
/**
 * Created by PhpStorm.
 * User: arslaan
 * Date: 9/6/2017
 * Time: 3:22 PM
 */

namespace App\Libs\Utils;


class Filter
{
public static function pass($url, $rules){
    if($rules){
        if(isset($rules['query']) && !empty($rules['query'])){
            $parseUrl = parse_url($url);
            foreach($rules['query'] as $query){
                if(isset($parseUrl['query'])){
                    $parseUrl['query'] = html_entity_decode($parseUrl['query']);
                    $q = \GuzzleHttp\Psr7\parse_query($parseUrl['query']);
                    $q = array_keys($q);
                    if(in_array($query, $q)){
                        return false;
                    }
                }
            }

        }
        if(isset($rules['regex']) && !empty($rules['regex'])){
            foreach($rules['regex'] as $regex){
                if(preg_match("/$regex/i", $url)){
                    return false;
                }
            }

        }
    }
    return true;
}
}