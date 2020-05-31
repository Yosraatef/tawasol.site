<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('register','Api\AuthController@register');
Route::get('codes','Api\AuthController@codes');
Route::post('login','Api\AuthController@login');
Route::post('changePassword','Api\AuthController@changePassword');
Route::get('google', 'Api\SocialAuthGoogleController@redirect');
Route::get('google/callback', 'Api\SocialAuthGoogleController@callback');


Route::get('getOccasions','Api\OccasionController@index');
Route::get('getPublicOcassions','Api\OccasionController@getPublicOcassions');
Route::post('getPrivtOcassionsSection',
	'Api\OccasionController@getPrivtOcassionsSection');
Route::get('getPrivtOcassionsOfficer','Api\OccasionController@getPrivtOcassionsOfficer');
Route::get('getRejectedOcassions','Api\OccasionController@getRejectedOcassions');
Route::get('getAllSection','Api\SectionController@getAllSection');
Route::get('setting','Api\AuthController@setting');
Route::post('search','Api\AuthController@search');
Route::post('deleteOccasions','Api\OccasionController@destroy');
Route::post('destroyNotfy','Api\OccasionController@destroyNotfy');
Route::post('editUser','Api\ProfileController@editUser');
Route::post('ocid','Api\OccasionController@ocid');

Route::group(['middleware' => 'auth:api' , 'namespace'=>'Api'],function(){
	
	//Occasion


	Route::post('saveOccasions','OccasionController@store');
	
	Route::post('updateOccasions','OccasionController@update');
	Route::post('headDecision','OccasionController@headDecision');
	Route::post('sendComment','OccasionController@sendComment');
Route::post('getComments','OccasionController@getComments');	
	Route::get('getAuthNotification','OccasionController@getAuthNotification');
	
	
	//Occasion
	Route::post('contactUS','CountactUSController@contactUS');

	//Profile
	Route::post('profileUser','ProfileController@profileUser');
	Route::post('profileAdmin','ProfileController@profileAdmin');

	Route::post('activcodeuser','AuthController@activcodeuser');
	// notification
	Route::post('notUserTManger','NotificationController@notificationFromUserToManger');
});