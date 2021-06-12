<?php

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




Route::get('', 'Webpanel\AuthController@getLogin');
Route::get('index', 'HomeController@index');
// Route::get('about', 'HomeController@about');
// Route::get('contact', 'HomeController@contact');
// Route::get('services', 'HomeController@services');
// Route::get('fields_of_specialization', 'HomeController@fields_of_specialization');
// Route::get('experience-detail/{id}', 'HomeController@experience_detail')->where(['id'=>'[0-9]+']);
// Route::get('our_experience', 'HomeController@our_experience');



// Backend
Route::get('webpanel/login','Webpanel\AuthController@getLogin');
Route::post('webpanel/login','Webpanel\AuthController@postLogin');
Route::get('webpanel/logout', 'Webpanel\AuthController@logOut');
Route::group(['middleware'=>['Webpanel']], function(){

	Route::prefix('webpanel')->group(function(){

		Route::get('/','Webpanel\HomeController@index');
		Route::get('/','Webpanel\HomeController@Chartjs');
		
		
	
		Route::prefix('trucktype')->group(function(){
			Route::get('/','Webpanel\TrucktypeController@index');
			Route::get('/search','Webpanel\TrucktypeController@search')->name('trucktype.search');
			Route::get('/create','Webpanel\TrucktypeController@create');
        	Route::put('/create','Webpanel\TrucktypeController@store');
			Route::get('/{id}','Webpanel\TrucktypeController@edit')->where(['id'=>'[0-9]+']);
			Route::post('/{id}','Webpanel\TrucktypeController@update')->where(['id'=>'[0-9]+']);
			Route::get('/destroy','Webpanel\TrucktypeController@destroy');
			Route::get('/{id}','Webpanel\TrucktypeController@copy')->where(['id'=>'[0-9]+']);
			Route::post('/{id}','Webpanel\TrucktypeController@clone')->where(['id'=>'[0-9]+']);
        	Route::post('/dragsort','Webpanel\TrucktypeController@dragsort');
			Route::get('/status/{id}','Webpanel\TrucktypeController@status')->where(['id'=>'[0-9]+']);
			Route::get('/{id}/create','Webpanel\TrucktypeController@createcopy');
		});

		Route::prefix('roundtrip')->group(function(){
			Route::get('/','Webpanel\RoundtripController@index');
			Route::get('/search','Webpanel\RoundtripController@search');
			Route::get('/create','Webpanel\RoundtripController@create');
        	Route::put('/create','Webpanel\RoundtripController@store');
			Route::get('/{id}','Webpanel\RoundtripController@edit')->where(['id'=>'[0-9]+']);
			Route::post('/{id}','Webpanel\RoundtripController@update')->where(['id'=>'[0-9]+']);
			Route::get('/destroy','Webpanel\RoundtripController@destroy');
        	Route::post('/dragsort','Webpanel\RoundtripController@dragsort');
			Route::get('/status/{id}','Webpanel\RoundtripController@status')->where(['id'=>'[0-9]+']);
			Route::get('/copy/{id}','Webpanel\RoundtripController@copy');
			Route::get('/copy/{id}/create','Webpanel\RoundtripController@createcopy');
		});

		Route::prefix('tsptype')->group(function(){
			Route::get('/','Webpanel\TsptypeController@index');
			Route::get('/create','Webpanel\TsptypeController@create');
			Route::get('/search','Webpanel\TsptypeController@search');
        	Route::put('/create','Webpanel\TsptypeController@store');
			Route::get('/{id}','Webpanel\TsptypeController@edit')->where(['id'=>'[0-9]+']);
			Route::post('/{id}','Webpanel\TsptypeController@update')->where(['id'=>'[0-9]+']);
			Route::get('/destroy','Webpanel\TsptypeController@destroy');
        	Route::post('/dragsort','Webpanel\TsptypeController@dragsort');
			Route::get('/status/{id}','Webpanel\TsptypeController@status')->where(['id'=>'[0-9]+']);
			Route::get('/copy/{id}','Webpanel\TsptypeController@copy');
			Route::get('/copy/{id}/create','Webpanel\TsptypeController@createcopy');
		

		});

		Route::prefix('hiringtype')->group(function(){
			Route::get('/','Webpanel\HiringtypeController@index');
			Route::get('/search','Webpanel\HiringtypeController@search');
			Route::get('/create','Webpanel\HiringtypeController@create');
        	Route::put('/create','Webpanel\HiringtypeController@store');
			Route::get('/{id}','Webpanel\HiringtypeController@edit')->where(['id'=>'[0-9]+']);
			Route::post('/{id}','Webpanel\HiringtypeController@update')->where(['id'=>'[0-9]+']);
			Route::get('/destroy','Webpanel\HiringtypeController@destroy');
			Route::get('/copy','Webpanel\HiringtypeController@copy');
        	Route::post('/dragsort','Webpanel\HiringtypeController@dragsort');
			Route::get('/status/{id}','Webpanel\HiringtypeController@status')->where(['id'=>'[0-9]+']);
			Route::get('/copy/{id}','Webpanel\HiringtypeController@copy');
			Route::get('/copy/{id}/create','Webpanel\HiringtypeController@createcopy');
		});

		Route::prefix('pjtype')->group(function(){
			Route::get('/','Webpanel\PjtypeController@index');
			Route::get('/search','Webpanel\PjtypeController@search');
			Route::get('/create','Webpanel\PjtypeController@create');
        	Route::put('/create','Webpanel\PjtypeController@store');
			Route::get('/{id}','Webpanel\PjtypeController@edit')->where(['id'=>'[0-9]+']);
			Route::post('/{id}','Webpanel\PjtypeController@update')->where(['id'=>'[0-9]+']);
			Route::get('/destroy','Webpanel\PjtypeController@destroy');
			Route::get('/copy','Webpanel\PjtypeController@copy');
        	Route::post('/dragsort','Webpanel\PjtypeController@dragsort');
			Route::get('/status/{id}','Webpanel\PjtypeController@status')->where(['id'=>'[0-9]+']);
			Route::get('/copy/{id}','Webpanel\PjtypeController@copy');
			Route::get('/copy/{id}/create','Webpanel\PjtypeController@createcopy');
		});

		
		Route::prefix('pjname')->group(function(){
			Route::get('/','Webpanel\PjnameController@index');
			Route::get('/search','Webpanel\PjnameController@search');
			Route::get('/create','Webpanel\PjnameController@create');
        	Route::put('/create','Webpanel\PjnameController@store');
			Route::get('/{id}','Webpanel\PjnameController@edit')->where(['id'=>'[0-9]+']);
			Route::post('/{id}','Webpanel\PjnameController@update')->where(['id'=>'[0-9]+']);
			Route::get('/destroy','Webpanel\PjnameController@destroy');
			Route::get('/copy','Webpanel\PjnameController@copy');
        	Route::post('/dragsort','Webpanel\PjnameController@dragsort');
			Route::get('/status/{id}','Webpanel\PjnameController@status')->where(['id'=>'[0-9]+']);
			Route::get('/copy/{id}','Webpanel\PjnameController@copy');
			Route::get('/copy/{id}/create','Webpanel\PjnameController@createcopy');
		});

		// Route::prefix('cusname')->group(function(){
		// 	Route::get('/','Webpanel\CusnameController@index');
		// 	Route::get('/create','Webpanel\CusnameController@create');
        // 	Route::put('/create','Webpanel\CusnameController@store');
		// 	Route::get('/{id}','Webpanel\CusnameController@edit')->where(['id'=>'[0-9]+']);
		// 	Route::post('/{id}','Webpanel\CusnameController@update')->where(['id'=>'[0-9]+']);
		// 	Route::get('/destroy','Webpanel\CusnameController@destroy');
		// 	Route::get('/copy','Webpanel\CusnameController@copy');
        // 	Route::post('/dragsort','Webpanel\CusnameController@dragsort');
		// 	Route::get('/status/{id}','Webpanel\CusnameController@status')->where(['id'=>'[0-9]+']);
		// 	Route::get('/copy/{id}','Webpanel\TrucktypeController@copy');
		// });

		// Route::prefix('pjdetail')->group(function(){
		// 	Route::get('/','Webpanel\PjdetailController@index');
		// 	Route::get('/create','Webpanel\PjdetailController@create');
        // 	Route::put('/create','Webpanel\PjdetailController@store');
		// 	Route::get('/{id}','Webpanel\PjdetailController@edit')->where(['id'=>'[0-9]+']);
		// 	Route::post('/{id}','Webpanel\PjdetailController@update')->where(['id'=>'[0-9]+']);
		// 	Route::get('/destroy','Webpanel\PjdetailController@destroy');
        // 	Route::post('/dragsort','Webpanel\PjdetailController@dragsort');
		// 	Route::get('/status/{id}','Webpanel\PjdetailController@status')->where(['id'=>'[0-9]+']);
		// 	Route::get('openings/duplicate/{id}', 'OpeningsController@duplicate');
		// 	Route::get('/copy/{id}','Webpanel\TrucktypeController@copy');
		// });

		Route::prefix('splname')->group(function(){
			Route::get('/','Webpanel\SplnameController@index');
			Route::get('/search','Webpanel\SplnameController@search');
			Route::get('/create','Webpanel\SplnameController@create');
        	Route::put('/create','Webpanel\SplnameController@store');
			Route::get('/{id}','Webpanel\SplnameController@edit')->where(['id'=>'[0-9]+']);
			Route::post('/{id}','Webpanel\SplnameController@update')->where(['id'=>'[0-9]+']);
			Route::get('/destroy','Webpanel\SplnameController@destroy');
			Route::get('/copy','Webpanel\SplnameController@copy');
        	Route::post('/dragsort','Webpanel\SplnameController@dragsort');
			Route::get('/status/{id}','Webpanel\SplnameController@status')->where(['id'=>'[0-9]+']);
			Route::get('/copy/{id}','Webpanel\SplnameController@copy');
			Route::get('/copy/{id}/create','Webpanel\SplnameController@createcopy');
		});

		Route::prefix('truckplan')->group(function(){
			Route::get('/','Webpanel\TruckplanController@index');
			Route::get('/search','Webpanel\TruckplanController@search');
			Route::get('/searchdate','Webpanel\TruckplanController@searchdate');
			Route::get('/searchbox','Webpanel\TruckplanController@searchbox');
			Route::get('/create','Webpanel\TruckplanController@create');
        	Route::put('/create','Webpanel\TruckplanController@store');
			Route::get('/{id}','Webpanel\TruckplanController@edit')->where(['id'=>'[0-9]+']);
			//Route::post('/{id}','Webpanel\TruckplanController@update')->where(['id'=>'[0-9]+']);
			Route::match(['put', 'patch'], '/{id}','Webpanel\TruckplanController@update')->where(['id'=>'[0-9]+']);
			Route::get('/destroy','Webpanel\TruckplanController@destroy');
			Route::get('/copy/{id}','Webpanel\TruckplanController@copy');
			Route::get('/copy/{id}/create','Webpanel\TruckplanController@createcopy');
        	Route::post('/dragsort','Webpanel\TruckplanController@dragsort');
			Route::get('/status/{id}','Webpanel\TruckplanController@status')->where(['id'=>'[0-9]+']);
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