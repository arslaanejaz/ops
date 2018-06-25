<?php
namespace App\Http\Controllers;

use App\Libs\Utils\UrlScheme;
use App\Models\Form;
use App\Models\FormElements\Input;
use App\Models\FormElements\Select;
use App\Models\FormElements\Textarea;
use App\Models\Link;
use App\Models\Project;
use Illuminate\Http\Request;
use Goutte\Client;
use Sunra\PhpSimple\HtmlDomParser;
use App\Http\Requests;
use GuzzleHttp\Client as GuzzleClient;
class WebScraperController extends Controller
{
    private $form = [];
    public function index()
    {
        echo '<pre>';
        $p = Project::pluck('_id', 'name')->all();
        print_r($p);
        exit;
        $p = 'http://phoenixcars.co.nz';
        $u = 'action.php';
            echo UrlScheme::completeLink($p,$u);
        exit;
        echo '<pre>';
        $pl = 'http://phoenixcars.co.nz';
        $href = 'wook_your_wof.php';
        echo UrlScheme::completeLink($pl,$href);
        exit;

        $project = Project::first();
        print_r($project->skip_uri['query']);
        exit;
        echo $regex = $project->skip_uri['regex'];
        echo "\n";
        echo $regex = ($project->skip_uri['regex']);
        echo "\n";
        echo preg_match("/$regex/i", 'http://laravel.appapi:8082/admin/clubquery/delete_club/565d8f2a90497eb6be081bbd');
        exit;

        $client = new GuzzleClient([
                'timeout' => 60, 'cookies' => true,
            ]);
        $goutClient = new Client();
        $goutClient->setClient($client);
        $jar = new \GuzzleHttp\Cookie\CookieJar();
        try{
        $cr = $goutClient->request('GET', 'http://laravel.appapi:8082/admin/login', [
//            'form_params' =>
//            [
//                        'email' => 'arslaan.e@dplit.com',
//                'password' => 'Super123!admin'
//            ],
            'cookies' => $jar,
        //    'headers' => ['referer'=>'/admin']
        ]);
           $form = $cr->selectButton('Login')->link();
            //echo $form->

//            $form->addPostFields([
//                'email' => 'arslaan.e@dplit.com',
//                'password' => 'Super123!admin'
//            ]);
//            $g = $goutClient->request('POST', 'http://laravel.appapi:8082/admin/login');
        //$form = $res->form();


//        try{
//            $res = $client->request('POST', 'http://laravel.appapi:8082/admin/login', [
//                'form_params' => [
//                    'email' => 'arslaan.e@dplit.com',
//                    'password' => 'Super123!admin'
//                ],
//                'cookies' => $jar,
//                'headers' => ['referer'=>'/admin']
//            ]);
//            $str = $res->getBody()->getContents();
//            $dom = HtmlDomParser::str_get_html($str);
//            foreach($dom->find('a') as $d){
//                echo $d->getAttribute('href');
//                echo '<br />';
//            }



        }catch (\Exception $e){
            echo 'error';
            echo $e->getMessage();
        }


    }



}