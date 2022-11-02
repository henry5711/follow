<?php

namespace App\Http\Controllers\reaction;

use Illuminate\Http\Request;
use App\Core\CrudController;
use App\Models\reaction;
use App\Models\User;
use App\Services\reaction\reactionService;
/** @property reactionService $service */
class reactionController extends CrudController
{
    public function __construct(reactionService $service)
    {
        parent::__construct($service);
    }

    public function reacpost($id)
    {
        $post=reaction::with('type_reaction')->where('fk_post_id',$id)->get();
        foreach ($post as $key) {
            $key->name_user=User::where('id',$key->user_id)->value('full_name');
             $key->photo_url=User::where('id',$key->user_id)->value('photo_url');
             $key->nickname=User::where('id',$key->user_id)->value('nick_name_user');
           }
        return ["list"=>$post,"total"=>count($post)];
    }
}
