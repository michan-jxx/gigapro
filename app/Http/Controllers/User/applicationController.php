<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\StudentPc;
use App\Http\Requests\ContactRequest;
use App\Http\Controllers\Controller;

class applicationController extends Controller
{
     /**
     * 申請画面を表示
     *
     * @return view
     **/
    public function form()
    {
        $clients = StudentPc::select('id')->get();

        $client_id_loop = $clients->pluck('id');

        return view('user.form',
        [
            'client_id_loop' => $client_id_loop,
        ]);
    }

    /**
     *  バリデーション
     *
     *@return view
     * */
    public function validation(ContactRequest $request){
        $inputs = $request->all();
        return view('user.formCheck',['inputs' => $inputs]);
    }

    /**
     *  申請登録
     *
     *@return view
     * */
    public function apply(ContactRequest $request){
        Application::create([
            'pc_id' => $request->pc_id,
            'category' => $request->category,
            'petition' => $request->petition,
        ]);

        return view('user.complete');
    }

}
