<?php
/**
 * Created by PhpStorm.
 * User: arslaan
 * Date: 9/6/2017
 * Time: 3:22 PM
 */

namespace App\Libs\Utils;


class SetValues
{
public function register($f, $item=null, $method='GET'){
    $data = [];
    foreach($f as $i){
        if($i->status==0)continue;
        if($item=='selects'){
            $size = sizeof($i->options)-1;
            if(isset($i->attr['name'])){
                $data[$i->attr['name']] = $i->options[rand(0,$size)];
            }
        }elseif($item=='textareas'){
            if(isset($i->attr['name'])){
                if($method=='PATCH'){
                    $data[$i->attr['name']] = $i->value;
                }else{
                    $data[$i->attr['name']] = Random::string(150, ' ');
                }
            }
        }else{
            if(isset($i->attr['name'])){
                if($method=='PATCH'){
                    $data[$i->attr['name']] = $i->attr['value'];
                }else{
                    if($i->attr['name']=='email'){
                        $data[$i->attr['name']] = Random::string(10).'+test'.Random::number().'@ztechstudio.com';
                    }else{
                        $data[$i->attr['name']] = Random::string(6);
                    }

                }
            }
        }


    }
    return $data;
}
}