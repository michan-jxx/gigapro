<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\StudentPc;
use App\Models\School;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PcRequest;
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

}
