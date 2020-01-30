<?php

namespace App\Console\Commands;

use App\Libs\GrabForms;
use App\Libs\GrabLinks;
use App\Libs\MakeReports;
use App\Libs\MakeTestCases;
use App\Libs\MakeUnitTest;
use App\Libs\RunTest;
use App\Models\Doc;
use App\Models\Form;
use App\Models\Link;
use App\Models\Project;
use App\Models\Report;
use App\Models\TestCase;
use Illuminate\Console\Command;
use GuzzleHttp\Client as GuzzleClient;
use Goutte\Client;

class Test extends Command
{
    private $project = null;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ops:test {--action=} {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test test';

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
        $action = $this->option('action');
        $project = Project::where('testing', 'like', '1')->first();
        // print_r($this->option('force'));
        // exit;
        if (!$project) {
            $this->info("No Project Set For Testing.");
            exit(0);
        }
        $this->info("$project->name selected for testing.");
        if ($action == 'clear') {
            if ($this->option('force')) {
                Link::where('project_id', $project->id)->delete();
                $this->info("Clearing old urls...");
                Form::where('project_id', $project->id)->delete();
                $this->info("Clearing old Forms...");
                TestCase::where('project_id', $project->id)->where('type', 3)->delete();
                $this->info("Clearing old TestCases...");
                Doc::where('project_id', $project->id)->delete();
                $this->info("Clearing old Docs...");
                Report::where('project_id', $project->id)->delete();
                $this->info("Clearing old Reports...");
            }
        } elseif ($action == 'urls') {

            //echo $urlExt = pathinfo('https://www.georgestreetphoto.com/images/uploads/portfolio-images/weddings/2017_Wedding_Portfolio_Update/01-GSPV_WeddingPortfolio.jpg', PATHINFO_EXTENSION);
            //exit;

            if ($this->option('force')) {
                Link::where('project_id', $project->id)->delete();
                $this->info("Clearing old urls...");
            }
            $grabLinks = new GrabLinks($project, $this);
            if ($project->login) {
                $grabLinks = $grabLinks->login();
            } else {
                $grabLinks = $grabLinks->crawl();
            }
            $grabLinks->fillLinks(true)
                ->createLevelOneLinks()
                ->grabLinks(1);
        } elseif ($action == 'forms') {
            if ($this->option('force')) {
                Form::where('project_id', $project->id)->delete();
                $this->info("Clearing old Forms...");
            }
            $grabForms = new GrabForms($project, $this);
            if ($project->login) {
                $grabForms = $grabForms->login();
            }
            $grabForms->createForms();
        } elseif ($action == 'testcases') {
            if ($this->option('force')) {
                TestCase::where('project_id', $project->id)->where('type', 3)->delete();
                $this->info("Clearing old TestCases...");
            }

            $mtc = new MakeTestCases($project, $this);
            if ($project->login) {
                $mtc = $mtc->login();
            }
            $mtc->makeTestCases();
        } elseif ($action == 'docs') {
            if ($this->option('force')) {
                Doc::where('project_id', $project->id)->delete();
                $this->info("Clearing old Docs...");
            }
            $test = new RunTest($project, $this);
            $test
                //                ->login()
                ->defaultTestRun();
        } elseif ($action == 'unittest') {
            if ($this->option('force')) {
                TestCase::where('project_id', $project->id)->where('type', 5)->delete();
                $this->info("Clearing old UnitTest...");
            }
            $unitTest = new MakeUnitTest($project, $this);
            $unitTest->makeUnitTest();
        } elseif ($action == 'report') {
            if ($this->option('force')) {
                Report::where('project_id', $project->id)->delete();
                $this->info("Clearing old Reports...");
            }
            $unitTest = new MakeReports($project, $this);
            $unitTest->makeReports();
        } else {
            $this->info("No Option Selected.");
        }
    }
}
