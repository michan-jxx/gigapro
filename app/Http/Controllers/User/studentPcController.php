<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Models\StudentPc;
use App\Models\School;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PcRequest;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\studentPcImport;
use App\Exports\studentPcExport;
use App\Exports\pcExport;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;

class studentPcController extends Controller
{


    /**
     * 対象の学校の生徒PC一覧を表示
     *
     * @return view
     **/
    public function index(Request $request)
    {
        $users = auth()->user()->school_id;

        $scho = DB::table('school')
        ->select('school.name')
        ->where('school.id', '=', $users)
        ->first();

        // $columns = DB::table('studentPc')
        // ->select('studentPc.id', 'studentPc.school_id', 'studentPc.grade', 'studentPc.class', 'studentPc.name')
        // ->where('studentPc.school_id', '=', $users)
        // ->orderByRaw('grade IS NULL ASC')
        // ->orderBy('grade')
        // ->paginate(15);

        $keyword = $request->input('keyword');
        $grade = $request->input('grade');
        $class = $request->input('class');

        $gradese = StudentPc::groupBy('grade')->get('grade');
        $classes = StudentPc::groupBy('class')->get('class');

        $county = DB::table('studentPc')
            ->where('studentPc.school_id', '=', $users)
            ->count();


        $query = StudentPc::query();

        if(!empty($keyword)){
            $query
            ->where('school_id', '=', $users)
            ->Where('id', '=', "{$keyword}")
            ->orWhere('name', 'LIKE', "%{$keyword}%")
            ->orderByRaw('grade IS NULL ASC')
            ->orderBy('grade')
            ->paginate(15);
        }
        if(!empty($grade)){
            $query
            ->where('school_id', '=', $users)
            ->Where('grade', '=', "{$grade}")
            ->orderByRaw('grade IS NULL ASC')
            ->orderBy('grade')
            ->paginate(15);
        }
        if(!empty($class)){
            $query
            ->where('school_id', '=', $users)
            ->Where('class', '=', "{$class}")
            ->orderByRaw('grade IS NULL ASC')
            ->orderBy('grade')
            ->paginate(15);
        }

        $columns = $query->where('school_id', '=', $users)->orderBy('grade')->orderBy('class')->paginate(15);

        return view('user.pc_index',[
            'columns' => $columns,
            'scho' => $scho,
            'keyword' => $keyword,
            'grade' => $grade,
            'class' => $class,
            'gradese' => $gradese,
            'classes' => $classes,
            'county' => $county,
        ]);
    }



    /**
     *  詳細画面を表示
     *@param int $id
     *@return view
     * */
    public function detail($id)
    {
        $pcdets = DB::table('studentPc')
        ->leftjoin('school','studentPc.school_id', '=', 'school.id')
        ->leftjoin('application', 'studentPc.id', '=', 'application.pc_id')
        ->select('studentPc.id', 'school.name as school','studentPc.grade', 'studentPc.class', 'studentPc.name',
        'application.created_at', 'application.category','application.petition', 'application.condition', 'application.return_day')
        ->where('studentPc.id', '=', $id)
        ->get();

        return view('user.pc_detail',[
            'pcdets' => $pcdets,
        ]);
    }

    /**
     * 編集画面を表示
     *
     * @return view
     **/
    public function edit($id)
    {
        $users = School::All();
        $pc = StudentPc::find($id);

        return view('user.pc_edit',[
            'pc' => $pc,
            'users' => $users,
        ]);
    }

     /**
     *  更新
     *@param int $id
     *@return view
     * */
    public function update(PcRequest $request)
    {
        $inputs = $request->all();

        $post = StudentPc::find($inputs['id']);

        $post -> fill([
            'school_id' => $inputs['school_id'],
            'grade' => $inputs['grade'],
            'class' => $inputs['class'],
            'name' => $inputs['name'],
        ]);

        $post -> save();

        return redirect('user/pc_index');
    }

    /**
     * 新規登録画面表示
     *
     * @return view
     **/
    public function store()
    {
        $categories = School::All();
        return view('user.pc_register',[
        'categories' => $categories,
    ]);
    }

    /**
     * 新規登録
     * @param string.int $request
     * @return view
     **/
    public function exeStore(PcRequest $request)
    {
        StudentPc::create([
            'school_id' => $request->school_id,
            'grade' => $request->grade,
            'class' => $request->class,
            'name' => $request->name,
        ]);

        return redirect('user/pc_index');
    }

    /**
     * エクセル一括処理画面表示
     *
     * @return view
     **/
    public function fileStore()
    {
        return view('user.pc_fileRegister');
    }

    /**
     * エクセルファイルインポート
     *
     * @return view
     **/
    public function import()
    {
        Excel::import(new studentPcImport, request()->file('file'));
        return redirect('user/pc_index');
    }

    /**
     * エクセルテンプレート
     * @param
     * @return view
     **/
    public function download()
    {
        return Excel::download(new studentPcExport, 'template.xlsx');
    }

    /**
     * ログイン情報を表示
     *
     * @return view
     **/
    public function admin_welcome()
    {
        return view('admin.welcome');
    }

    public function export()
    {
        return Excel::download(new pcExport, 'pc.data.xlsx');

    }

}
