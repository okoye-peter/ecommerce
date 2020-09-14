<?php

use Illuminate\Support\Facades\Http;
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

Auth::routes(['verify' => true]);

// users route
Route::middleware(['auth', 'verified'])->prefix('/user')->group(function(){
    Route::get('/cart/{user}', 'CartController@view')->name('cart');
    Route::post('/cart/{product}', 'VueAddToCartController@addToCart')->name('add.to.cart');
    Route::patch('/cart/{product}/increase', 'VueAddToCartController@increaseProductOrderQuantity')->name('increase.quantity');
    Route::patch('/cart/{product}/decrease', 'VueAddToCartController@decreaseProductOrderQuantity')->name('decrease.quantity');
    Route::delete('/carts/{order}', 'CartController@removeFromCart')->name('remove.from.cart');
    Route::post('/pay/{order}', "PaystackController@pay")->middleware('password.confirm')->name('checkout');
    Route::post('/payment_success', "PaystackController@paymentSuccess")->name('payment.status');
    Route::get('/transaction', 'PaystackController@transaction')->name('transaction');
});
// email verification
Route::get('/verify', 'EmailVerifiedController@verify')->name('email.verify');

// product routes
Route::middleware(['auth', 'verified'])->get('/home', 'ProductController@index')->name('home');
Route::get('/products/{product}', 'ProductController@show')->name('display.product');
Route::get('/products/{category}/{subcategory}', 'ProductController@fetchSubcategoryProducts')->name('subcategory.products');
Route::get('/search', 'ProductController@search')->name('search');

// live chat route
Route::post('/chats/create', 'ChatsController@sendMessage')->name('chats.create');
Route::get('/chats', 'ChatsController@fetchChats');