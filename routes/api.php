<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PassportAuthController;

Route::middleware(['auth:api', 'scopes:get-email'])->get('/user', function (Request $request) {
    return $request->user()->makeVisible([
        'email',
        'token'
    ]);

});


Route::middleware(['auth:api', 'scopes:create-posts'])->post('/posts/new', function (Request $request) {

    return $request->user()->posts()->create($request->only(['title', 'content']));

});

Route::get('posts', function (Request $request) {


    return \App\Models\Post::with('user')->get();


});

Route::middleware('auth:api')->get('teste', function (Request $request) {



});




//route de api register, login
Route::post('register', [PassportAuthController::class, 'register']);
Route::post('login', [PassportAuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {


    Route::get('profile', [PassportAuthController::class, 'profile']);
    Route::get('logout', [PassportAuthController::class, 'logout']);


});


//route de produit ou autre ?
