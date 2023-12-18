<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ModualController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginSecurityController;
use Illuminate\Support\Facades\Route;

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


Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home')->middleware(['auth', 'XSS', '2fa',]);

Route::post('/chart', [HomeController::class, 'chart'])->name('get.chart.data')->middleware(['auth', 'XSS',]);

Route::get('notification', [HomeController::class, 'notification']);


Route::group(['middleware' => ['auth', 'XSS']], function () {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('permission', PermissionController::class);
    Route::resource('modules', ModualController::class);
});

Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('users.destroy')->middleware(['auth', 'XSS']);

Route::post('/role/{id}', [RoleController::class, 'assignPermission'])->name('roles_permit')->middleware(['auth', 'XSS']);

Route::group(
    ['middleware' => ['auth', 'XSS']],
    function () {
        Route::get('setting/email-setting', [SettingController::class, 'getmail'])->name('settings.getmail');
        Route::post('setting/email-settings_store', [SettingController::class, 'saveEmailSettings'])->name('settings.emails');

        Route::get('setting/datetime', [SettingController::class, 'getdate'])->name('datetime');
        Route::post('setting/datetime-settings_store', [SettingController::class, 'saveSystemSettings'])->name('settings.datetime');

        Route::get('setting/logo', [SettingController::class, 'getlogo'])->name('getlogo');
        Route::post('setting/logo_store', [SettingController::class, 'store'])->name('settings.logo');
        Route::resource('settings', SettingController::class);

        Route::get('test-mail', [SettingController::class, 'testMail'])->name('test.mail');
        Route::post('test-mail', [SettingController::class, 'testSendMail'])->name('test.send.mail');
    }
);

Route::get('profile', [UserController::class, 'profile'])->name('profile')->middleware(['auth', 'XSS']);

Route::post('edit-profile', [UserController::class, 'editprofile'])->name('update.profile')->middleware(['auth', 'XSS']);

Route::group(
    ['middleware' => ['auth', 'XSS']],
    function () {
        Route::get('change-language/{lang}', [LanguageController::class, 'changeLanquage'])->name('change.language');
        Route::get('manage-language/{lang}', [LanguageController::class, 'manageLanguage'])->name('manage.language');
        Route::post('store-language-data/{lang}', [LanguageController::class, 'storeLanguageData'])->name('store.language.data');
        Route::get('create-language', [LanguageController::class, 'createLanguage'])->name('create.language');
        Route::post('store-language', [LanguageController::class, 'storeLanguage'])->name('store.language');
        Route::delete('/lang/{lang}', [LanguageController::class, 'destroyLang'])->name('lang.destroy');
        Route::get('language', [LanguageController::class, 'index'])->name('index');
    }
);

Route::get('generator_builder', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@builder')->name('io_generator_builder')->middleware(['auth', 'XSS',]);

Route::get('field_template', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@fieldTemplate')->name('io_field_template')->middleware(['auth', 'XSS',]);

Route::get('relation_field_template', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@relationFieldTemplate')->name('io_relation_field_template')->middleware(['auth', 'XSS',]);

Route::post('generator_builder/generate', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@generate')->name('io_generator_builder_generate')->middleware(['auth', 'XSS',]);

Route::post('generator_builder/rollback', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@rollback')->name('io_generator_builder_rollback')->middleware(['auth', 'XSS',]);

Route::post(
    'generator_builder/generate-from-file',
    '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@generateFromFile'
)->name('io_generator_builder_generate_from_file')->middleware(['auth', 'XSS',]);

Route::group(['prefix' => '2fa'], function () {
    Route::get('/', [UserController::class, 'profile'])->name('2fa')->middleware(['auth', 'XSS',]);
    Route::post('/generateSecret', [LoginSecurityController::class, 'generate2faSecret'])->name('generate2faSecret')->middleware(['auth', 'XSS',]);
    Route::post('/enable2fa', [LoginSecurityController::class, 'enable2fa'])->name('enable2fa')->middleware(['auth', 'XSS',]);
    Route::post('/disable2fa', [LoginSecurityController::class, 'disable2fa'])->name('disable2fa')->middleware(['auth', 'XSS',]);

    // 2fa middleware
    Route::post('/2faVerify', function () {
        return redirect(URL()->previous());
    })->name('2faVerify')->middleware('2fa');
});






































Route::resource('tests', App\Http\Controllers\TestController::class)->middleware(['auth', 'XSS']);




















































































































































































































































































































































