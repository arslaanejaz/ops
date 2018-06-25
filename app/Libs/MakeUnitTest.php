<?php

namespace App\Libs;

use App\Libs\Repo\CrawlInit;
use App\Libs\Utils\Random;
use App\Libs\Utils\SetValues;
use App\Models\Form;
use App\Models\TestCase;
use App\Models\TestValues;
use File;

class MakeUnitTest extends CrawlInit
{
    private $form_params = [];
    private $referer;
    public function makeUnitTest(){

        $tests = TestCase::where('project_id', $this->project->id)->get();
        foreach($tests as $t){
            $stubDir = __DIR__ . '/stubs/php/laravel/';
            $filename = $stubDir . 'unit.test.5.0.stub';
            $projectTestDir = 'H:\xampp\htdocs\sw\swbackend\tests\OpsGenerated\\';


            $p_url = parse_url($t->action);
            $this->referer = $p_url['path'];
            $method = $t->__method?$t->__method:$t->method;
            $name = str_replace(' ', '', $t->name).'Test';
            if (!File::isDirectory($projectTestDir)) {
                File::makeDirectory($projectTestDir, 0755, true);
            }
            $newLangFile = $projectTestDir . $name . '.php';
            if (!File::copy($filename, $newLangFile)) {
                echo "failed to copy $filename...\n";
            } else {
                File::put($newLangFile,
                    str_replace(
                        ['%%name%%','%%email%%', '%%method%%', '%%action%%', '%%data%%', '%%assert%%'],
                        [$name, $this->project->login['email'][0],
                            $method,
                            $t->action, $this->arrayParse($t->obj),
                            $this->assertParse($method, $t->action)
                        ],
                        File::get($newLangFile)
                    )
                );
            }
            $this->command->info("Unit Test file $name generated!");

        }
    }

    private function arrayParse($dizi){
        $dizin="[\n";
        foreach($dizi as $key=>$val){
            if($key=='_token')
            $dizin.="          '".$key."' => csrf_token(),"."\r\n";
                elseif($key=='_method') ;
            else
                $dizin.="          '".$key."' => '".$val."',"."\r\n";
        }
        $dizin.="          ]";

        return $dizin;
    }

    private function assertParse($method, $action){
        if($method=='POST'){
            return "\$this->assertRedirectedTo('".$action."');";
        }elseif($method=='PATCH'){
            return "\$this->assertRedirectedTo('".$action."/edit');";
        }else{
            return "\$this->assertContains('Search', \$response);";
        }
    }

}