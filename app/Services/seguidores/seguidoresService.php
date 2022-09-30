<?php
/**
 * Created by PhpStorm.
 * User: zippyttech
 */

namespace App\Services\seguidores;


use App\Core\CrudService;
use App\Models\seguidores;
use App\Repositories\seguidores\seguidoresRepository;
use Illuminate\Http\Request;

/** @property seguidoresRepository $repository */
class seguidoresService extends CrudService
{

    protected $name = "seguidores";
    protected $namePlural = "seguidores";

    public function __construct(seguidoresRepository $repository)
    {
        parent::__construct($repository);
    }

    public function _store(Request $request)
    {
        $verifi=seguidores::where('user_id',$request->user_id)->where('follow_id',$request->follow_id)->first();
        if(isset($verifi)){
            return response()->json(['status'=>400,'message'=>'ya estas siguendo a este usuario'],400);
        }
    }

}
