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

Route::get('/', 'HomeController@index')->name('start');

Auth::routes(['verify' => true]);

// users route
Route::middleware(['auth', 'verified'])->prefix('user')->group(function(){
    Route::post('/cart/{product}', 'OrderController@store')->name('add.to.cart');
    Route::get('/cart/{user}', 'OrderController@index')->name('cart');
    Route::patch('/cart/{order}/increase', 'OrderController@increaseProductOrderQuantity')->name('increase.quantity');
    Route::patch('/cart/{order}/decrease', 'OrderController@decreaseProductOrderQuantity')->name('decrease.quantity');
    Route::patch('/cart/{order}', 'OrderController@setProductOrderQuantity')->name('set.product.quantity');
    Route::post('/carts/{order}', 'OrderController@destroy')->name('remove.from.cart');
    Route::post('/pay/{order}', "PaystackController@pay")->middleware('password.confirm')->name('checkout');
    Route::post('/payment_success', "PaystackController@paymentSuccess")->name('payment.status');
    Route::get('/transaction', 'PaystackController@transaction')->name('transaction');
    Route::post('vue/payment_success', 'TransactionController@saveVueTransaction')->name('vue.save.transaction');
});
// email verification
Route::get('/verify', 'EmailVerifiedController@verify')->name('email.verify');

// product routes
Route::middleware(['auth', 'verified'])->get('/home', 'ProductController@index')->name('home');
Route::get('/products/{product}', 'ProductController@show')->name('display.product');
Route::get('/products/{category}/{subcategory}', 'ProductController@fetchSubcategoryProducts')->name('subcategory.products');
Route::get('/search', 'ProductController@search')->name('search');

// admin Routes
Route::name('admin.')->middleware(['auth', 'verified','isadmin'])->prefix('admin')->group(function () {
    Route::middleware('signed')->get('/', 'AdminController@page')->name('layout');
    Route::get('/users', 'AdminController@users')->name('users');
    Route::get('/user', 'AdminController@getUserConversation')->name('user');
    Route::post('/chat', 'AdminController@sendMessage')->name('chat');
});

// live chat route
Route::post('/chats/create', 'ChatsController@sendMessage')->name('chats.create');
Route::get('/chats', 'ChatsController@fetchChats')->name('chat');

Route::any('{anything}', 'AdminController@getUser')->where(['anything' => '[A-Za-z]+']);

