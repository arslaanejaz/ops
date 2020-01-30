<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Project;
use Illuminate\Http\Request;
use Session;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = config('view.page_limit');
        $total = 0;

        if (!empty($keyword)) {
            $projects = Project::where('name', 'LIKE', "%$keyword%")
                ->orWhere('uri', 'LIKE', "%$keyword%")
                ->orWhere('login', 'LIKE', "%$keyword%")
                ->orWhere('host', 'LIKE', "%$keyword%")
                ->orWhere('skip_uri', 'LIKE', "%$keyword%")
                ->orWhere('skip_repeat', 'LIKE', "%$keyword%")
                ->orWhere('skip_repeat_form', 'LIKE', "%$keyword%")
                ->orWhere('x_headers', 'LIKE', "%$keyword%")
                ->orWhere('testing', 'LIKE', "%$keyword%")
                ->paginate($perPage);
            $total = $projects->total();
        } else {
            $projects = Project::paginate($perPage);
            $total = $projects->total();
        }

        return view('projects.index', compact('projects', 'total'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:20',
            'uri' => 'required',
            'host' => 'required'
        ]);
        $requestData = $request->all();

        Project::create($requestData);

        Session::flash('flash_message', 'Project added!');

        return redirect('projects');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $projectId = $id;
        $project = Project::findOrFail($id);

        return view('projects.show', compact('project', 'projectId'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $projectId = $id;
        $project = Project::findOrFail($id);

        return view('projects.edit', compact('project', 'projectId'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:20',
            'uri' => 'required',
            'host' => 'required'
        ]);
        $requestData = $request->all();

        if (!isset($requestData['login'])) $requestData['login'] = [];
        if (!isset($requestData['skip_uri'])) $requestData['skip_uri'] = [];
        if (!isset($requestData['skip_repeat'])) $requestData['skip_repeat'] = [];
        if (!isset($requestData['skip_repeat_form'])) $requestData['skip_repeat_form'] = [];
        if (!isset($requestData['x_headers'])) $requestData['x_headers'] = [];

        $project = Project::findOrFail($id);
        $project->update($requestData);

        Session::flash('flash_message', 'Project updated!');

        return redirect('projects');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        exit("Not Allowed");
        Project::destroy($id);

        Session::flash('flash_message', 'Project deleted!');

        return redirect('projects');
    }
}
