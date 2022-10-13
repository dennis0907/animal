<?php

namespace App\Exceptions;

use App\Traits\ApiResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ApiResponseTrait;
    /**
     * 覆寫父類別render()方法，調整回傳內容
     */
    public function render($request, Throwable $e)
    {
        if ($request->expectsJson()) {
            // Model找不到對應資源回傳此錯誤訊息
            if ($e instanceof ModelNotFoundException) {
                return $this->errorResponse(
                    '找不到此資源',
                    Response::HTTP_NOT_FOUND
                );
            }
            // 域名錯誤
            if ($e instanceof NotFoundHttpException) {
                return $this->errorResponse(
                    '無法找到此網址',
                    Response::HTTP_NOT_FOUND
                );
            }
            // 網站不允許該HTTP動詞
            if ($e instanceof MethodNotAllowedHttpException) {
                return $this->errorResponse(
                    // $e->getMessage(), <--呼叫內建錯誤訊息
                    'HTTP請求錯誤',
                    Response::HTTP_METHOD_NOT_ALLOWED
                );
            }
        }
        return parent::render($request, $e);
    }

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
