<?php
namespace Routes;
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

Route::get('/', function () {
    return view('home/home');
});

Route::get('/api', function () {
    return view('api');
});

Route::group(['prefix' => 'home'], function(){
   Route::get('goodscategorylist', 'HomeController@Goodscategorylist');
   Route::get('goodslist', 'HomeController@goodslist');
   Route::get('orderlist', 'HomeController@orderlist');
   Route::get('collectionlist', 'HomeController@collectionlist');
   Route::post('sellerregister', 'HomeController@sellerregister');
});

Route::get('/admin', function (){

});
