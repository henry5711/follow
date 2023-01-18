<?php

namespace App\Http\Controllers\Preview;

use App\Http\Controllers\Controller;
use App\Models\previw;
use App\Http\Requests\StorepreviwRequest;
use App\Http\Requests\UpdatepreviwRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PreviwController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            DB::beginTransaction();
            $client = previw::get();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'data' => [
                    'code'   => $e->getCode(),
                    'title'  => [__('messages.previwController.index.index.internal_error')],
                    'errors' => $e->getMessage()
                ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if (isset($request->pag)) {
            return response()->json([
                "message"       => "previws",
                "response"      => $client->paginate($request->pag),
            ]);
        } else {
            return response()->json([
                "message"       => "previws",
                "response"      => $client,
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorepreviwRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $id =  $this->createPreview($request);

            $response = previw::where('id', $id)->first();

            DB::commit();
        } catch (\Exception $e) {

            DB::rollBack();
            return response()->json([
                'data' => [
                    'code'   => $e->getCode(),
                    'title'  => [__('messages.previw.store.store.internal_error')],
                    'errors' => $e->getMessage(),
                ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            "message"       => "Se registro una nueva previw",
            "response"      => $response,
        ]);
    }

    protected function createPreview($request)
    {

        $client = new previw();
        $path = Storage::putFile('public/images', $request->url_previw);
        $cont = env('APP_URL') . Storage::url($path);
        $request->url_previw = $cont;


        $client->post_id = $request->post_id;
        $client->save();
        return  $client->id;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\previw  $previw
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            DB::beginTransaction();

            $client = previw::where('id', $id)->get();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'data' => [
                    'code'   => $e->getCode(),
                    'title'  => [__('messages.previw.show.show.internal_error')],
                    'errors' => $e->getMessage()
                ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            "message"       => "detalle de previw",
            "response"      => $client,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatepreviwRequest  $request
     * @param  \App\Models\previw  $previw
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $clientValide = previw::where('id', '=', $id)->first();
        if (!$clientValide) {
            return response()->json([
                "errors" => [
                    "message"       => "No es posible editar el previw",
                ]
            ], 422);
        }
        try {
            DB::beginTransaction();

            $client = previw::findOrFail($id);
            $this->updatePreviw($client, $request);

            $response = previw::where('id', $id)->first();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'data' => [
                    'code'   => $e->getCode(),
                    'title'  => [__('messages.previw.update.update.internal_error')],
                    'errors' => $e->getMessage(),
                ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            "message"       => "previw actulizada",
            "response"      => $response,
        ]);
    }

    protected function updatePreviw($client, $request)
    {

        $client->post_id  = $request->post_id  ? $request->post_id  :  $client->post_id;
        $client->active  = $request->active  ? $request->active  : $client->active;
        if (isset($request->url_previw)) {
            foreach ($request->url_previw as $imagen) {
                $path = Storage::putFile('public/images', $imagen);
                $cont = env('APP_URL') . Storage::url($path);
                $request['url_previw'] = $cont;
            }
        }
        $client->updated_at  = Carbon::now();
        $client->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\previw  $previw
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $client = previw::where('id', $id)->first();
            if ($client) {
                $client->delete();
            } else {
                return response()->json([
                    "errors" => [
                        "message"       =>  ["no es posible realizar eliminar esta preview"],
                    ]
                ], 422);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'data' => [
                    'code'   => $e->getCode(),
                    'title'  => [__('messages.preview.delete.delete.internal_error')],
                    'errors' => $e->getMessage(),
                ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json([
            "message"       => "preview Eliminada",
        ]);
    }
}
