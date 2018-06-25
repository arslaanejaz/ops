<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Form;
use App\Models\FormElements\Input;
use App\Models\FormElements\Select;
use App\Models\FormElements\Textarea;
use App\Models\Link;
use Sunra\PhpSimple\HtmlDomParser;

class GrabForms extends Command
{
    private $form = [];
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ops:getforms {url}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Grab Forms from url';

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
        //$u = 'http://phoenixcars.co.nz/parts_ordering_form.php';
        $html = HtmlDomParser::file_get_html($url, false, null, 0);
        $link = Link::where('uri', 'like', $url)->first();
        $this->info("Scraping from from: $url");
        foreach($html->find('form') as $f){
            $this->form = Form::firstOrNew(['name'=>$link->title, 'attr'=>$f->attr, 'status'=>1, 'project_id'=>$link->project_id]);
            $this->form->inputs = [];
            $this->form->textareas = [];
            $this->form->selects = [];
            $this->form->iterator += 1;
            $this->form->save();
            $this->grabElement($f, 'input');
            $this->grabElement($f, 'textarea');
            $this->grabElement($f, 'select');
        }
    }

    private function grabElement($f, $selector){
        if($selector == 'select'){
            foreach($f->find($selector) as $i){
                $options = [];
                foreach($i->find('option') as $o){
                    $options[]=$o->value;
                }
                $select = new Select(['name'=>$i->getAttribute('name'),'attr'=>$i->attr,
                    'options'=>$options, 'status'=>1]);
                $this->form->selects()->save($select);

            }
        }elseif($selector == 'textarea'){
            foreach($f->find($selector) as $i) {
                $input = new Textarea(['name'=>$i->getAttribute('name'),'attr'=>$i->attr, 'status'=>1]);
                $this->form->textareas()->save($input);
            }
        }else{
            foreach($f->find($selector) as $i) {
                $input = new Input(['name'=>$i->getAttribute('name'),'attr'=>$i->attr, 'status'=>1]);
                $this->form->inputs()->save($input);
            }
        }
        $this->info("Scraped: $selector");
    }
}
