<?php

namespace App\Http\Controllers\Admin;

// use Illuminate\Http\Request;
use App\Models\StudentPc;
use App\Models\School;
use App\Models\application;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PcRequest;
use App\Http\Requests\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\studentPcImport;
use App\Exports\studentPcExport;
use App\Exports\allPcExport;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;

class studentPcController extends Controller
{


    /**
     * 各学校の生徒PC一覧を表示
     * @param int $id
     * @return view
     **/
    public function index($id)
    {

        $scho = DB::table('school')
        ->select('school.name')
        ->where('school.id', '=', $id)
        ->first();

        $columns = DB::table('studentPc')
        ->leftjoin('school', 'studentPc.school_id', '=', 'school.id')
        ->select('studentPc.id','studentPc.grade','studentPc.class','studentPc.name')
        ->where('studentPc.school_id','=',$id)
        ->orderByRaw('grade IS NULL ASC')
        ->orderBy('grade')
        ->orderBy('class')
        ->paginate(15);

        $county = DB::table('studentPc')
            ->where('studentPc.school_id', '=', $id)
            ->count();

        return view('admin.pc_index',[
            'columns' => $columns,
            'scho' => $scho,
            'county' => $county,
        ]);
    }

    /**
     * 編集画面を表示
     * @param int $id
     * @return view
     **/
    public function edit($id)
    {
        $users = School::All();
        $pc = StudentPc::find($id);

        return view('admin.pc_edit',[
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

        return redirect()->route('admin.pc.index',[$post->school_id]);
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

        return view('admin.pc_detail',[
            'pcdets' => $pcdets,

        ]);
    }



    /**
     *  削除
     *@param int $id
     *@return view
     * */
    public function delete($id)
    {
        $inputs=StudentPc::find($id);

        studentPc::destroy($id);
        return redirect()->route('admin.pc.index',[$inputs->school_id]);
    }

    /**
     * 新規登録画面表示
     *
     * @return view
     **/
    public function store()
    {
        $categories = School::All();
        return view('admin.pc_register',[
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

        return redirect('admin/pc_title');
    }

    /**
     * エクセル一括処理画面表示
     *
     * @return view
     **/
    public function fileStore()
    {
        return view('admin.pc_fileRegister');
    }

    /**
     * エクセルファイルインポート
     *
     * @return view
     **/
    public function import()
    {
        Excel::import(new studentPcImport, request()->file('file'));
        return redirect('admin/pc_title');
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

    public function export()
    {
        return Excel::download(new allPcExport, 'pc.data.xlsx');
    }

    public function check_delete(Request $request)
    {
        $delete = array($request->input('delete'));
        $inputs = DB::table('studentPc')
        ->where('id','=',$delete)
        ->first();
        // dd($delete);

        foreach($delete as $key){
            studentPc::destroy($key);
        }

        return redirect()->route('admin.pc.index',[$inputs->school_id]);
        // return redirect('admin/pc_title');



    }

    public function allIndex(Request $request){


        $school = $request->input('school');
        $grade = $request->input('grade');
        $class = $request->input('class');
        $keyword = $request->input('keyword');
        $category = $request->input('category');
        $petition = $request->input('petition');
        $create = $request->input('create');

        $schools = School::groupby('name')->get('name');
        $gradese = StudentPc::groupBy('grade')->get('grade');
        $classes = StudentPc::groupBy('class')->get('class');
        $categories = application::groupBy('category')->get('category');

        $query = StudentPc::query();
        // テーブル結合
        $query->leftjoin('school',function($query)use($request){
            $query->on('studentPc.school_id','=','school.id');
        })->leftjoin('application',function($query)use($request){
            $query->on('studentPc.id','=','application.pc_id');
        });


        if(!empty($school)){
            $query
            ->where('school.name','=',"{$school}")
            ->orderByRaw('grade IS NULL ASC')
            ->orderBy('grade')
            ->paginate(30);
        }
        if(!empty($grade)){
            $query
            ->where('studentPc.grade','=',"{$grade}")
            ->orderByRaw('grade IS NULL ASC')
            ->orderBy('grade')
            ->paginate(30);
        }
        if(!empty($class)){
            $query
            ->where('studentPc.class','=',"{$class}")
            ->orderByRaw('grade IS NULL ASC')
            ->orderBy('grade')
            ->paginate(30);
        }
        if(!empty($keyword)){
            $query
            ->Where('studentPc.id', '=', "{$keyword}")
            ->orWhere('studentPc.name', 'LIKE', "%{$keyword}%")
            ->orderByRaw('grade IS NULL ASC')
            ->orderBy('grade')
            ->paginate(30);
        }
        if(!empty($create)){
            $query
            ->where('application.created_at','=',"{$create}")
            ->orderByRaw('grade IS NULL ASC')
            ->orderBy('grade')
            ->paginate(30);
        }
        if(!empty($category)){
            $query
            ->where('application.category','=',"{$category}")
            ->orderByRaw('grade IS NULL ASC')
            ->orderBy('grade')
            ->paginate(30);
        }
        if(!empty($petition)){
            $query
            ->Where('application.petition', 'LIKE', "%{$petition}%")
            ->orderByRaw('grade IS NULL ASC')
            ->orderBy('grade')
            ->paginate(30);
        }
        $items = $query
        ->select('studentPc.id','studentPc.grade','studentPc.class','studentPc.name',
        'studentPc.school_id','school.name as school_name','application.category',
        'application.petition','application.created_at')
        ->orderBy('school_id')
        ->orderBy('grade')
        ->orderBy('class')
        ->orderBy('id')
        ->paginate(30);


        return view('admin.pc_alldata',[
            'items' => $items,
            'schools' =>$schools,
            'gradese' =>$gradese,
            'classes' =>$classes,
            'categories' =>$categories,
            'school' =>$school,
            'grade' =>$grade,
            'class' =>$class,
            'keyword' =>$keyword,
            'category' =>$category,
            'petition' =>$petition,
            'create' =>$create,

        ]);
    }


}
