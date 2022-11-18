<?php

namespace App\Http\Controllers\post;

use Illuminate\Http\Request;
use App\Core\CrudController;
use App\Models\comments;
use App\Models\post;
use App\Models\reaction;
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
        $postus=post::where('user_id',$id)->with(['images'])->orderBy('id','asc')->paginate($request->pag);
        foreach ($postus as $key) {
            $key->name_user=User::where('id',$key->user_id)->value('full_name');
            $key->photo_url=User::where('id',$key->user_id)->value('photo_url');
            $key->nickname=User::where('id',$key->user_id)->value('nick_name_user');
            $key->total_reactions=reaction::where('fk_post_id',$key->id)->count();
            $key->total_comments = comments::where('fk_post_id', $key->id)->count();
            $reaction = reaction::where('fk_post_id', $key->id)
            ->where('usu_id',$request->user)->with('type_reaction')->count();
            //$comments = comments::where('fk_post_id', $key->id)
            //->where('user_id', $request->user)->get();
            if ($reaction > 0) {
                $key->reactionUserPost = true;
                $key->reactionUser = $reaction;
            } else {
                $key->reactionUserPost = false;
            }
            /*if (count($comments) > 0) {
                $key->commentsUserPost = true;
                $key->commentsUser = $comments;
                $key->nicknameUser= User::where('id', $request->user)->value('nick_name_user');
                $key->photoUser = User::where('id', $request->user)->value('photo_url');
            } else {
                $key->commentsUserPost = false;
            }*/

            if(count($key->commentsLimit)>0){
              foreach ($key->commentsLimit as $comment) {
                $comment['name_user'] = User::where('id', $comment->user_id)->value('full_name');
                $comment['photo_url'] = User::where('id', $comment->user_id)->value('photo_url');
                $comment['nickname ']= User::where('id', $comment->user_id)->value('nick_name_user');
              }
            }

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
        $key->total_reactions=reaction::where('fk_post_id',$key->id)->count();

        }

        return $pos;
    }
}
