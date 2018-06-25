<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Auth;

class ReportController extends Controller
{
/**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($projectId, Request $request)
    {
        $keyword = $request->get('search');
        $perPage = config('view.page_limit');
        $total = 0;
        if (!empty($keyword)) {
            $reports = Report::where('response', 'LIKE', "%$keyword%");
            $reports = $reports->where('type', 0);
            $reports = $reports->where('project_id', $projectId);

            $reports = $reports->paginate($perPage);
            $total = $reports->total();

        } else {
            $reports = Report::where('project_id', $projectId);
            $reports = $reports->where('type', 0);
            $reports = $reports->where('project_id', $projectId);

            $reports = $reports->paginate($perPage);
            $total = $reports->total();
        }

        return view('reports.index', compact('reports', 'total', 'projectId'));
    }


}
