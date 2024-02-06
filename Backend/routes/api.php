<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
// Unuthenticated Routes
Route::middleware('guest')->group( function() {
    Route::get('/mail', function () {
        $data = ["userName" => "Yusuf Muhammed", "companyName" => "luftborn"];
     
        return new App\Mail\Ads($data);
    });
   Route::get('/',fn() => "Welcome to our api \n This Api is designed for luftborn task \n Thanks for watching");
    
   // Auth Routes
   Route::post('/register',[UserController::class,'store']);
   Route::post('/login', [UserController::class,'login']);
   Route::resource("users",UserController::class)->only(["show","index"]);
   // Post Routes    
   Route::resource("posts",PostController::class)->only(["index","show"]);
    // Category Routes    
    Route::resource("categories",CategoryController::class)->only(["index","show"]);
});

// Authenticated Routes
Route::middleware('auth:sanctum')->group( function() {
    // Auth Routes
    Route::post('/logout', [UserController::class,'logout']);
    Route::get('/auth', [UserController::class,'auth']);
    Route::resource('users',UserController::class)->except(["show","index",'login','store']);

    // Post Routes
    Route::resource("posts",PostController::class)->except(["index","show"]);
});
