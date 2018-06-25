<?php

namespace App\Libs\Repo;

use App\Models\Project;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

abstract class CrawlInit
{
    protected $project = null;
    protected $command;
    protected $guzzleClient = null;

    protected $jar = null;

    protected $crawlingPageStr = '';
    protected $crawlingUrl = '';

    public function __construct(Project $p, Command $c)
    {
        $this->project = $p;
        $this->command = $c;

        $this->guzzleClient = new Client([
            'timeout' => 60,
            'cookies' => true,
        ]);

        $this->jar = new \GuzzleHttp\Cookie\CookieJar();
    }

    public function login(){

        try{
            $login = $this->project->login;
            if(isset($login['link'])){
                $uri = $login['link'][0];
                $email = $login['email'][0];
                $password = $login['password'][0];
            }else{
                $this->command->error("Login Link Set.");
                exit;
            }
            $res = $this->guzzleClient->request('POST', $uri, [
                'form_params' => [
                    'email' => $email,
                    'password' => $password
                ],
                'cookies' => $this->jar,
                'headers' => ['referer'=>'/admin']
            ]);
            $this->crawlingPageStr = $res->getBody()->getContents();
            $this->crawlingUrl = $uri;
        }catch (\Exception $e){
            $this->command->error($e->getMessage());
        }
        return $this;
    }
    public function crawl(){
        try{
            $uri = $this->project->uri;
            //$uri = "http://laravel.bounce:8082";
            //$uri = "https://www.bounceinc.se";
            $this->command->info("$uri");
//            $one = round(microtime(true) * 1000);
            $res = $this->guzzleClient->request('GET', $uri);
//            $two = round(microtime(true) * 1000);
//            echo $two-$one;
//            exit;
            $this->crawlingPageStr = $res->getBody()->getContents();

            $this->crawlingUrl = $uri;
        }catch (\Exception $e){
            $this->command->error($e->getMessage());
        }
        return $this;
    }


}