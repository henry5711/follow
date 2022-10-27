<?php

namespace App\Http\Controllers\post;

use Illuminate\Http\Request;
use App\Core\CrudController;
use App\Models\post;
use App\Models\seguidores;
use App\Models\User;
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

    public function postuser($id,Request $request)
    {
        $postus=post::where('user_id',$id)->with(['images'])->paginate($request->pag);
        foreach ($postus as $key) {
            $key->name_user=User::where('id',$key->user_id)->value('full_name');
            $key->photo_url=User::where('id',$key->user_id)->value('photo_url');
            $key->nickname=User::where('id',$key->user_id)->value('nick_name_user');
        }
        return ["list"=>$postus];
    }

    public function postseguidos($id,Request $request)
    {
        $seguidos=seguidores::where('user_id',$id)->get();

        $cole=collect();

        foreach ($seguidos as $key)
        {
           $ids=$seguidos->keyBy('follow_id')->keys();
           $cole=$cole->concat($ids);
        }

       $ids_usus=$cole->unique();


       $pos=post::whereIn('user_id',$ids_usus)->orderBy('fecha')->paginate($request->pag);
       foreach ($pos as $key) {
        $key->name_user=User::where('id',$key->user_id)->value('full_name');
        $key->photo_url=User::where('id',$key->user_id)->value('photo_url');
        $key->nickname=User::where('id',$key->user_id)->value('nick_name_user');
        }

        return $pos;
    }
}
