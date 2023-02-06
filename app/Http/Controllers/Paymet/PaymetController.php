<?php

namespace App\Http\Controllers\Paymet;

use App\Http\Controllers\Controller;
use App\Models\Paymet;
use App\Http\Requests\StorePaymetRequest;
use App\Http\Requests\UpdatePaymetRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class PaymetController extends Controller
{

    public function index(Request $request)
    {
        try {
            DB::beginTransaction();
            $client = Paymet::get();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'data' => [
                    'code'   => $e->getCode(),
                    'title'  => [__('messages.paymetController.index.index.internal_error')],
                    'errors' => $e->getMessage()
                ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if (isset($request->pag)) {
            return response()->json([
                "message"       => "paymets post",
                "response"      => $client->paginate($request->pag),
            ]);
        } else {
            return response()->json([
                "message"       => "paymets post",
                "response"      => $client,
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *

     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $id =  $this->createPay($request);

            $response = Paymet::where('id', $id)->first();

            DB::commit();
        } catch (\Exception $e) {

            DB::rollBack();
            return response()->json([
                'data' => [
                    'code'   => $e->getCode(),
                    'title'  => [__('messages.paymet.store.store.internal_error')],
                    'errors' => $e->getMessage(),
                ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            "message"       => "Se registro un nuevo pago",
            "response"      => $response,
        ]);
    }

    protected function createPay($request)
    {

        $client = new Paymet();
        $client->post_id = $request->post_id;
        $client->user_id = $request->user_id;
        $client->code= $request->code;
        $client->pay= false;
        $client->save();


        return  $client->id;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\paymet  $previw
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            DB::beginTransaction();

            $client = Paymet::where('id', $id)->get();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'data' => [
                    'code'   => $e->getCode(),
                    'title'  => [__('messages.paymet.show.show.internal_error')],
                    'errors' => $e->getMessage()
                ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            "message"       => "detalle de pay",
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
        $clientValide = Paymet::where('id', '=', $id)->first();
        if (!$clientValide) {
            return response()->json([
                "errors" => [
                    "message"       => "No es posible editar el pago",
                ]
            ], 422);
        }
        try {
            DB::beginTransaction();

            $client = Paymet::findOrFail($id);
            $this->updatePay($client, $request);

            $response = Paymet::where('id', $id)->first();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'data' => [
                    'code'   => $e->getCode(),
                    'title'  => [__('messages.pay.update.update.internal_error')],
                    'errors' => $e->getMessage(),
                ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            "message"       => "pago actulizado",
            "response"      => $response,
        ]);
    }

    protected function updatePay($client, $request)
    {

        $client->post_id  = $request->post_id  ? $request->post_id  :  $client->post_id;
        $client->user_id  = $request->user_id  ? $request->user_id  : $client->user_id;
        $client->code     = $request->code     ? $request->code      : $client->code;
        $client->pay      = $request->pay     ? $request->pay      : $client->pay;
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

            $client = Paymet::where('id', $id)->first();
            if ($client) {
                $client->delete();
            } else {
                return response()->json([
                    "errors" => [
                        "message"       =>  ["no es posible realizar eliminar este pago"],
                    ]
                ], 422);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'data' => [
                    'code'   => $e->getCode(),
                    'title'  => [__('messages.pay.delete.delete.internal_error')],
                    'errors' => $e->getMessage(),
                ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json([
            "message"       => "pay Eliminado",
        ]);
    }

    public function filter(Request $request)
    {
        try {
            DB::beginTransaction();
            $client = Paymet::filtro($request)->get();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'data' => [
                    'code'   => $e->getCode(),
                    'title'  => [__('messages.paymets.filter.filter.internal_error')],
                    'errors' => $e->getMessage()
                ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if (isset($request->pag)) {
            return response()->json([
                "message"       => "filtro pagos",
                "response"      =>$client->paginate($request->pag),
            ]);
        } else {
            return response()->json([
                "message"       => "filtro pagos",
                "response"      =>$client,
            ]);
        }
    }

    public function acceptPayment(Request $request)
    {
        $clientValide = Paymet::where('code', '=', $request->code)->first();
        if (!$clientValide) {
            return response()->json([
                "errors" => [
                    "message"       => "No existe esta publicacion",
                ]
            ], 422);
        }
        try {
            DB::beginTransaction();

            $client = Paymet::where('code', '=', $request->code)->first();
            $client->pay=true;
            $client->save();


            $response =Paymet::where('code', '=', $request->code)->first();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'data' => [
                    'code'   => $e->getCode(),
                    'title'  => [__('messages.pay.accept.update.internal_error')],
                    'errors' => $e->getMessage(),
                ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            "message"       => "pago actulizado",
            "response"      => $response,
        ]);
    }


    public function refusePayment(Request $request)
    {
        $clientValide = Paymet::where('code', '=', $request->code)->first();
        if (!$clientValide) {
            return response()->json([
                "errors" => [
                    "message"       => "No existe esta publicacion",
                ]
            ], 422);
        }
        try {
            DB::beginTransaction();

            $client = Paymet::where('code', '=', $request->code)->first();
            $client->pay=false;
            $client->save();


            $response =Paymet::where('code', '=', $request->code)->first();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'data' => [
                    'code'   => $e->getCode(),
                    'title'  => [__('messages.pay.refuse.update.internal_error')],
                    'errors' => $e->getMessage(),
                ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            "message"       => "pago rechazado",
            "response"      => $response,
        ]);
    }
}
