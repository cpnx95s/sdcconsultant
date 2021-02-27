<?php

use App\Http\Controllers;
use Illuminate\Support\Facades\DB;
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
//หน้าบ้าน



Route::get('', 'HomeController@index');
Route::get('index', 'HomeController@index');
Route::get('about', 'HomeController@about');
Route::get('contact', 'HomeController@contact');
Route::get('services', 'HomeController@services');
Route::get('fields_of_specialization', 'HomeController@fields_of_specialization');
Route::get('experience-detail/{id}', 'HomeController@experience_detail')->where(['id'=>'[0-9]+']);
Route::get('our_experience', 'HomeController@our_experience');



// Backend
Route::get('webpanel/login','Webpanel\AuthController@getLogin');
Route::post('webpanel/login','Webpanel\AuthController@postLogin');
Route::get('webpanel/logout', 'Webpanel\AuthController@logOut');
Route::group(['middleware'=>['Webpanel']], function(){

	Route::prefix('webpanel')->group(function(){

		Route::get('/','Webpanel\HomeController@index');
		
		Route::prefix('slide')->group(function(){
			Route::get('/','Webpanel\Slide@index');
			Route::get('/create','Webpanel\Slide@create');
        	Route::put('/create','Webpanel\Slide@store');
			Route::get('/{id}','Webpanel\Slide@show')->where(['id'=>'[0-9]+']);
			Route::post('/{id}','Webpanel\Slide@update')->where(['id'=>'[0-9]+']);
			Route::get('/destroy','Webpanel\Slide@destroy');
        	Route::post('/dragsort','Webpanel\Slide@dragsort');
        	Route::get('/status/{id}','Webpanel\Slide@status')->where(['id'=>'[0-9]+']);
		});
		Route::prefix('trucktype')->group(function(){
			Route::get('/','Webpanel\TrucktypeController@index');
			Route::get('/create','Webpanel\TrucktypeController@create');
        	Route::put('/create','Webpanel\TrucktypeController@store');
			Route::get('/{id}','Webpanel\TrucktypeController@show')->where(['id'=>'[0-9]+']);
			Route::post('/{id}','Webpanel\TrucktypeController@update')->where(['id'=>'[0-9]+']);
			Route::get('/destroy','Webpanel\TrucktypeController@destroy');
        	Route::post('/dragsort','Webpanel\TrucktypeController@dragsort');
        	Route::get('/status/{id}','Webpanel\TrucktypeController@status')->where(['id'=>'[0-9]+']);
		});

		Route::prefix('our_experience')->group(function(){
			Route::get('/','Webpanel\Our_experienceController@index');
			Route::get('/create','Webpanel\Our_experienceController@create');
        	Route::put('/create','Webpanel\Our_experienceController@store');
			Route::get('/{id}','Webpanel\Our_experienceController@edit')->where(['id'=>'[0-9]+']);
			Route::post('/{id}','Webpanel\Our_experienceController@update')->where(['id'=>'[0-9]+']);
			Route::get('/destroy','Webpanel\Our_experienceController@destroy');
        	Route::post('/dragsort','Webpanel\Our_experienceController@dragsort');
			Route::get('/status/{id}','Webpanel\Our_experienceController@status')->where(['id'=>'[0-9]+']);
		});

		Route::prefix('fields_of_specialization')->group(function(){
			Route::get('/','Webpanel\Fields_of_specializationController@index');
			Route::get('/create','Webpanel\Fields_of_specializationController@create');
        	Route::put('/create','Webpanel\Fields_of_specializationController@store');
			Route::get('/{id}','Webpanel\Fields_of_specializationController@edit')->where(['id'=>'[0-9]+']);
			Route::post('/{id}','Webpanel\Fields_of_specializationController@update')->where(['id'=>'[0-9]+']);
			Route::get('/destroy','Webpanel\Fields_of_specializationController@destroy');
        	Route::post('/dragsort','Webpanel\Fields_of_specializationController@dragsort');
			Route::get('/status/{id}','Webpanel\Fields_of_specializationController@status')->where(['id'=>'[0-9]+']);
		});
		Route::prefix('services')->group(function(){
			Route::get('/','Webpanel\ServicesController@index');
			Route::get('/create','Webpanel\ServicesController@create');
        	Route::put('/create','Webpanel\ServicesController@store');
			Route::get('/{id}','Webpanel\ServicesController@edit')->where(['id'=>'[0-9]+']);
			Route::post('/{id}','Webpanel\ServicesController@update')->where(['id'=>'[0-9]+']);
			Route::get('/destroy','Webpanel\ServicesController@destroy');
        	Route::post('/dragsort','Webpanel\ServicesController@dragsort');
			Route::get('/status/{id}','Webpanel\ServicesController@status')->where(['id'=>'[0-9]+']);
		});

		Route::prefix('fields_category')->group(function(){
			Route::get('/','Webpanel\Fields_categoryController@index');
			Route::get('/create','Webpanel\Fields_categoryController@create');
        	Route::put('/create','Webpanel\Fields_categoryController@store');
			Route::get('/{id}','Webpanel\Fields_categoryController@edit')->where(['id'=>'[0-9]+']);
			Route::post('/{id}','Webpanel\Fields_categoryController@update')->where(['id'=>'[0-9]+']);
			Route::get('/destroy','Webpanel\Fields_categoryController@destroy');
        	Route::post('/dragsort','Webpanel\Fields_categoryController@dragsort');
			Route::get('/status/{id}','Webpanel\Fields_categoryController@status')->where(['id'=>'[0-9]+']);
		});
		Route::prefix('about')->group(function(){
			Route::get('/','Webpanel\AboutController@index');
			Route::get('/create','Webpanel\AboutController@create');
        	Route::put('/create','Webpanel\AboutController@store');
			Route::get('/{id}','Webpanel\AboutController@edit')->where(['id'=>'[0-9]+']);
			Route::post('/{id}','Webpanel\AboutController@update')->where(['id'=>'[0-9]+']);
			Route::get('/destroy','Webpanel\AboutController@destroy');
        	Route::post('/dragsort','Webpanel\AboutController@dragsort');
			Route::get('/status/{id}','Webpanel\AboutController@status')->where(['id'=>'[0-9]+']);
		});

		Route::prefix('contact')->group(function(){
			Route::get('/','Webpanel\ContactController@index');
			Route::get('/create','Webpanel\ContactController@create');
        	Route::put('/create','Webpanel\ContactController@store');
			Route::get('/{id}','Webpanel\ContactController@edit')->where(['id'=>'[0-9]+']);
			Route::post('/{id}','Webpanel\ContactController@update')->where(['id'=>'[0-9]+']);
			Route::get('/destroy','Webpanel\ContactController@destroy');
        	Route::post('/dragsort','Webpanel\ContactController@dragsort');
			Route::get('/status/{id}','Webpanel\ContactController@status')->where(['id'=>'[0-9]+']);
		});
	
		Route::prefix('information')->group(function(){
			Route::get('/','Webpanel\informationController@index');
			Route::get('/create','Webpanel\informationController@create');
        	Route::put('/create','Webpanel\informationController@store');
			Route::get('/{id}','Webpanel\informationController@edit')->where(['id'=>'[0-9]+']);
			Route::post('/{id}','Webpanel\informationController@update')->where(['id'=>'[0-9]+']);
			Route::get('/destroy','Webpanel\informationController@destroy');
        	Route::post('/dragsort','Webpanel\informationController@dragsort');
			Route::get('/status/{id}','Webpanel\informationController@status')->where(['id'=>'[0-9]+']);
		});

		//=================================================//
	    //                     Setting                     //
	    //=================================================//
	    Route::prefix('user')->group(function(){
		    Route::get('/','Webpanel\User@index');
		    Route::get('/create','Webpanel\User@create');
		    Route::put('/create','Webpanel\User@store');
		    Route::get('/{id}','Webpanel\User@edit')->where(['id'=>'[0-9]+']);
		    Route::post('/{id}','Webpanel\User@update')->where(['id'=>'[0-9]+']);
		    Route::get('/reset/{id}','Webpanel\User@reset')->where(['id'=>'[0-9]+']);
		    Route::post('/reset/{id}','Webpanel\User@onReset')->where(['id'=>'[0-9]+']);
		    Route::get('/destroy','Webpanel\User@destroy');
		    Route::post('/sort','Webpanel\User@sort');
		    Route::post('/exist','Webpanel\User@exist');
		    Route::get('/exist-on-reset','Webpanel\User@checkUserOnReset');
		});
		
	    Route::prefix('menu')->group(function(){
		    Route::get('/','Webpanel\Setting@index');
		    Route::get('/create','Webpanel\Setting@create');
		    Route::put('/create','Webpanel\Setting@store');
		    Route::get('/{id}','Webpanel\Setting@edit')->where(['id'=>'[0-9]+']);
		    Route::post('/{id}','Webpanel\Setting@update')->where(['id'=>'[0-9]+']);
		    Route::get('/destroy/{id}','Webpanel\Setting@destroy')->where(['id'=>'[0-9]+']);
		    Route::get('/status/{id}','Webpanel\Setting@status')->where(['id'=>'[0-9]+']);
		    Route::post('/dragsort','Webpanel\Setting@dragsort')->where(['id'=>'[0-9]+']);
		});

	});
	

});