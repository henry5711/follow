<?php

use App\Http\Controllers\post\postController;
use App\Http\Controllers\seguidores\seguidoresController;
use App\Http\Controllers\reaction\reactionController;
use App\Http\Controllers\comments\commentsController;
use App\Http\Controllers\Preview\PreviwController;
use App\Http\Controllers\type_reaction\type_reactionController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();

});


Route::get('/', function () {

    return response()->json([
        //"version" => Route::app->version(),
        "time"   => Carbon::now()->toDateTime(),
        "php"    =>  phpversion()
    ]);
});


/** routes para post **/

Route::get('posts', [postController::class,'_index']);
Route::get('posts/{id}', [postController::class,'_show']);
Route::get('posts/usu/{id}', [postController::class,'postuser']);
Route::get('posts/index/user/{id}', [postController::class,'postseguidos']);
Route::post('posts', [postController::class,'_store']);
Route::put('posts/{id}', [postController::class,'_update']);
Route::delete('posts/{id}', [postController::class,'_delete']);

/** routes para comments **/

Route::get('comments', [commentsController::class,'_index']);
Route::get('comments/{id}', [commentsController::class,'_show']);
Route::get('comments/post/{id}', [commentsController::class,'compost']);
Route::post('comments', [commentsController::class,'_store']);
Route::put('comments/{id}', [commentsController::class,'_update']);
Route::delete('comments/{id}', [commentsController::class,'_delete']);

/** routes para type_reaction **/

Route::get('type_reactions', [type_reactionController::class,'_index']);
Route::get('type_reactions/{id}', [type_reactionController::class,'show']);
Route::post('type_reactions', [type_reactionController::class,'store']);
Route::post('type_reactions/{id}', [type_reactionController::class,'update']);
Route::delete('type_reactions/{id}', [type_reactionController::class,'destroy']);

/** routes para reaction **/

Route::get('reactions', [reactionController::class,'_index']);
Route::get('reactions/{id}', [reactionController::class,'_show']);
Route::get('reactions/post/{id}', [reactionController::class,'reacpost']);
Route::post('reactions', [reactionController::class,'store']);
Route::put('reactions/{id}', [reactionController::class,'_update']);
Route::delete('reactions/{id}', [reactionController::class,'_delete']);

/** routes para seguidores **/

Route::get('is_follow/follow/user', [seguidoresController::class,'follow']);
Route::get('seguidores', [seguidoresController::class,'_index']);
Route::get('seguidores/{id}', [seguidoresController::class,'_show']);
Route::get('list/users/profiles', [seguidoresController::class,'listusuario']);
Route::get('total/follow/{id}', [seguidoresController::class,'totalseguidos']);
Route::get('seguidores/usu/{id}', [seguidoresController::class,'seguidos']);
Route::get('seguidos/profile/{id}', [seguidoresController::class,'seguidores']);
Route::post('seguidores', [seguidoresController::class,'_store']);
Route::put('seguidores/{id}', [seguidoresController::class,'_update']);
Route::delete('seguidores/{id}', [seguidoresController::class,'_delete']);
Route::post('unfollow/user', [seguidoresController::class,'unfollow']);



/** routes para preview **/

Route::get('preview', [PreviwController::class,'index']);
Route::get('preview/{id}', [PreviwController::class,'show']);
Route::post('preview',[PreviwController::class,'store']);
Route::put('preview/{id}',[PreviwController::class,'update']);
Route::delete('preview/{id}', [PreviwController::class,'destroy']);

