<?php


namespace App\Http\Mesh;

use App\Traits\ApiResponser;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PayService extends ServicesMesh
{
    protected $pach;
    protected $client;
    public function __construct()
    {
        $this->pach= env('PAY_API');
        $this->client = new \GuzzleHttp\Client(['verify' => false]);
    }


    public function pay(array $data){
        try{
            $url = $this->pach.'/api/stripeClients/setPaymentLink';
            $response = $this->client->request('POST', $url, $data);
            return json_decode($response->getBody());


        }catch (Exception $e) {
            Log::critical('ApiBilling pay '.$e);
            return false;
        }
    }
}
