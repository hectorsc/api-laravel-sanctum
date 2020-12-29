<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

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
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Throwable
     */
    public function report(Throwable $exception)
    {
        // dd($exception);
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        // return response()->json($exception->getMessage());
        // if($exception instanceof InvalidScore) {
        //     // return response()->json([
        //     //     'score' => trans('rating.invalidScore', [
        //     //         // no tenemos las variables to, from lo
        //     //         // hacemos de otra forma
        //     //     ])
        //     // ]);
        //     return response()->json($exception->getMessage());
        // }
        // para que este archivo no se convierta en un archivo basura
        // en nuestra exception creada InvalidScore podemos usar el
        // metodo render y no tener que estar lanzando todas las exceptin
        // desde este archivo

        return parent::render($request, $exception);
    }
}
