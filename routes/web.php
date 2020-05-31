<?php

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

Route::get('/', function () {
    return view('welcome');
})->name('welcomeView');
Route::post('messages','Admin\ContactUsController@store')->name('messages.store');
// Route::get('/auth', function() {
// 				$status = Artisan::call('make:auth');
// 				return '<h1>Configurations make auth</h1>';
// 			});
Route::group(['prefix' => 'admin' , 'namespace'=>'Admin'],function (){



    Route::middleware('auth:admin')->group(function(){

        Route::get('dashboard','DashboardController@index')->name('dashboard');

        //Users

        Route::get('admins','AdminController@show_users')->name('admin.users');
        Route::post('admins','AdminController@store_users')->name('admin.users.store');
        Route::get('admins/{id}/edit','AdminController@edit_users')->name('admin.users.edit');
        Route::put('admins/{id}','AdminController@update_users')->name('admin.users.update');
        Route::delete('admins/{id}','AdminController@delete_users')->name('admin.users.delete');

        
          //Settings
        Route::get('settings','SettingController@index')->name('settings');
        Route::get('settings/create','SettingController@create')->name('settings.create');
        Route::post('settings','SettingController@store')->name('settings.store');

        //users
       Route::resource('users','UserController');

         //Section
       Route::resource('section','SectionController');
       
         //codes
       Route::resource('codes','CodesController');

       //Occasions
       Route::resource('occasions','OccasionController');
    });

     Route::get('login','AdminController@index')->name('admin.login');
     Route::post('login','AdminController@store')->name('login.store');
     Route::post('logout','AdminController@logout')->name('admin.logout');


});