<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Returns the current user
     *
     * @return User|\Illuminate\Contracts\Auth\Authenticatable|null
     */
    protected function getCurrentUser()
    {
        return Auth::check() ? Auth::user() : null;
    }

    /**
     * Send data response
     *
     * @return JsonResponse
     */
    protected function responseDataSuccess(array $data, $msg = '')
    {
        return $this->responseSuccess($msg, $data);
    }

    /**
     * Send a successful response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function responseDeleteSuccess($data = [], $code = 200)
    {
        return $this->responseSuccess(trans('frontend.global.phrases.record_deleted'), $data, $code);
    }

    /**
     * Send a failed response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function responseDeleteFail(array $data = [], int $code = 422)
    {
        return $this->responseFail(trans('frontend.global.phrases.record_not_deleted'), $data, $code);
    }

    /**
     * Send a successful response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function responseUpdateSuccess($data = [], $code = 200)
    {
        return $this->responseSuccess(trans('frontend.global.phrases.record_updated'), $data, $code);
    }

    /**
     * Send a failed response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function responseUpdateFail(array $data = [], int $code = 422)
    {
        return $this->responseFail(trans('frontend.global.phrases.record_not_updated'), $data, $code);
    }

    /**
     * Send a successful response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function responseStoreSuccess($data = [], $code = 200)
    {
        return $this->responseSuccess(trans('frontend.global.phrases.record_created'), $data, $code);
    }

    /**
     * Send a failed response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function responseStoreFail(array $data = [], int $code = 422)
    {
        return $this->responseFail(trans('frontend.global.phrases.record_not_created'), $data, $code);
    }

    /**
     * Send a successful response
     *
     * @return JsonResponse
     */
    protected function responseSuccess(string $message, array $data = [], int $code = 200)
    {
        return $this->response($code, $message, $data);
    }

    /**
     * Send a failed response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function responseFail(string $message, array $data = [], int $code = 400)
    {
        return $this->response($code, $message, $data);
    }

    /**
     * Returns a response
     *
     * @return JsonResponse
     */
    protected function response(int $code, string $message = '', array $data = [])
    {
        return response()->json(array_merge(['message' => $message], $data), $code);
    }
}
