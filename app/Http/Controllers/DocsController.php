<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Doc;
use Illuminate\Http\Request;
use Session;

class DocsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index($projectId, Request $request)
    {
        $keyword = $request->get('search');
        $perPage = config('view.page_limit');
        $total = 0;

        if (!empty($keyword)) {
            $docs = Doc::where('url', 'LIKE', "%$keyword%")
				->orWhere('request', 'LIKE', "%$keyword%")
				->orWhere('method', 'LIKE', "%$keyword%")
				->orWhere('response', 'LIKE', "%$keyword%")
                ->where('project_id', $projectId)
				->paginate($perPage);
            $total = $docs->total();
        } else {
            $docs = Doc::paginate($perPage);//where('project_id', $projectId)->
            $total = $docs->total();
        }

        return view('docs.index', compact('docs', 'total', 'projectId'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create($projectId)
    {
        return view('docs.create', compact('projectId'));
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
        
        Doc::create($requestData);

        Session::flash('flash_message', 'Doc added!');

        return redirect('projects/'.$projectId.'/docs');
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
        $doc = Doc::findOrFail($id);

        return view('docs.show', compact('doc', 'projectId'));
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
        $doc = Doc::findOrFail($id);

        return view('docs.edit', compact('doc', 'projectId'));
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
        
        $doc = Doc::findOrFail($id);
        $doc->update($requestData);

        Session::flash('flash_message', 'Doc updated!');

        return redirect('projects/'.$projectId.'/docs');
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
        Doc::destroy($id);

        Session::flash('flash_message', 'Doc deleted!');

        return redirect('projects/'.$projectId.'/docs');
    }
}
