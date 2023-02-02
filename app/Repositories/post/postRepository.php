<?php

/**
 * Created by PhpStorm.
 * User: zippyttech
 */

namespace App\Repositories\post;

use App\Core\CrudRepository;
use App\Models\comments;
use App\Models\Paymet;
use App\Models\post;
use App\Models\reaction;
use App\Models\User;

/** @property post $model */
class postRepository extends CrudRepository
{

    public function __construct(post $model)
    {
        parent::__construct($model);
    }

    public function _index($request = null, $user = null)
    {
        $post = post::with(['images', 'reaction.type_reaction', 'commentsLimit','previw'])->orderBy('id', 'desc')->paginate($request->pag);
        foreach ($post as $key) {
            $key->name_user = User::where('id', $key->user_id)->value('full_name');
            $key->photo_url = User::where('id', $key->user_id)->value('photo_url');
            $key->nickname = User::where('id', $key->user_id)->value('nick_name_user');
            $key->total_reactions = reaction::where('fk_post_id', $key->id)->count();
            $key->total_comments = comments::where('fk_post_id', $key->id)->count();
            $reaction = reaction::where('fk_post_id', $key->id)
                ->where('usu_id', $request->user)->with('type_reaction')->get();

            $pay=Paymet::where('user_id',$user)->where('post_id',$key->id)->value('pay');
            /*$comments = comments::where('fk_post_id', $key->id)
                ->where('user_id', $request->user)->get();*/

            if (count($reaction) > 0) {
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
        return ["list" => $post];
    }
}
