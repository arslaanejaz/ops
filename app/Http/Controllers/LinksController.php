<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Link;
use Illuminate\Http\Request;
use Session;

class LinksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index($projectId, Request $request)
    {
        $keyword = $request->get('search');
        $external = $request->get('external');
        $internal = $request->get('internal');
        $perPage = config('view.page_limit');
        $total = 0;
        if (!empty($keyword)) {
            $links = Link::where('uri', 'LIKE', "%$keyword%");
			$links = $links->orWhere('title', 'LIKE', "%$keyword%");
            $links = $links->where('project_id', $projectId);
            if($external) {
                $links = $links->where('type', 1);
            }elseif ($internal){
                $links = $links->where('type', 0);
            }
            $links = $links->paginate($perPage);
            $total = $links->total();

        } else {
            $links = Link::where('project_id', $projectId);
            if($external) {
                $links = $links->where('type', 1);
            }elseif ($internal){
                $links = $links->where('type', 0);
            }
            $links = $links->paginate($perPage);
            $total = $links->total();
        }

        return view('links.index', compact('links', 'total', 'projectId'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create($projectId)
    {
        return view('links.create', compact('projectId'));
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
			'uri' => 'required',
			'title' => 'required',
			'type' => 'required'
		]);
        $requestData = $request->all();
        $requestData['project_id'] = $projectId;
        
        Link::create($requestData);

        Session::flash('flash_message', 'Link added!');

        return redirect('projects/'.$projectId.'/links');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($projectId,$id)
    {
        $link = Link::findOrFail($id);

        return view('links.show', compact('link', 'projectId'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($projectId,$id)
    {
        $link = Link::findOrFail($id);

        return view('links.edit', compact('link', 'projectId'));
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
        
        $link = Link::findOrFail($id);
        $link->update($requestData);

        Session::flash('flash_message', 'Link updated!');

        return redirect('projects/'.$projectId.'/links');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($projectId,$id)
    {
        Link::destroy($id);

        Session::flash('flash_message', 'Link deleted!');

        return redirect('projects/'.$projectId.'/links');
    }
}
