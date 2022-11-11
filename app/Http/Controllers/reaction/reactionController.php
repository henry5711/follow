<?php

namespace App\Http\Controllers\reaction;

use Illuminate\Http\Request;
use App\Core\CrudController;
use App\Models\reaction;
use App\Models\User;
use App\Services\reaction\reactionService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

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

    public function store(Request $request){
        try {
            DB::beginTransaction();

            $id =  $this->createReaction($request);

            $response = reaction::where('id', $id)->with('type_reaction')->first();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'data' => [
                    'code'   => $e->getCode(),
                    'title'  => [__('Erron al guardar reaccion')],
                    'errors' => $e->getMessage(),
                ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json(array(
            'success' => true,
            'message' => 'reaccion creada',
            'value'   => $response,
        ));
    }

    protected function createReaction($request)
    {
        $reaction = new reaction();
        $reaction->fk_type_rea= $request->fk_type_rea;
        $reaction->fk_post_id = $request->fk_post_id;
        $reaction->usu_id = $request->usu_id;
        $reaction->save();

        return $reaction->id;
    }
}
