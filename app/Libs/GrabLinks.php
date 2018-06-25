<?php

namespace App\Libs;
use App\Libs\Repo\CrawlInit;
use App\Libs\Utils\Filter;
use App\Libs\Utils\UrlScheme;
use App\Models\Link;
use Sunra\PhpSimple\HtmlDomParser;

class GrabLinks extends CrawlInit
{

    private $links = [];

    private $imgExts = array("gif", "jpg", "jpeg", "png", "tiff", "tif", "JPG");

    public function fillLinks($return=false){
        $this->links = [];
        $dom = HtmlDomParser::str_get_html($this->crawlingPageStr);
        if($dom){
            foreach($dom->find('a') as $d){
                $url = UrlScheme::completeLink($this->crawlingUrl,$d->getAttribute('href'));
//            $url = $d->getAttribute('href');
//            $parseUrl = parse_url($url);
//            if(!isset($parseUrl['scheme'])){
//                $parseUri = parse_url($this->crawlingUrl);
//                $uriPath=isset($parseUri['path'])?$parseUri['path']:'';
//                $parseUrl['scheme']=$parseUri['scheme'];
//                $parseUrl['host']=$parseUri['host'];
//                $parseUrl['port']=$parseUri['port'];
//                $query = isset($parseUrl['query'])?'?'.$parseUrl['query']:'';
//                $fragment = isset($parseUrl['fragment'])?'#'.$parseUrl['fragment']:'';
//                $path = isset($parseUrl['path'])?'/'.$parseUrl['path']:'';
//                $path = str_replace('//', '/', $path);
//                if($path){
//                    $p = $path;
//                }else{
//                    $p = $uriPath.$path;
//                }
//                $url = $parseUrl['scheme'].'://'.$parseUrl['host'].':'.$parseUrl['port'].$p.$query.$fragment;
//            }

                if(Filter::pass($url, $this->project->skip_uri)){
                    $this->links[$url] = trim($d->innertext());
                }
            }
        }

        if($return) return $this;
    }

    function grabLinks($number) {

        if ($number < 1) {
            $this->command->info("-------process complete---------");
            return 0;
        } else {

            $notScraped = Link::where('scraped', 0)->where('type', 0)->where('project_id', $this->project->id)->get();

            foreach($notScraped as $link){
                $urlExt = pathinfo($link->uri, PATHINFO_EXTENSION);
                //if(is_array(getimagesize($link->uri))){
                if(in_array($urlExt, $this->imgExts)){
                    $this->command->info(" [$urlExt] Skip: Yes it's an image! ". $link->uri);
                }else{

                    try{
                        $this->command->info("$link->uri scraping...");
                        // $extra = [];
                        // if($this->project->auth)
                        //    $extra['cookies'] = $this->jar;
                        $one = round(microtime(true) * 1000);
                        $res = $this->guzzleClient->request('GET', $link->uri,
                            [
                            //    'cookies' => $this->jar
                            ]
                        );
                        $two = round(microtime(true) * 1000);
                        $this->crawlingPageStr = $res->getBody()->getContents();
                        $this->crawlingUrl = $link->uri;
                        $this->fillLinks();
                        foreach($this->links as $key=>$val){
                            $first = Link::where('uri', 'like', $key);
                            if(isset($this->project->skip_repeat['regex'])){
                                foreach($this->project->skip_repeat['regex'] as $regex){
                                    if(preg_match("/$regex/i", $key)){
                                        $first = Link::where('uri', 'regexp', "/$regex/i");
                                    }
                                }
                            }
                            $first = $first->count();
                            if(!$first){
                                $type = 1;
                                if(stristr($key, $this->project->host) || strpos($key,"/") == '0')$type = 0;
                                Link::create(['uri'=>$key, 'parent_link'=>$link->uri, 'title'=>$val, 'type'=>$type, 'scraped'=>0, 'level'=>2, 'iteration'=>0, 'project_id'=>$this->project->id]);
                            }
                        }
                        $link->scraped = 1;
                        $link->scraped_time = $two-$one;
                        $link->error = 0;
                        $link->save();
                        $this->command->info("$link->uri scraped!");
                    }catch(\Exception $e){
                        $link->scraped = 1;
                        $link->error = 1;
                        $link->error_message = $e->getMessage();
                        $link->save();
                        $this->command->info("$link->uri error scraping!");
                        $this->command->error($e->getMessage());
                    }
                }




            }
            $remaining = Link::where('scraped', 0)->where('type', 0)->count();
            $this->command->info("$remaining links are remaining.");
            return $this->grabLinks($remaining);
        }
    }
    public function createLevelOneLinks(){
        if(sizeof($this->links)){
            foreach ($this->links as $key=>$val) {
                (stristr($key, $this->project->host) || strpos($key,"/") == '0')?$type = 0:$type=1;
                $firstLink = Link::firstOrNew([
                    'uri'=>$key,
                    'type'=>$type,
                    'project_id'=>$this->project->id
                ]);
                $firstLink->title=$val;
                $firstLink->iteration+=1;
                $firstLink->scraped=0;
                $firstLink->level=1;
                $firstLink->save();
                $this->command->info("$key new link created for level 1.");
            }
            return $this;
        }else{
            $this->command->info("nothing to crowl on level 1.");
            return $this;
        }

    }



}