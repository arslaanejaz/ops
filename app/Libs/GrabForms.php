<?php

namespace App\Libs;
use App\Libs\Repo\CrawlInit;
use App\Libs\Utils\UrlScheme;
use App\Models\Form;
use App\Models\FormElements\Input;
use App\Models\FormElements\Select;
use App\Models\FormElements\Textarea;
use App\Models\Link;
use Sunra\PhpSimple\HtmlDomParser;

class GrabForms extends CrawlInit
{
    private $form;

    public function createForms(){
//$form = Form::first();
//        $i = $form->inputs()->where('name', 'like', 'name2')->first();
//        if($i){
//            echo $i->id;
//        }else{
//            echo 'rola';
//        }
//
//        exit;
        $links = Link::where('project_id',$this->project->id)->where('type', 0)->get();
        foreach($links as $link){
            try{
            $res = $this->guzzleClient->request('GET', $link->uri, [
                'cookies' => $this->jar
            ]);
            $str = $res->getBody()->getContents();
            $html = HtmlDomParser::str_get_html($str);
            $this->command->info("Scraping FORM from: $link->uri");
            foreach($html->find('form') as $f){
                $action = (isset($f->attr['action']) && $f->attr['action']!='')?$f->attr['action']:'';
                $attr = [
                    'method'=>(isset($f->attr['method']) && $f->attr['method']!='')?strtoupper($f->attr['method']):'GET',
                    '_method'=>$this->getMethodType($f),
                    'action'=>UrlScheme::rel2abs($link->uri, $action),//(isset($f->attr['action']) && $f->attr['action']!='')?$f->attr['action']:$link->uri,
                    'enctype'=>(isset($f->attr['enctype']) && $f->attr['enctype']!='')?$f->attr['enctype']:'',
                    'name'=>(isset($f->attr['name']) && $f->attr['name']!='')?$f->attr['name']:'',
                    'id'=>(isset($f->attr['id']) && $f->attr['id']!='')?$f->attr['id']:'',
                    'class'=>(isset($f->attr['class']) && $f->attr['class']!='')?$f->attr['class']:'',
                ];

                //echo $attr['action'];
                //echo "\n";
                //continue;
                $form = Form::where('attr.method', $attr['method']);
                $regexCheck = '';
                if(isset($this->project->skip_repeat_form['regex'])){
                    foreach($this->project->skip_repeat_form['regex'] as $regex){
                        if(preg_match("/$regex/i", $attr['action'])){
                            $form = $form->where('attr.action', 'regexp', "/$regex/i");
                            $regexCheck = $regex;
                        }
                    }
                }
                if(!$regexCheck)$form = $form->where('attr.action', 'like', $attr['action']);

                $form = $form->where('attr._method', $attr['_method'])
                    ->where('attr.name', $attr['name'])
                    ->where('attr.id', $attr['id'])
                    ->where('project_id', $this->project->id)
                    ->first();

                if($form){
                    //continue;
                    //if($regexCheck) continue;
                    $this->form = $form;
                    $this->form->iterator += 1;
                    $this->form->save();
                }else{
                    $this->form = Form::create([
                        'name'=>strip_tags($link->title),
                        'attr'=>$attr,
                        'status'=>1,
                        'project_id'=>$this->project->id,
                        'link_id'=>$link->id,
                        'iterator'=>0
                    ]);
                }
                $this->grabElement($f, 'input');
                $this->grabElement($f, 'textarea');
                $this->grabElement($f, 'select');
            }
            $this->cleanSync();
            }catch (\Exception $e){
                //$this->command->info("$link->uri error scraping!");
                $this->command->error($e->getMessage());
            }
        }
    }

    private function grabElement($f, $selector){
        if($selector == 'select'){
            foreach($f->find($selector) as $i){
                $options = [];
                foreach($i->find('option') as $o){
                    $options[]=$o->value;
                }

                $select = $this->form->selects()->where('attr.name', 'like', $i->getAttribute('name'))->first();
                if($select){
                    $select->status=1;
                    $select->attr=$i->attr;
                    $select->iterator=$this->form->iterator;
                    $select->options = $options;
                    $select->save();
                }else{
                    $select = new Input();
                    //$select->name=$i->getAttribute('name');
                    $select->attr=$i->attr;
                    $select->status=1;
                    $select->iterator=$this->form->iterator;
                    $select->options = $options;
                    $this->form->selects()->save($select);
                }

            }
        }elseif($selector == 'textarea'){
            foreach($f->find($selector) as $i) {
                $input = $this->form->textareas()->where('attr.name', 'like', $i->getAttribute('name'))->first();
                if($input){
                    $input->attr=$i->attr;
                    $input->value=$i->innertext;
                    $input->status=1;
                    $input->iterator=$this->form->iterator;
                    $input->save();
                }else{
                    $input = new Input();
                    //$input->name=$i->getAttribute('name');
                    $input->attr=$i->attr;
                    $input->value=$i->innertext;
                    $input->status=1;
                    $input->iterator=$this->form->iterator;
                    $this->form->textareas()->save($input);
                }
            }
        }else{
            foreach($f->find($selector) as $i) {
                $input = $this->form->inputs()->where('attr.name', 'like', $i->getAttribute('name'))->first();
                if($input){
                    //$input->value=$i->getAttribute('value');
                    $input->attr=$i->attr;
                    $input->status=1;
                    $input->iterator=$this->form->iterator;
                    $input->save();
                }else{
                    $input = new Input();
                    $input->attr=$i->attr;
                    //$input->name=$i->getAttribute('name');
                    //$input->type=$i->getAttribute('type');
                    //$input->value=$i->getAttribute('value');
                    $input->status=1;
                    $input->iterator=$this->form->iterator;
                    $this->form->inputs()->save($input);
                }
            }
        }
        $this->command->info("Scraped: $selector");
    }

    private function getMethodType($f){
        $value = '';
        foreach($f->find('input') as $i) {
            if($i->getAttribute('name')=='_method'){
                $value = $i->getAttribute('value');
            }
        }
        return $value;
    }

    private function cleanSync(){
        if(!$this->form) return;
        foreach($this->form->inputs as $i){
            if($i->iterator != $this->form->iterator){
                $i->status = 0;
                $i->save();
            }
        }
        foreach($this->form->textareas as $i){
            if($i->iterator != $this->form->iterator){
                $i->status = 0;
                $i->save();
            }
        }
        foreach($this->form->selects as $i){
            if($i->iterator != $this->form->iterator){
                $i->status = 0;
                $i->save();
            }
        }
    }
}