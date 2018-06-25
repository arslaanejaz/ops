<?php

namespace App\Libs;

use App\Libs\Repo\CrawlInit;
use App\Libs\Utils\Random;
use App\Models\Doc;
use App\Models\Form;
use App\Models\TestCase;
use App\Models\TestValues;

class RunTest extends CrawlInit
{
    private $form_params = [];
    private $referer;
    public function defaultTestRun(){

        $tests = TestCase::where('project_id', $this->project->id)->get();
        foreach($tests as $t){
            $p_url = parse_url($t->action);
            $this->referer = $p_url['path'];
//            foreach($t->obj as $key=>$val){
//                if($key == '_token'){
//                    $this->form_params['_token'] = $val;
//                }else{
//                    $this->form_params[$key] = $val;
//                }
//            }

            $method = $t->__method?$t->__method:$t->method;
            if($method=='GET'){
                $action = $t->action.'?'.http_build_query($t->obj);
                $this->form_params = [];
            }else{
               $action = $t->action;
                $this->form_params = $t->obj;
            }

            try{
                $res = $this->guzzleClient->request($method, $action, [
                    'form_params' => $this->form_params,
                    'cookies' => $this->jar,
                    'headers' => ['referer'=>$this->referer]
                ]);

                $doc = new Doc();
                $doc->url = $action;
                $doc->content_type = $res->getHeader('content-type');
                $doc->status_code = $res->getStatusCode();
                $doc->request = $this->form_params;
                $doc->method = $method;
                $doc->response = $res->getBody()->getContents();
                $doc->project_id = $this->project->id;
                $doc->save();
                $this->command->info("Reccord Saved...");
                //play
            }catch (\Exception $e){
                $doc = new Doc();
                $doc->url = $action;
                $doc->status_code = $e->getCode();
                $doc->request = $this->form_params;
                $doc->method = $method;
                $doc->response = $e->getMessage();
                $doc->project_id = $this->project->id;
                $doc->save();
                $this->command->error($e->getMessage());
            }
//                        echo '<pre>';
//print_r($this->form_params);
//            exit;
        }


    }

}