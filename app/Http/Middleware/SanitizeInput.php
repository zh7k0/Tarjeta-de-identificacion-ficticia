<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;

class SanitizeInput
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
        // dump($request->all());
        $input = $request->all();
        foreach ($input as $field => $value){
            /** Eliminamos primero cualquier caracter extraño o html tag que tenga el input
             *  para evitar cualquier script injection en la BD.
             * */
            $tempValue =  is_null($value)? $value : filter_var($value, FILTER_SANITIZE_STRING);
            /** 
             * Por ultimo eliminamos el caracter web para el espacio,
             * así evitamos errores al momento de recuperar modelos.
             * */
            $sanitizedValue = Str::contains($tempValue, '%20')?  str_replace('%20', '', $tempValue): $tempValue;
            $input[$field] = $sanitizedValue;

        }
        /**
         * Reemplazamos los antiguos parametros de $request con 
         * los sanitizados.
         */
        $request->replace($input);

        /**
         * Retornamos el request a su flujo normal en la aplicación.
         */
        return $next($request);
    }
}
