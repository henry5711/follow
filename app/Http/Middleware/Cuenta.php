<?php


namespace App\Http\Middleware;


use App\Http\Mesh\UsuService;
use Closure;


class Cuenta
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $cuenta = new UsuService;
        $cuenta = $cuenta->getCuenta();
        //dd($cuenta);
        //$cuenta = $cuenta[0];
        $c = [];
        if($cuenta && count($cuenta) > 0){
            foreach ($cuenta as $key) {
                // return $ac;
                $c['image']     = $key->image;
                $c['ico']       = $key->ico;
                $c['name']      = $key->name;
                $c['email']     = $key->email;
                $c['phone']     = $key->phone;
                $c['header']    = $key->header;
                $c['footer']    = $key->footer;
                $c['address']   = $key->address;
                $c['coin_name'] = $key->coin_name;
                if($key->time_zone != null && $key->time_zone != ""){
                    $c['time_zone'] = $key->time_zone;
                }else{
                    $c['time_zone'] = 'America/Panama';
                }

            }
        }else{
            $c['image']     = 'logo_zippy.png';
            $c['ico']       = 'logo_zippy.png';
            $c['name']      = '';
            $c['email']     = '';
            $c['phone']     = '';
            $c['header']    = 'logo_zippy.png';
            $c['footer']    = 'logo_zippy.png';
            $c['address']   = '';
            $c['coin_name'] = '';
            $c['time_zone'] = 'America/Panama';
        }
        $request['cuenta'] = $c;
        // return $request;
        return $next($request);
    }
}
