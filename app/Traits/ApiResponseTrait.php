<?php

namespace App\Traits;

trait ApiResponseTrait
{
    /**
     * 定義例外回應的方法
     *
     * @參數 $message 錯誤訊息
     * @參數 $status HTTP狀態碼
     * @參數 可null $code 選填
     * @回傳return \Illuminate\Http\Response
     */
    public function errorResponse($message, $status, $code =null)
    {
        $code = $code ?? $status; //$code為null時預設http狀態碼

        return response()->json(
            [
                'message' => $message,
                'code' => $code
            ],
            $status
        );
    }
}
