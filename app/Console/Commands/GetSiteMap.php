<?php

namespace App\Console\Commands;

use App\Libs\Repo\CrawlInit;
use App\Models\Link;
use App\Models\Project;
use Illuminate\Console\Command;
use GuzzleHttp\Client as GuzzleClient;
use Goutte\Client;

class GetSiteMap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ops:getsitemap {url}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Grab urls of site from sitemap';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $url = $this->argument('url');

        $this->goutteClient = new Client();
        $this->guzzleClient = new GuzzleClient(array(
            'timeout' => 60,
            'cookies' => true,
        ));
        $this->goutteClient->setClient($this->guzzleClient);

        $uuu = [];

        $links = $this->goutteClient->request('GET', $url)
            ->filter('url loc');
        foreach ($links as $link){
            //print_r($link->textContent);
            $l = $link->textContent;
            if (strpos($l, 'blog') !== false) {

                $first = Link::where('uri', 'like', $l);
                //filtering not added here.
                $first = $first->count();
                if(!$first){
                    $this->info("saving $l");
                    $this->createLink($l);
                }else{
                    $this->info("skiping $l");
                }

            }

            //exit;
        }

    }



    
    private function createLink($uri){
        return Link::create([
            'uri'=>$uri,
            'title'=>'', 'scraped'=>1, 'type'=>0,
            'project_id'=>'5b17b19f5260ed13da52d742'
        ]);
    }
}
