<?php

namespace App\Console\Commands;

use App\Models\Link;
use App\Models\Project;
use Illuminate\Console\Command;
use GuzzleHttp\Client as GuzzleClient;
use Goutte\Client;

class GetUrls extends Command
{
    private $project = null;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ops:geturls {url}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Grab urls of site';

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
        $parse = parse_url($url);
        if (isset($parse['host']) && $parse['host'] != '') {
            $this->goutteClient = new Client();
            $this->guzzleClient = new GuzzleClient(array(
                'timeout' => 60,
                'cookies' => true,
            ));
            $this->goutteClient->setClient($this->guzzleClient);
            $this->project = Project::where('uri', 'like', $url)->first();
            if ($this->project) {
                $this->createFirstLink();
            } else {
                $this->project = Project::create(
                    [
                        'name' => $parse['host'], 'uri' => $url, 'host' => $parse['host'],
                        'description' => 'This project created by batch job.', 'category' => 0
                    ]
                );
                $this->createFirstLink();
            }
            $this->grabLinks(1);
        } else {
            $this->error('Url is not correct.');
        }
    }

    function grabLinks($number)
    {

        if ($number < 1) {
            $this->info("-------process complete---------");
            return 0;
        } else {

            $notScraped = Link::where('scraped', 0)->where('type', 0)->where('project_id', $this->project->id)->get();

            foreach ($notScraped as $link) {
                $this->info("$link->uri scraping...");
                $links = $this->goutteClient->request('GET', $link->uri)->filter('a')->links();
                $unquelinks = [];
                foreach ($links as $ll) {
                    $unquelinks[$ll->getUri()] = $ll->getNode()->textContent;
                }
                foreach ($unquelinks as $key => $val) {
                    $first = Link::where('uri', 'like', $key)->first();
                    if (!$first) {
                        $type = 1;
                        if (stristr($key, $this->project->host) || strpos($key, "/") == '0') $type = 0;
                        $this->createLink($key, $val, 0, $type);
                    }
                }
                $link->scraped = 1;
                $link->save();
                $this->info("$link->uri scraped!");
            }
            $remaining = Link::where('scraped', 0)->where('type', 0)->count();
            $this->info("$remaining links are remaining.");
            return $this->grabLinks($remaining);
        }
    }

    private function createFirstLink()
    {
        $firstLink = Link::where('uri', 'like', $this->project->uri)
            ->where('project_id', $this->project->id)->first();
        if (!$firstLink) {
            $firstLink = $this->createLink($this->project->uri, 'First Link', 0, 0);
            $this->info("$firstLink->uri new link created.");
        }
    }

    private function createLink($uri, $title, $scraped, $type)
    {
        return Link::create([
            'uri' => $uri,
            'title' => $title, 'scraped' => $scraped, 'type' => $type,
            'project_id' => $this->project->id
        ]);
    }
}
