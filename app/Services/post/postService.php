<?php
/**
 * Created by PhpStorm.
 * User: zippyttech
 */

namespace App\Services\post;


use App\Core\CrudService;
use App\Core\ImageService;
use App\Models\images;
use App\Repositories\post\postRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
       // dd($request->contenido);
        $request['status']='Activa';
        $request['fecha']=Carbon::now('UTC');

        $obj=$this->repository->_store($request);


        if(isset($request->contenido)){
            foreach ($request->contenido as $imagen) {
                $path = Storage::putFile('public/images', $imagen);
                $cont=env('APP_URL').Storage::url($path);
                $contenido['contenido']=$cont;
                $obj->images()->create($contenido);
            }
        }


        return response()->json([
            "status" => 201,
           $obj],
            201);


    }

}
