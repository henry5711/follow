<?php
/**
 * Created by PhpStorm.
 * User: zippyttech
 */

namespace App\Services\post;


use App\Core\CrudService;
use App\Core\ImageService;
use App\Repositories\post\postRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

/** @property postRepository $repository */
class postService extends CrudService
{

    protected $name = "post";
    protected $namePlural = "posts";

    public function __construct(postRepository $repository)
    {
        parent::__construct($repository);
    }

    public function _store(Request $request)
    {

        if(isset($request->contenido)){

            foreach ($request->contenido as $image){
                //dd($image);
                $img[] = (new ImageService())->image($image);
            }
        }

        if(isset($img)){
            $request['contenido'] = json_encode($img);
        }
        $request['status']='Activa';
        $request['fecha']=Carbon::now();

        return parent::_store($request);
    }

}
