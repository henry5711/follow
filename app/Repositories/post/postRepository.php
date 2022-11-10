<?php

/**
 * Created by PhpStorm.
 * User: zippyttech
 */

namespace App\Repositories\post;

use App\Core\CrudRepository;
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
        $post = post::with(['images', 'reaction.type_reaction'])->orderBy('id', 'desc')->paginate($request->pag);
        foreach ($post as $key) {
            $key->name_user = User::where('id', $key->user_id)->value('full_name');
            $key->photo_url = User::where('id', $key->user_id)->value('photo_url');
            $key->nickname = User::where('id', $key->user_id)->value('nick_name_user');
            $key->total_reactions = reaction::where('fk_post_id', $key->id)->count();
            $reaction = reaction::where('fk_post_id', $key->id)
            ->where('usu_id',$request->user)->get();
            if (count($reaction) > 0) {
                $key->reactionUserPost = true;
                $key->reactionUser=$reaction;

            } else {
                $key->reactionUserPost = false;
            }
        }
        return ["list" => $post];
    }
}
