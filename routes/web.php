<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\studentPcController;
use App\Http\Controllers\applicationController;
use App\Http\Controllers\repairController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// ログイン情報を表示
Route::get('/pc_index','App\Http\Controllers\studentPcController@indexId')
->name('indexId');

// user生徒PC一覧を表示
Route::get('/pc_index','App\Http\Controllers\studentPcController@index')
->name('index');

// user生徒PC編集画面
Route::get('/pc_edit/{id}', 'App\Http\Controllers\studentPcController@edit')
->name('pc.edit');

// 生徒PC更新
Route::post('/update', 'App\Http\Controllers\studentPcController@update')
->name('pc.update');

// 生徒PC新規登録画面を表示
Route::get('/pc_register', 'App\Http\Controllers\studentPcController@store')
->name('pc.store');

// 生徒PC登録
Route::post('/exeStore', 'App\Http\Controllers\studentPcController@exeStore')
->name('pc.exeStore');

// 生徒PCファイル一括登録画面を表示
Route::get('/pc_fileRegister', 'App\Http\Controllers\studentPcController@fileStore')
->name('pc.fileStore');

// テーブルにインポート
Route::post('/import', 'App\Http\Controllers\studentPcController@import')
->name('pc.import');

// テンプレートをエクスポート
Route::get('/download', 'App\Http\Controllers\studentPcController@download')
->name('pc.download');

//申請フォーム画面を表示
Route::get('/form', 'App\Http\Controllers\applicationController@form')
->name('form');

//バリデーション
Route::post('/form', 'App\Http\Controllers\applicationController@validation')
->name('validation');

//申請登録
Route::post('/apply', 'App\Http\Controllers\applicationController@apply')
->name('apply');
