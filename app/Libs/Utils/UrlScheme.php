<?php
/**
 * Created by PhpStorm.
 * User: arslaan
 * Date: 9/6/2017
 * Time: 3:22 PM
 */

namespace App\Libs\Utils;


class UrlScheme
{
    public static function completeLink($pageLink, $url)
    {
        $urlArray = parse_url($url);
        if (isset($urlArray['scheme'])) {
            if($urlArray['scheme']=='http' || $urlArray['scheme']=='https')return $url;
            else return $pageLink;
        }else{
            $baseUrl = parse_url($pageLink);
            $scheme = '';
            $host = '';
            extract($baseUrl);
            if(isset($path) && isset($urlArray['path'])){
                if (substr($urlArray['path'], 0, 1) === '/'){
                    $newPath = $urlArray['path'];
                }else{
                    $newPath = preg_replace('/[^\/]+(?=\/$|$)/i', $urlArray['path'], $path);
                }
            }elseif(!isset($urlArray['path']) && isset($path)){
                $newPath = '/'.$path;
            }elseif(isset($urlArray['path']) && !isset($path)){
                $newPath = '/'.$urlArray['path'];
            }else{
                $newPath='/';
            }
            $newPath = str_replace('//', '/', $newPath);
            if($newPath=='/')$newPath='';
            $port = isset($port) ? ':' . $port : '';
            $query = isset($urlArray['query']) ? '?' . $urlArray['query'] : '';
            $fragment = isset($urlArray['fragment']) ? '#' . $urlArray['fragment'] : '';

            return $scheme . '://' . $host . $port . $newPath . $query . $fragment;
        }

    }
    static function rel2abs($base,$rel)
    {
        if($rel=='') return $base;

        if(strpos($rel,"//")===0)
        {
            return "http:".$rel;
        }
        /* return if  already absolute URL */
        if  (parse_url($rel, PHP_URL_SCHEME) != '') return $rel;
        /* queries and  anchors */
        if ($rel[0]=='#'  || $rel[0]=='?') return $base.$rel;
        /* parse base URL  and convert to local variables:
        $scheme, $host,  $path */
        $parseUri = parse_url($base);
        $scheme = $parseUri['scheme'];
        $host = $parseUri['host'];
        if(isset($parseUri['port']) && $parseUri['port']!='')$host.=':'.$parseUri['port'];

        $path = isset($parseUri['path']) ? $parseUri['path'] : '';
        //extract(parse_url($base));
        /* remove  non-directory element from path */
        $path = preg_replace('#/[^/]*$#',  '', $path);
        /* destroy path if  relative url points to root */
        if ($rel[0] ==  '/') $path = '';
        /* dirty absolute  URL */
        $abs =  "$host$path/$rel";
        /* replace '//' or  '/./' or '/foo/../' with '/' */
        $re =  array('#(/\.?/)#', '#/(?!\.\.)[^/]+/\.\./#');
        for($n=1; $n>0;  $abs=preg_replace($re, '/', $abs, -1, $n)) {}
        /* absolute URL is  ready! */
        return  $scheme.'://'.$abs;
    }



}