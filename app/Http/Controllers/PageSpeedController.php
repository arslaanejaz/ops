<?php

namespace App\Http\Controllers;

use App\Libs\GooglePageSpeed;
use App\Models\Link;
use App\Models\PageSpeed;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Auth;

class PageSpeedController extends Controller
{
/**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($projectId)
    {

        if(isset($_GET['table'])){
            $links = Link::where('type', 0)->where('project_id', $projectId);
            $links = $links->offset(700);
            $links = $links->limit(100);
            $links = $links->get();

            return view('page-speed.index-table', compact('links'));
        }

        $perPage = config('view.page_limit');
        $links = Link::where('type', 0)->where('project_id', $projectId);
        $links = $links->paginate($perPage);
        $total = $links->total();

        return view('page-speed.index', compact('links', 'total', 'projectId'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($projectId,$id){
        if(isset($_GET['tttt'])){
            ini_set('memory_limit', '-1');
            $data = [];
            $links = Link::where('type', 0)
                ->offset(0)
                ->limit(5000)
                ->get()
            //    ->count()
            ;
            $i=1;
            foreach ($links as $link){

                if ($link->pageSpeed){
                    $s = $link->pageSpeed;

               // foreach ($pagespeed as $s){
                    if(
                        (!isset($s->data['error']))
                        &&
                        (isset($s->data['captchaResult'])
                            &&
                            ($s->data['captchaResult'] == 'CAPTCHA_NOT_NEEDED')))
                    {
//                        $score = $s->data['ruleGroups']['SPEED']['score'];
//                        if($score<70){
//                            $message = "Need to minimize Request and Response Bytes and Minimize Images Size.";
//                        }else{
//                            $message = "";
//                        }


                        $data[] = [






                            '#' => $i++,
                            'url' => $link->uri,
                            'Response Code' => $s->data['responseCode'],
                            'title' => $s->data['title'],
                            'Loading Experience' => isset($s->data['loadingExperience']['overall_category'])?$s->data['loadingExperience']['overall_category']:'',
                            'Score' => $s->data['ruleGroups']['SPEED']['score'],

                            'Resources' => $s->data['pageStats']['numberResources'],
                            'Js Resources' => $s->data['pageStats']['numberJsResources'],
                            'Css Resources' => $s->data['pageStats']['numberCssResources'],

                            'Image Response Bytes' => isset($s->data['pageStats']['imageResponseBytes'])?$s->data['pageStats']['imageResponseBytes']:0,
                            //'Html Response Bytes' => isset($s->data['pageStats']['htmlResponseBytes'])?$s->data['pageStats']['htmlResponseBytes']:0,
                            'Total Request Bytes' => $s->data['pageStats']['totalRequestBytes'],
                            'Over The Wire Response Bytes' => $s->data['pageStats']['overTheWireResponseBytes'],


//                        'numTotalRoundTrips' => $s->data['pageStats']['numTotalRoundTrips'],


                            //'AvoidLandingPageRedirects' => $s->data['formattedResults']['ruleResults']['AvoidLandingPageRedirects']['ruleImpact'],
                            'EnableGzipCompression (Impact)' => $s->data['formattedResults']['ruleResults']['EnableGzipCompression']['ruleImpact'],
                            //'localizedRuleName' => $s->data['formattedResults']['ruleResults']['localizedRuleName']['ruleImpact'],
                            'MainResourceServerResponseTime (Impact)' => $s->data['formattedResults']['ruleResults']['MainResourceServerResponseTime']['ruleImpact'],
                            'MinifyCss (Impact)' => $s->data['formattedResults']['ruleResults']['MinifyCss']['ruleImpact'],
                            'MinifyHTML (Impact)' => $s->data['formattedResults']['ruleResults']['MinifyHTML']['ruleImpact'],
                            'OptimizeImages (Impact)' => $s->data['formattedResults']['ruleResults']['OptimizeImages']['ruleImpact'],
                            'PrioritizeVisibleContent (Impact)' => $s->data['formattedResults']['ruleResults']['PrioritizeVisibleContent']['ruleImpact'],













//                            '#' => $i++,
//                            'page' => $link->uri,
//                            'Current Score' => $score,
//                            'What\'s Needed' => $message,
//                            'What\'s been done' => '',
//                            'New Score' => 'Not calculated',




                            //'Resources' => $s->data['pageStats']['numberResources'],
                            //'Js Resources' => $s->data['pageStats']['numberJsResources'],
                            //'Css Resources' => $s->data['pageStats']['numberCssResources'],
                            //'Image Response Bytes' => isset($s->data['pageStats']['imageResponseBytes'])?$s->data['pageStats']['imageResponseBytes']:0,
                            //'Html Response Bytes' => isset($s->data['pageStats']['htmlResponseBytes'])?$s->data['pageStats']['htmlResponseBytes']:0,
                            //'Total Request Bytes' => $s->data['pageStats']['totalRequestBytes'],

                            //'Over The Wire Response Bytes' => $s->data['pageStats']['overTheWireResponseBytes'],


//                        'numTotalRoundTrips' => $s->data['pageStats']['numTotalRoundTrips'],


                            //'AvoidLandingPageRedirects' => $s->data['formattedResults']['ruleResults']['AvoidLandingPageRedirects']['ruleImpact'],
//                            'EnableGzipCompression (Impact)' => $s->data['formattedResults']['ruleResults']['EnableGzipCompression']['ruleImpact'],
                            //'localizedRuleName' => $s->data['formattedResults']['ruleResults']['localizedRuleName']['ruleImpact'],
//                            'MainResourceServerResponseTime (Impact)' => $s->data['formattedResults']['ruleResults']['MainResourceServerResponseTime']['ruleImpact'],
//                            'MinifyCss (Impact)' => $s->data['formattedResults']['ruleResults']['MinifyCss']['ruleImpact'],
//                            'MinifyHTML (Impact)' => $s->data['formattedResults']['ruleResults']['MinifyHTML']['ruleImpact'],
//                            'OptimizeImages (Impact)' => $s->data['formattedResults']['ruleResults']['OptimizeImages']['ruleImpact'],
//                            'PrioritizeVisibleContent (Impact)' => $s->data['formattedResults']['ruleResults']['PrioritizeVisibleContent']['ruleImpact'],


                        ];
                    }


               // }

            }
            }

            //$pagespeed = PageSpeed::offset(0)->limit(100)->get();


            echo json_encode($data);
            exit;

        }elseif(isset($_GET['json'])){

        $link = Link::findOrFail($id);
            echo json_encode($link->pageSpeed->data);
            exit;
        }elseif(isset($_GET['generateAgain'])){

//            $result = json_decode(GooglePageSpeed::curl('https://www.susanstripling.com/'));
//
//            echo json_encode($result);
//            exit;
            $link = Link::findOrFail($id);
            $pageSpeed = $link->pageSpeed;

            $result = json_decode(GooglePageSpeed::curl($link->uri));
            if($pageSpeed){
                $pageSpeed->data = $result;
                $pageSpeed->save();
            }else{
                $savedData = PageSpeed::create([
                    'data'=>$result,
                    'link_id'=>$link->id
                ]);
                $link->page_speed_id = $savedData->id;

            }

            $link->page_speed_score = $result->ruleGroups->SPEED->score;
            $link->save();


            echo json_encode($result);
            exit;
        }


        $link = Link::findOrFail($id);

        return view('page-speed.show', compact('link', 'projectId'));
    }


}
