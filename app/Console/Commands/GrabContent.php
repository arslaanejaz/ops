<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Form;
use App\Models\FormElements\Input;
use App\Models\FormElements\Select;
use App\Models\FormElements\Textarea;
use App\Models\Link;
use Illuminate\Support\Facades\DB;
use Sunra\PhpSimple\HtmlDomParser;

class GrabContent extends Command
{
    private $form = [];
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ops:getcontent {url}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Grab content from url';

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
        echo $url = $this->argument('url');
        //$u = 'http://phoenixcars.co.nz/parts_ordering_form.php';
        $html = HtmlDomParser::file_get_html($url, false, null, 0);
        $this->info("Scraping content from: $url");
        foreach($html->find('div.home-wrap') as $content){
            //echo $content->plaintext;
            $d = DB::connection('another_connection')->collection('posts')->insert(
                [
                    'title' => 'bounce-app',
                    'slug' => 'bounce-app',
                    'language' => 'sv',
                    'content'=>trim($content->innertext),
                    'meta-tags' => []
                ]
            );
            print_r($d);
        }
    }
}
