<?php
/**
 * Created by PhpStorm.
 * User: zippyttech
 */

namespace App\Repositories\post;

use App\Core\CrudRepository;
use App\Models\post;
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
      $post=post::with('images')->paginate($request->pag);
      foreach ($post as $key) {
        $key->name_user=User::where('id',$key->user_id)->value('full_name');
        $key->photo_url=User::where('id',$key->user_id)->value('photo_url');
        $key->nickname=User::where('id',$key->user_id)->value('nick_name_user');

      }
      return ["list"=>$post,"time_zone"=>$request->cuenta['time_zone']];
    }

}
