<?php

namespace App\Console\Commands;

use App\Models\Link;
use App\Models\PageSpeed;
use App\Models\Project;
use Illuminate\Console\Command;
use GuzzleHttp\Client as GuzzleClient;
use Goutte\Client;
use PhpInsights;

class GetPageSpeed extends Command
{
    private $project = null;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ops:getpagespeed {offset} {limit} {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Grab page speed of url';

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

        if($this->option('force')){
        //    PageSpeed::truncate();
        }

        $offset = (int) $this->argument('offset');
        $limit = (int) $this->argument('limit');



        $links = Link::where('type', 0)
            //->where('error', 0)
            ->where('project_id', '5ac46d3d5260ed114e3c0f52')
            ->offset($offset)->limit($limit)
            ->get();
  //      echo $links->count();
//exit;



        foreach ($links as $link){

            $url = $link->uri;
            $this->info("$link->uri working...");

            $pageSpeedObj = PageSpeed::where('link_id', 'like', $link->id)->first();
            if($pageSpeedObj && $pageSpeedObj->data){
                $this->info("$link->uri already exist...");
            }else{

                $caller = new \PhpInsights\InsightsCaller('AIzaSyBMJCb2uLy_P5Wh2_WoWJfKQ0Fwezl2uno');
                $response = $caller->getResponse($url, \PhpInsights\InsightsCaller::STRATEGY_DESKTOP);
                $result = $response->getMappedResult();

                $savedData = PageSpeed::create([
                    'data'=>json_decode($response->getRawResult()),
                    'link_id'=>$link->id
                ]);

                $link->page_speed_score = $result->getSpeedScore();
                $link->page_speed_id = $savedData->id;
                $link->save();
                $score = $result->getSpeedScore();
                $this->info("$link->uri data saved. Score: $score");
                sleep(6);
                $this->info("Awake...");
            }

        }

        /** @var \PhpInsights\Result\InsightsResult $result */
//        foreach($result->getFormattedResults()->getRuleResults() as $rule => $ruleResult) {
//
//            /*
//             * If the rule impact is zero, it means that the website has passed the test.
//             */
//            if($ruleResult->getRuleImpact() > 0) {
//
//                var_dump($rule); // AvoidLandingPageRedirects
//                var_dump($ruleResult->getLocalizedRuleName()); // "Zielseiten-Weiterleitungen vermeiden"
//
//                /*
//                 * The getDetails() method is a wrapper to get the `summary` field as well as `Urlblocks` data. You
//                 * can use $ruleResult->getUrlBlocks() and $ruleResult->getSummary() instead.
//                 */
//                foreach($ruleResult->getDetails() as $block) {
//                    var_dump($block->toString()); // "Auf Ihrer Seite sind keine Weiterleitungen vorhanden"
//                }
//
//            }
//
//        }
        //var_dump($result->getSpeedScore()); // 100
     //   var_dump($result->getUsabilityScore()); // 100 echo "s";

        //        echo  $reports = PageSpeed::where('data', null)->get()->count();
//        foreach ($reports as $r){
//            $r->delete();
//            $this->info("$r->id deleted.");
//        }
//        exit;





//        foreach ($links as $link){
//
//                $this->info($link->pageSpeed->data['title']);
//            }




            //$j = json_encode($link->pageSpeed->data);

            //print_r($link->pageSpeed->data['title']);

            //$this->info("data saved...");


    }

    private function curl($url){
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
