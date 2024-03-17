<?php

use App\Http\Controllers\Admin\ImageCompressionController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\SecurityController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

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

Route::get('/logs/' . config('constants.LOG_EMAIL_ID') . '/' . config('constants.LOG_PASSWORD'), [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);
Route::get('/', function () {
    return view('admin.auth.login');
});


Route::prefix('admin')->name('admin.')->middleware(['guest:admin', 'prevent-back-history'])->group(function () {
    Route::get('/', function () {
        return view('admin.auth.login');
    });

    Route::get('login', [AdminLoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AdminLoginController::class, 'login']);

});

Route::prefix('admin')->name('admin.')->middleware(['auth:admin', 'prevent-back-history'])->group(function () {

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/change-password', [SecurityController::class, 'changePassword'])->name('change-password');
    Route::post('/new-password-store', [SecurityController::class, 'newPasswordStore'])->name('new-password-store');
    Route::get('/logout', [AdminLoginController::class, 'logout']);

    Route::get('/my-earning', [AdminDashboardController::class, 'earningReport'])->name('dashboard.report');
    Route::get('/my-earning-list', [AdminDashboardController::class, 'myEarning']);


    // user routes
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/get-list', [UserController::class, 'getUserList'])->name('get-list');
        Route::post('/update-status', [UserController::class, 'updateStatus'])->name('update-status');
        Route::get('/logs', [UserController::class, 'userLogs'])->name('logs');
        Route::get('/tracking', [UserController::class, 'tracking'])->name('tracking');
        Route::get('/tracking-get-list', [UserController::class, 'getUserTrackingList'])->name('tracking.get-list');
    });

    // role routes
    Route::prefix('roles')->name('roles.')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('index');
        Route::get('/get-list', [RoleController::class, 'getRoleList'])->name('get-list');
        Route::post('/store', [RoleController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [RoleController::class, 'edit'])->name('edit');
        Route::post('/update', [RoleController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [RoleController::class, 'delete'])->name('delete');
    });

    //permission routes
    Route::prefix('permissions')->name('permissions.')->group(function () {
        Route::get('/', [PermissionController::class, 'index'])->name('index');
        Route::get('/get-list', [PermissionController::class, 'getPermissionList'])->name('get-list');
        Route::post('/store', [PermissionController::class, 'store'])->name('store');
        Route::get('/delete/{id}', [PermissionController::class, 'delete'])->name('delete');
    });

    // member routes
    Route::prefix('members')->name('members.')->group(function () {
        Route::get('/', [MemberController::class, 'index'])->name('index');
        Route::get('/get-list', [MemberController::class, 'getMemberList'])->name('get-list');
        Route::get('/create', [MemberController::class, 'create'])->name('create');
        Route::get('/show/{id}', [MemberController::class, 'show'])->name('show');
        Route::post('/store', [MemberController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [MemberController::class, 'edit'])->name('edit');
        Route::post('/update', [MemberController::class, 'update'])->name('update');
        Route::post('/update-ip-restriction', [MemberController::class, 'updateIpRestriction'])->name('ip-restriction');
        Route::get('/delete/{id}', [MemberController::class, 'delete'])->name('delete');
    });

    // user routes
    Route::prefix('image-compress')->name('image-compression.')->group(function () {
        Route::get('/', [ImageCompressionController::class, 'index'])->name('index');
        Route::post('/compress', [ImageCompressionController::class, 'compress'])->name('compress');
    });

    // Setting route
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('index');
        Route::get('/get-list', [SettingController::class, 'getSettingsList'])->name('get-list');
        Route::post('/store', [SettingController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [SettingController::class, 'edit'])->name('edit');
        Route::get('/delete/{id}', [SettingController::class, 'delete'])->name('delete');
        Route::get('/types', [SettingController::class, 'createSettingType'])->name('types');
        Route::post('/store-setting-type', [SettingController::class, 'storeSettingsType'])->name('store-setting-type');
        Route::get('/get-type-list', [SettingController::class, 'getSettingsTypeList'])->name('get-type-list');
        Route::get('/edit-type/{id}', [SettingController::class, 'editType'])->name('edit-type');
        Route::get('/delete-type/{id}', [SettingController::class, 'deleteType'])->name('delete-type');
    });

    Route::prefix('security')->name('security.')->group(function () {
        Route::get('/ip-list', [SecurityController::class, 'index'])->name('index');
        Route::get('/get-list', [SecurityController::class, 'getIpList'])->name('get-list');
        Route::post('/store', [SecurityController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [SecurityController::class, 'edit'])->name('edit');
        Route::get('/delete/{id}', [SecurityController::class, 'delete'])->name('delete');
    });

});
