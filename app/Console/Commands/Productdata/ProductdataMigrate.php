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

        // $this->table_to_collection('mywpdivisions', 'divisions');
        // $this->table_to_collection('mywpastm', 'astms');
        // $this->table_to_collection('mywpcertifications', 'certifications');
        // $this->table_to_collection('mywpusers', 'users');
        // $this->table_to_collection('projects', 'projects');
        // $this->table_to_collection('products', 'products');
        // $this->table_to_collection('mywpprojectcategory', 'product_project_division');
        // $this->table_to_collection('product_divisions', 'product_divisions');
        $this->table_to_collection('file_products', 'product_files');

        // $this->manufacturers();

        $this->info('done ...');
    }


    private function manufacturers()
    {
        $users = DB::connection('mysql')->select("select * from mywpusers where id = 15546");
        foreach ($users as $user) {
            $this->info($user->id);
            DB::collection('users')->insert((array) $user);
        }
        $this->info('$user done ...');
    }

    private function table_to_collection($table, $collection)
    {
        $all = DB::connection('mysql')->select("select * from $table");

        foreach ($all as $key => $row) {
            $this->info($row->id);
            DB::collection($collection)->insert((array) $row);
        }
        $this->info("$table done ...");
    }
}
