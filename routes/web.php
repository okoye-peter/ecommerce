<?php

use Illuminate\Support\Facades\Http;
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

Route::get('/', 'HomeController@index')->name('start');

Auth::routes(); 

Route::get('/orders/{user}', 'CartController@view')->name('cart');
Route::get('/home', 'HomeController@index')->name('home');
Route::post('/add/{product}', 'VueAddToCartController@addToCart')->name('add.to.cart');
Route::post('/orders/increase/{product}', 'VueAddToCartController@increaseProductOrderQuantity')->name('increase.quantity');
Route::post('/orders/decrease/{product}', 'VueAddToCartController@decreaseProductOrderQuantity')->name('decrease.quantity');
Route::get('/carts/remove/{order}', 'CartController@removeFromCart')->name('remove.from.cart');
Route::get('/products/{product}', 'ProductController@show')->name('display.product');
Route::get('/products/{category}/{subcategory}', 'ProductController@fetchSubcategoryProducts')->name('subcategory.products');
Route::get('/search', 'ProductController@search')->name('search');
Route::post('/pay/{id}', "PaystackController@pay")->name('checkout');
Route::post('/payment_success', "PaystackController@paymentSuccess");
Route::post('/test', function(){
    $response = Http::post("http://localhost/video_upload/classes/connect/test.php",[
       "name" => request('name'),
       "username" => request('username'),
       "password" => request('password'),
       "gender" => request('gender')
    ]);
    dd($response->json());
});