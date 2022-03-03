<?php

namespace App\Http\Controllers\comments;

use Illuminate\Http\Request;
use App\Core\CrudController;
use App\Models\comments;
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
        return ["list"=>$post,"total"=>count($post)];
    }
}