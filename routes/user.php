<?php

use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\studentPcController;
use App\Http\Controllers\User\applicationController;
use App\Http\Controllers\User\repairController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\Auth\AuthenticatedSessionController;
use App\Http\Controllers\User\Auth\ConfirmablePasswordController;
use App\Http\Controllers\User\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\User\Auth\EmailVerificationPromptController;
use App\Http\Controllers\User\Auth\NewPasswordController;
use App\Http\Controllers\User\Auth\PasswordResetLinkController;
use App\Http\Controllers\User\Auth\RegisteredUserController;
use App\Http\Controllers\User\Auth\VerifyEmailController;


Route::get('/', function () {
    return view('user.welcome');
})->name('welcome');

Route::middleware('auth:users')->group(function() {
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
                ->middleware('auth:users')
                ->name('logout');


// user生徒PC一覧を表示
Route::get('user/pc_index','App\Http\Controllers\User\studentPcController@index')
// ->middleware('auth:users')
->name('index');

// user生徒PC編集画面
Route::get('user/pc_edit/{id}', 'App\Http\Controllers\User\studentPcController@edit')
->name('pc.edit');

// 生徒PC更新
Route::post('user/update', 'App\Http\Controllers\User\studentPcController@update')
->name('pc.update');

// 生徒PC新規登録画面を表示
Route::get('user/pc_register', 'App\Http\Controllers\User\studentPcController@store')
->name('pc.store');

// 生徒PC登録
Route::post('user/exeStore', 'App\Http\Controllers\User\studentPcController@exeStore')
->name('pc.exeStore');

// 生徒PCファイル一括登録画面を表示
Route::get('user/pc_fileRegister', 'App\Http\Controllers\User\studentPcController@fileStore')
->name('pc.fileStore');

// テーブルにインポート
Route::post('/import', 'App\Http\Controllers\User\studentPcController@import')
->name('pc.import');

// テンプレートをエクスポート
Route::get('/download', 'App\Http\Controllers\User\studentPcController@download')
->name('pc.download');

//申請フォーム画面を表示
Route::get('user/form', 'App\Http\Controllers\User\applicationController@form')
->name('form');

//バリデーション
Route::post('user/form', 'App\Http\Controllers\User\applicationController@validation')
->name('validation');

//申請登録
Route::post('/apply', 'App\Http\Controllers\User\applicationController@apply')
->name('apply');

//申請登録
Route::get('/admin/welcome', 'App\Http\Controllers\User\studentPcController@admin_welcome')
->name('admin_welcome');

// 生徒PC詳細画面更新
Route::get('/pc_detail/{id}', 'App\Http\Controllers\User\studentPcController@detail')
->name('pc.detail');

// 生徒PC一覧エクスポート
Route::post('/export', 'App\Http\Controllers\User\studentPcController@export')
->name('pc.export');




