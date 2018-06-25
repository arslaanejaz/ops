<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Project;
use App\Models\TestCase;
use Illuminate\Http\Request;
use Session;

class TestCasesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index($projectId,Request $request)
    {
        $keyword = $request->get('search');
        $perPage = config('view.page_limit');
        $total = 0;

        if (!empty($keyword)) {
            $testcases = TestCase::where('name', 'LIKE', "%$keyword%")
				->orWhere('action', 'LIKE', "%$keyword%")
				->orWhere('method', 'LIKE', "%$keyword%")
				->orWhere('__method', 'LIKE', "%$keyword%")
				->orWhere('type', 'LIKE', "%$keyword%")
				->orWhere('obj', 'LIKE', "%$keyword%")
				->orWhere('options', 'LIKE', "%$keyword%")
                ->where('project_id', $projectId)
				->paginate($perPage);
            $total = $testcases->total();
        } else {
            $testcases = TestCase::where('project_id', $projectId)->paginate($perPage);
            $total = $testcases->total();
        }

        return view('test-cases.index', compact('testcases', 'total', 'projectId'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create($projectId)
    {
        return view('test-cases.create', compact('projectId'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store($projectId, Request $request)
    {
        
        $requestData = $request->all();
        $requestData['project_id'] = $projectId;

        $requestData["obj"] = json_decode($requestData["obj"]);
        if($requestData['type']==4){
            $this->duskClass($requestData, $projectId);
        }
        TestCase::create($requestData);

        Session::flash('flash_message', 'TestCase added!');

        return redirect('projects/'.$projectId.'/test-cases');
    }

    private function duskClass($requestData, $projectId, $id=null){
        //dusk
//        echo '<pre>';
        $testcase = TestCase::findOrFail($id);
//        print_r($testcase->project);
//        exit;
        $name = $requestData["name"];
        $name = str_replace(' ', '', $name).'Test';

        $project = $testcase->project;

        try{
            $file = '../tests/Browser/'.$name.'.php';
            $myfile = fopen($file, 'w') or die('Unable to open file!');
            $txt = '<?php '."\n\n".'namespace Tests\Browser;'."\n\n";
            $txt .= 'use Tests\DuskTestCase;'."\n";
            $txt .= 'use Laravel\Dusk\Chrome;'."\n";
            $txt .= 'use Illuminate\Foundation\Testing\DatabaseMigrations;'."\n\n";
            $txt .= 'class '.$name.' extends DuskTestCase'."\n";
            $txt .= '{'."\n";
            $txt .= '   public function testBasicExample()'."\n";
            $txt .= '   {'."\n";
            $txt .= '   $this->browse(function ($browser) {'."\n";

            $login = $project->login;
            if(isset($login['link'])){
                $uri = $login['link'][0];
                $email = $login['email'][0];
                $password = $login['password'][0];
                $txt .= '   $browser->visit("'.$uri.'")'."\n";
                $txt .= '   ->type(\'email\', "'.$email.'")'."\n";
                $txt .= '   ->type(\'password\', "'.$password.'")'."\n";
                $txt .= '   ->press(\'Login\')'."\n";
            }else{
                $txt .= '   $browser->visit("'.$testcase->form->link->uri.'")'."\n";
            }

            foreach($requestData['obj'] as $key=>$d){
                if($key=='type'){
                    $txt .= '   ->'.$key.'('.
                        str_replace(':', ',', str_replace(['{','}'], '', json_encode($d)))
                        .')'."\n";
                }elseif($key=='press'){
                    $txt .= '   ->'.$key.'("'.
                        $d
                        .'")'."\n";
                }else{
                    if(is_string($d)){
                        $txt .= '     ->type("'.$key.'", "'.$d.'")'."\n";
                    }

                }

            }
            $txt .= '   ;'."\n";
            $txt .= '   });'."\n";
            $txt .= '   }'."\n";
            $txt .= '}'."\n";
            fwrite($myfile, $txt);
            fclose($myfile);
            chmod($file, 0777);
        }catch (\Exception $e){
            echo 'error';
            print_r($e->getMessage());
            exit;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($projectId, $id)
    {
        $testcase = TestCase::findOrFail($id);

        return view('test-cases.show', compact('testcase', 'projectId'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($projectId, $id)
    {
        $testcase = TestCase::findOrFail($id);
        $testcase->obj = json_encode($testcase->obj);

        return view('test-cases.edit', compact('testcase', 'projectId'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($projectId, $id, Request $request)
    {

        $requestData = $request->all();
        $requestData["obj"] = json_decode($requestData["obj"]);
        if($requestData['type']==4){
            $this->duskClass($requestData, $projectId, $id);
        }
        
        $testcase = TestCase::findOrFail($id);
        $testcase->update($requestData);


        Session::flash('flash_message', 'TestCase updated!');

        return redirect('projects/'.$projectId.'/test-cases');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($projectId, $id)
    {
        TestCase::destroy($id);

        Session::flash('flash_message', 'TestCase deleted!');

        return redirect('projects/'.$projectId.'/test-cases');
    }
}
