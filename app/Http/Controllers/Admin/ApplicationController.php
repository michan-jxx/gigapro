<?php

namespace App\Http\Controllers\Admin;

use App\Models\Application;
use App\Models\StudentPc;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ContactRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PcRequest;
use Illuminate\Pagination\Paginator;

class ApplicationController extends Controller
{
    public function recept(Request $request)
    {

        $schools = School::All();

        $keyword = $request->input('keyword');
        $school = $request->input('school');

        $county = DB::table('application')
            ->count();

        $query = DB::table('application')
        ->leftjoin('studentPc', 'application.pc_id', '=', 'studentPc.id')
        ->leftjoin('school', 'school.id', '=', 'studentPc.school_id');
        // ->select('application.id', 'application.pc_id','school.name','application.created_at','application.category',
        // 'application.condition', 'application.return_day')
        // ->latest('application.created_at')
        // ->paginate(15);


        if(!empty($keyword)){
            $query
            ->Where('studentPc.id', '=', "{$keyword}")
            ->latest('application.created_at')
            ->paginate(15);
        }
        if(!empty($school)){
            $query
            ->Where('school_id', '=', "{$school}")
            ->latest('application.created_at')
            ->paginate(15);
        }


        $posts = $query
        ->select('application.id', 'application.pc_id','school.name','application.created_at','application.category',
        'application.condition', 'application.return_day')
        ->latest('application.created_at')
        ->orderBy('school_id')
        ->paginate(15);

        return view('admin.reception',[
            'posts' => $posts,
            'keyword' => $keyword,
            'school' => $school,
            'schools' => $schools,
            'county' => $county,
        ]);
    }

    /**
     *  削除
     *@param int $id
     *@return view
     * */
    public function complete($id)
    {
        Application::destroy($id);
        return redirect('admin/reception');
    }

     /**
     *  修理状況の入力画面を表示
     *@param int $id
     *@return view
     * */
    public function repair($id)
    {
        $reps = DB::table('application')
        ->leftjoin('studentPc', 'application.pc_id', '=', 'studentPc.id')
        ->leftjoin('school', 'studentPc.school_id', '=', 'school.id')
        ->select('application.id', 'school.name', 'application.pc_id', 'application.category', 'application.petition', 'application.created_at',
        'application.condition', 'application.return_day')
        ->where('application.id', '=', $id)
        ->first();

        return view('admin.application',[
            'reps' => $reps
        ]);
    }

    public function exeUpdate(ContactRequest $request)
    {
        $reps = $request->all();

        $post = Application::find($reps['id']);

        $post -> fill([
            'pc_id' => $reps['pc_id'],
            'category' => $reps['category'],
            'petition' => $reps['petition'],
            'condition' => $reps['condition'],
            'return_day' => $reps['return_day'],
        ]);

        $post -> save();

        return redirect('admin/reception');
    }

}
