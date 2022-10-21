<?php

namespace App\Http\Controllers\type_reaction;

use Illuminate\Http\Request;
use App\Core\CrudController;
use App\Models\type_reaction;
use App\Services\type_reaction\type_reactionService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/** @property type_reactionService $service */
class type_reactionController extends CrudController
{
    public function __construct(type_reactionService $service)
    {
        parent::__construct($service);
    }

    public function store(Request $request){
        try {
            DB::beginTransaction();

            $id =  $this->createLottery($request);

            $response = type_reaction::where('id', $id)->first();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'data' => [
                    'code'   => $e->getCode(),
                    'title'  => [__('Erron al guardar tipo de reaccion')],
                    'errors' => $e->getMessage(),
                ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json(array(
            'success' => true,
            'message' => 'tipo de reaccion creada',
            'value'   => $response,
        ));
    }

    protected function createTypeReaction($request)
    {
        $type_reaction = new type_reaction();
        $type_reaction->name= $request->name;
        $path = Storage::putFile('public/images',$request->icon );
        $cont=env('APP_URL').Storage::url($path);
        $type_reaction->icon = $cont;
        $type_reaction->save();

        return $type_reaction->id;
    }

    public function show($id)
    {
        try {
            DB::beginTransaction();
            $response = type_reaction::where('id',$id)->first();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'data' => [
                    'code'   => $e->getCode(),
                    'title'  => [__('error en show')],
                    'errors' => $e->getMessage(),
                ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return ["list"=>$response];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatelotteryRequest  $request
     * @param  \App\Models\lottery  $lottery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $type = type_reaction::where('id', '=', $id)->first();
        if (!$type) {
            return response()->json([
                "errors" => [
                    "message" => "No existe tipo de reaacion",
                ]
            ], 422);
        }

        //$response;
        try {
            DB::beginTransaction();

            $type = type_reaction::findOrFail($id);
            $this->updateTypeReaction($type, $request);

            $response = type_reaction::where('id', $id)->first();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'data' => [
                    'code'   => $e->getCode(),
                    'title'  => [__('Error al editar')],
                    'errors' => $e->getMessage(),
                ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json(array(
            'success' => true,
            'message' => 'tipo de reaccion editada',
            'value'   => $response,
        ));
    }

    protected function updateTypeReaction($type, $request)
    {
        $type->name= $request->name ?$request->name:$type->name;
        if($request->icon!=$type->icon){
            $path = Storage::putFile('public/images',$request->icon);
            $cont=env('APP_URL').Storage::url($path);
            $type->icon = $cont;
        }
        $type->update();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\lottery  $lottery
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            DB::beginTransaction();

            $type= type_reaction::findOrFail($id);
               $type->delete();
            DB::commit();
            }catch(\Exception $e){
            DB::rollBack();
            return response()->json([
                'data' => [
                    'code'   => $e->getCode(),
                    'title'  => [__('fallo al eliminar typo de reaccion')],
                    'errors' => $e->getMessage(),
                ]
              ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
            return response()->json([
              "message"       => "tipo de reaccion eliminada",
             ]);
    }
}
