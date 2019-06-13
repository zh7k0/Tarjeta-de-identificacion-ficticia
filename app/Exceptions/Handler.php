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
            $errorCode = $exception->getCode();
            $message = "Error : ";
            switch($errorCode)
            {
                case 23000:
                    $sql = $exception->getSql();
                    $message .= Str::contains($sql, 'giros') ? "Giro ya existe." : "Razón social ya existe.";
                    return back()->withErrors($message)->withInput();
                case 2002:
                    return response()->view('errors.500', ['error' => "No se puede conectar con la Base de Datos.\nPor favor reinicie la conexión."]);
            }
            return response($exception->getMessage().'<br>Codigo:'.$exception->getCode());
        }
        // if($exception instanceof PDOException){
        //     return response()->view('errors.500', [], 500);
        // }
        return parent::render($request, $exception);
    }
}
