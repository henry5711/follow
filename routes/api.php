<?php

/*
|--------------------------------------------------------------------------
| Application $router->|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use Carbon\Carbon;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Router;

/*
* ALL THE METHODS WITH A _ BEFORE THOSE NAME GOES DIRECTLY TO REPOSITORY THROUGH TATUCO METHODS
* TODOS LOS METODOS CON UN _ EN EL PREFIJO DEL NOMBRE VAN DIRECTAMENTE AL REPOSITORIO POR MEDIO DE LOS METODOS DE TATUCO
*/

$router->group(['prefix' => 'api'], function (Router $router) {

    $router->get('/', function () use ($router) {

        return response()->json([
            "version"=> $router->app->version(),
            "time"   => Carbon::now()->toDateTime(),
            "php"    =>  phpversion()
        ]);
    });
    
    /*
     *routes with report prefix
     * rutas con el prefijo report
    */
    $router->group(['prefix' => 'report'], function () use ($router) {
        $router->post('/automatic', 'ReportController@automatic');

    });
    
    $router->group(['middleware' => ['auth']],function () use ($router) {

       
   


    $router->group(['middleware' => ['authorize']],function () use ($router) {

        $router->group(['namespace' => '\Rap2hpoutre\LaravelLogViewer'], function() use ($router) {
            $router->get('logs', 'LogViewerController@index');
        });

    });

});

  /** routes para post **/ 
 
$router->get('posts', 'post\postController@_index');
$router->get('posts/{id}', 'post\postController@_show');
$router->get('posts/usu/{id}', 'post\postController@postuser');
$router->get('posts/index/user/{id}', 'post\postController@postseguidos');
$router->post('posts', 'post\postController@_store');
$router->put('posts/{id}', 'post\postController@_update');
$router->delete('posts/{id}', 'post\postController@_delete');
 
/** routes para comments **/ 
 
$router->get('comments', 'comments\commentsController@_index');
$router->get('comments/{id}', 'comments\commentsController@_show');
$router->get('comments/post/{id}', 'comments\commentsController@compost');
$router->post('comments', 'comments\commentsController@_store');
$router->put('comments/{id}', 'comments\commentsController@_update');
$router->delete('comments/{id}', 'comments\commentsController@_delete');
 
/** routes para type_reaction **/ 
 
$router->get('type_reactions', 'type_reaction\type_reactionController@_index');
$router->get('type_reactions/{id}', 'type_reaction\type_reactionController@_show');
$router->post('type_reactions', 'type_reaction\type_reactionController@_store');
$router->put('type_reactions/{id}', 'type_reaction\type_reactionController@_update');
$router->delete('type_reactions/{id}', 'type_reaction\type_reactionController@_delete');
 
/** routes para reaction **/ 
 
$router->get('reactions', 'reaction\reactionController@_index');
$router->get('reactions/{id}', 'reaction\reactionController@_show');
$router->get('reactions/post/{id}', 'reaction\reactionController@reacpost');
$router->post('reactions', 'reaction\reactionController@_store');
$router->put('reactions/{id}', 'reaction\reactionController@_update');
$router->delete('reactions/{id}', 'reaction\reactionController@_delete'); 

/** routes para seguidores **/ 
 
$router->get('seguidores', 'seguidores\seguidoresController@_index');
$router->get('seguidores/{id}', 'seguidores\seguidoresController@_show');
$router->get('seguidores/usu/{id}', 'seguidores\seguidoresController@seguidos');
$router->get('seguidos/profile/{id}', 'seguidores\seguidoresController@seguidores');
$router->post('seguidores', 'seguidores\seguidoresController@_store');
$router->put('seguidores/{id}', 'seguidores\seguidoresController@_update');
$router->delete('seguidores/{id}', 'seguidores\seguidoresController@_destroy');
    
 

    
});

 
 
 
 

 

