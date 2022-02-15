<?php

namespace App\Console\Commands\Productdata;

use App\Models\Link;
use App\Models\PageSpeed;
use App\Models\Project;
use Illuminate\Console\Command;
use GuzzleHttp\Client as GuzzleClient;
use Goutte\Client;
use Illuminate\Support\Facades\DB;
use PhpInsights;

use function GuzzleHttp\json_encode;

class ProductdataMigrate extends Command
{
    private $project = null;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pd:migrate {offset} {limit} {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'migrate productdata';

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

        if ($this->option('force')) {
            //    PageSpeed::truncate();
        }

        $offset = (int) $this->argument('offset');
        $limit = (int) $this->argument('limit');

        $mywpdivisions = DB::connection('mysql')->select('select * from mywpdivisions');
        // print_r($mywpdivisions);

        foreach($mywpdivisions as $key=>$row){
            $this->info($row->name);
            DB::collection('divisions')->insert([
                'name' => $row->name,
                'created_at' => $row->created_at,
                'updated_at' => $row->updated_at
            ]);
        }

        $this->info('done ...');

    }

    private function curl($url)
    {
        $newUrl = "https://www.googleapis.com/pagespeedonline/v4/runPagespeed?url=$url&key=AIzaSyBMJCb2uLy_P5Wh2_WoWJfKQ0Fwezl2uno";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $newUrl);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);

        curl_close($ch);

        return $server_output;
        //        if ($server_output == "OK") {
        //            return ["data"=>$server_output, "status"=>1];
        //        } else {
        //            return ["data"=>$server_output, "status"=>0];
        //        }

    }
}
