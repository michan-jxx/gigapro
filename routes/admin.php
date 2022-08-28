<?php

use App\Http\Controllers\Admin\studentPcController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Admin\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Admin\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Admin\Auth\NewPasswordController;
use App\Http\Controllers\Admin\Auth\PasswordResetLinkController;
use App\Http\Controllers\Admin\Auth\RegisteredUserController;
use App\Http\Controllers\Admin\Auth\VerifyEmailController;
// use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('admin.welcome');
})->name('welcome');

Route::middleware('auth:admins')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');
});

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
                ->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', [EmailVerificationPromptController::class, '__invoke'])
                ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

});

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->middleware('auth:admins')
                ->name('logout');

// 学校一覧を表示
Route::get('/pc_title','App\Http\Controllers\Admin\SchoolController@exeSchool')
->middleware('auth:admins')
->name('exeSchool');

// 各学校PC一覧画面を表示
Route::get('/pc_index/{id}','App\Http\Controllers\Admin\studentPcController@index')
->middleware('auth:admins')
->name('pc.index');

// user生徒PC編集画面
Route::get('/pc_edit/{id}', 'App\Http\Controllers\Admin\studentPcController@edit')
->middleware('auth:admins')
->name('pc.edit');

// 生徒PC更新
Route::post('/update', 'App\Http\Controllers\Admin\studentPcController@update')
->name('pc.update');

// 生徒PC詳細画面更新
Route::get('/pc_detail/{id}', 'App\Http\Controllers\Admin\studentPcController@detail')
->middleware('auth:admins')
->name('pc.detail');

// 生徒PC削除
Route::post('/pc_detail/{id}', 'App\Http\Controllers\Admin\studentPcController@delete')
->name('pc.delete');

// 生徒PC新規登録画面を表示
Route::get('/pc_register', 'App\Http\Controllers\Admin\studentPcController@store')
->middleware('auth:admins')
->name('pc.store');

// 生徒PC登録
Route::post('/exeStore', 'App\Http\Controllers\Admin\studentPcController@exeStore')
->middleware('auth:admins')
->name('pc.exeStore');

// 生徒PCファイル一括登録画面を表示
Route::get('/pc_fileRegister', 'App\Http\Controllers\Admin\studentPcController@fileStore')
->middleware('auth:admins')
->name('pc.fileStore');

// テーブルにインポート
Route::post('/import', 'App\Http\Controllers\Admin\studentPcController@import')
->name('pc.import');

// テンプレートをエクスポート
Route::get('/download', 'App\Http\Controllers\Admin\studentPcController@download')
->name('pc.download');

// エクスポート
Route::post('/export', 'App\Http\Controllers\Admin\studentPcController@export')
->name('students_export');

// 申請受付一覧を表示
Route::get('/reception','App\Http\Controllers\Admin\ApplicationController@recept')
->middleware('auth:admins')
->name('recept');

// 申請受付完了
Route::post('/complete/{id}','App\Http\Controllers\Admin\ApplicationController@complete')
->middleware('auth:admins')
->name('complete');

// 修理状況入力
Route::get('/repair/{id}','App\Http\Controllers\Admin\ApplicationController@repair')
->middleware('auth:admins')
->name('repair');

// 修理状況登録
Route::post('/exeUpdate','App\Http\Controllers\Admin\ApplicationController@exeUpdate')
->name('exeUpdate');

// 生徒PC一覧エクスポート
Route::post('/export', 'App\Http\Controllers\Admin\studentPcController@export')
->name('pc.export');

// チェックボックス削除
Route::post('/check_delete', 'App\Http\Controllers\Admin\studentPcController@check_delete')
->name('check.delete');

