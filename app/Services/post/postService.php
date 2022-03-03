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
        $img= new ImageService();
        $e=$img->images($request->contenido);
        $request['contenido']=$e;
        $request['status']='Activa';
        $request['fecha']=Carbon::now();

        return parent::_store($request);
    }

}