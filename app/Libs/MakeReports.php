<?php

namespace App\Libs;

use App\Libs\Repo\CrawlInit;
use App\Libs\Utils\Random;
use App\Libs\Utils\SetValues;
use App\Models\Form;
use App\Models\Link;
use App\Models\Report;
use App\Models\TestCase;
use App\Models\TestValues;

class MakeReports extends CrawlInit
{
    private $data = [];
    public function makeReports(){
        $links = Link::where('project_id', $this->project->id)->where('type', 0)->get();
        foreach($links as $l){

            $report = new Report();

            try{
                $res = $this->guzzleClient->request('GET', $l->uri, [
                    'form_params' => [],
                    'cookies' => $this->jar,
                    'headers' => []
                ]);

                $response = $res->getBody()->getContents();
                //jugad
//                $response = str_replace('"/assets/', '"http://www.lilyandlime.com/assets/', $response);
//                $response = str_replace('"/master-layout-assets/', '"http://www.lilyandlime.com/master-layout-assets/', $response);
//                $response = str_replace('"master-layout-assets/images/', '"http://www.lilyandlime.com/master-layout-assets/images/', $response);
                //jugad

                $report->project_id = $this->project->id;
                $report->uri = $l->uri;
                $report->type = $l->type;
                $report->content_type = $res->getHeader('content-type');
                $report->status_code = $res->getStatusCode();
                $report->response = $response;
                $report->save();
                $this->command->info("Reccord Saved...");
                //play
            }catch (\Exception $e){
                $report = new Report();
                $report->url = $l->uri;
                $report->type = $l->type;
                $report->project_id = $this->project->id;
                $report->status_code = $e->getCode();
                $report->response = $e->getMessage();
                $report->save();
                $this->command->error($e->getMessage());
            }

            $this->command->info("Links: $l");


        }
    }

}