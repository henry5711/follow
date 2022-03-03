<?php

namespace App\Http\Controllers\reaction;

use Illuminate\Http\Request;
use App\Core\CrudController;
use App\Models\reaction;
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
        $post=reaction::where('fk_post_id',$id)->get();
        return ["list"=>$post,"total"=>count($post)];
    }
}