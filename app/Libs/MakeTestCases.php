<?php

namespace App\Libs;

use App\Libs\Repo\CrawlInit;
use App\Libs\Utils\Random;
use App\Libs\Utils\SetValues;
use App\Models\Form;
use App\Models\TestCase;
use App\Models\TestValues;

class MakeTestCases extends CrawlInit
{
    private $data = [];
    public function makeTestCases(){
        $forms = Form::where('project_id', $this->project->id)->get();
        foreach($forms as $f){
            $testCase = new TestCase();
            $testCase->name = $f->name;
            $testCase->form_id = $f->id;
            $testCase->project_id = $f->project_id;
            $testCase->action = $f->attr['action'];
            $testCase->method = $f->attr['method'];
            $testCase->__method = $f->attr['_method'];
            $setValues = new SetValues();
            $data = array_merge(
                $setValues->register($f->inputs,'inputs',$testCase->__method)
                , $setValues->register($f->textareas,'textareas',$testCase->__method));
            $data = array_merge($data,
                $setValues->register($f->selects,'selects',$testCase->__method)
                );
            $testCase->obj = $data;
            $testCase->type = 3;
            $testCase->save();
            $this->command->info("Test Case Saved...");

        }
    }

}