<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Form;
use App\Models\Link;
use App\Models\TestCase;
use Illuminate\Http\Request;
use Session;

class RemoveController extends Controller
{

    public function index(Request $request)
    {

        if($request->delete_check_list!=''){
            $arr = explode(',',$request->delete_check_list);

            if($request->collection=='link'){
               foreach ($arr as $id){
                   Link::destroy($id);
               }
            }elseif ($request->collection=='form'){
                foreach ($arr as $id){
                    Form::destroy($id);
                }
            }elseif ($request->collection=='test_cases'){
                foreach ($arr as $id){
                    TestCase::destroy($id);
                }
            }
        }

        return redirect($request->back_link);
    }
}
