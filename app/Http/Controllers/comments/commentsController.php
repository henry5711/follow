<?php

namespace App\Http\Controllers\comments;

use Illuminate\Http\Request;
use App\Core\CrudController;
use App\Models\comments;
use App\Models\User;
use App\Services\comments\commentsService;
/** @property commentsService $service */
class commentsController extends CrudController
{
    public function __construct(commentsService $service)
    {
        parent::__construct($service);
    }

    public function compost($id)
    {
        $post=comments::where('fk_post_id',$id)->get();
        foreach ($post as $key) {
            $key->name_user = User::where('id', $key->usu_id)->value('full_name');
            $key->photo_url = User::where('id', $key->usu_id)->value('photo_url');
            $key->nickname = User::where('id', $key->usu_id)->value('nick_name_user');
        }
        return ["list"=>$post,"total"=>count($post)];
    }
}
