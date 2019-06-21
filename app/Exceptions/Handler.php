<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Str;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        // if ($exception instanceof  \Illuminate\Database\QueryException){
        //     echo "Query mala >:(";
        //     return;
        // }
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if($exception instanceof \Illuminate\Database\QueryException){
            // dd($request, $exception);
            $errorCode = $exception->getCode();
            $message = "Error : ";
            // dd($exception->getMessage());
            switch($errorCode)
            {
                case 23000:
                //Codigo para entrada duplicada en columna con constraint Unique
                    if ((int) $exception->errorInfo[1] == 1062)
                    {
                        $sql = $exception->getSql();
                        if (Str::contains($sql, 'giros')){
                            $message .= 'Giro ya existe.';
                        }
                        elseif (Str::contains($sql, 'contribuyentes')){
                            $message .= 'Empresa con el nombre indicado ya existe';
                        }
                        elseif (Str::contains($sql, 'servicios')){
                            $message .= 'Servicio con el nombre indicado ya existe';
                        }
                        return back()->withErrors($message)->withInput();
                    }
                    break;
                // Código para conexión denegada por la BD.
                case 2002:
                    return response()->view('errors.500', ['error' => "No se puede conectar con la Base de Datos.\nPor favor reinicie la conexión."]);
            }
            return response('Oops! Algo sucedió. Regresa más tarde. <br>Código error:'.$exception->errorInfo[1]);
        }
        
        return parent::render($request, $exception);
    }
}
