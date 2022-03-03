<?php

namespace App\Http\Controllers\seguidores;

use Illuminate\Http\Request;
use App\Core\CrudController;
use App\Models\seguidores;
use App\Services\seguidores\seguidoresService;
/** @property seguidoresService $service */
class seguidoresController extends CrudController
{
    public function __construct(seguidoresService $service)
    {
        parent::__construct($service);
    }

    public function seguidos($id)
    {
      $seguidos=seguidores::where('user_id',$id)->get();
      return ["list"=>$seguidos,"total"=>count($seguidos)];

    }

    public function seguidores($id)
    {
        $seguidos=seguidores::where('follow_id',$id)->get();
        return ["list"=>$seguidos,"total"=>count($seguidos)];
    }
}