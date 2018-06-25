<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Form;
use Illuminate\Http\Request;
use Session;

class FormsController extends Controller
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
            $forms = Form::where('name', 'LIKE', "%$keyword%")
				->orWhere('naaatrme', 'LIKE', "%$keyword%")
				->orWhere('status', 'LIKE', "%$keyword%")
                ->where('project_id', $projectId)
				->paginate($perPage);
            $total = $forms->total();
        } else {
            $forms = Form::where('project_id', $projectId)->paginate($perPage);
            $total = $forms->total();
        }

        return view('forms.index', compact('forms', 'total', 'projectId'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create($projectId)
    {
        return view('forms.create', compact('projectId'));
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
        $this->validate($request, [
			'name' => 'required',
			//'title' => 'required',
			//'type' => 'required'
		]);
        $requestData = $request->all();
        $requestData['project_id'] = $projectId;
        
        Form::create($requestData);

        Session::flash('flash_message', 'Form added!');

        return redirect('projects/'.$projectId.'/forms');
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
        $form = Form::findOrFail($id);

        return view('forms.show', compact('form', 'projectId'));
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
        $form = Form::findOrFail($id);

        return view('forms.edit', compact('form', 'projectId'));
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
        $this->validate($request, [
			'uri' => 'required',
			'title' => 'required',
			'type' => 'required'
		]);
        $requestData = $request->all();
        
        $form = Form::findOrFail($id);
        $form->update($requestData);

        Session::flash('flash_message', 'Form updated!');

        return redirect('projects/'.$projectId.'/forms');
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
        Form::destroy($id);

        Session::flash('flash_message', 'Form deleted!');

        return redirect('projects/'.$projectId.'/forms');
    }
}
