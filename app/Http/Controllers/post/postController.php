<?php

namespace App\Http\Controllers\post;

use Illuminate\Http\Request;
use App\Core\CrudController;
use App\Models\post;
use App\Models\seguidores;
use App\Services\post\postService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/** @property postService $service */
class postController extends CrudController
{
    public function __construct(postService $service)
    {
        parent::__construct($service);
    }

    public function postuser($id)
    {
        $postus=post::where('user_id',$id)->get();
        return ["list"=>$postus,"total"=>count($postus)];
    }

    public function postseguidos($id)
    {
        $seguidos=seguidores::where('user_id',$id)->get();

        $cole=collect();

        foreach ($seguidos as $key)
        {
           $ids=$seguidos->keyBy('follow_id')->keys();
           $cole=$cole->concat($ids);
        }

       $ids_usus=$cole->unique();
      
      
       $pos=post::whereIn('user_id',$ids_usus)->orderBy('fecha')->get();

        return $pos;
    }
}