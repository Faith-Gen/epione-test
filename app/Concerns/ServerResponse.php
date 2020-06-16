<?php

namespace App\Concerns;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

trait ServerResponse
{
    private $errorMessages = [
        NotFoundHttpException::class  => 'Invalid route',
        RouteNotFoundException::class => 'Authorization headers missing',
    ];

    /**
     * Class - error code key maps.
     * @var array
     */
    private $errorCodes = [
        ValidationException::class    => 422,
        RouteNotFoundException::class => 401,
    ];

    /**
     * Handles request exceptions and format the error to JSON.
     *
     * @param Request $request
     * @param Exception $exception
     * @param boolean $rawError
     * @return json-response
     */
    public function apiExceptions(Request $request, $exception, bool $rawError = false)
    {
        if ($rawError) {
            return parent::render($request, $exception);
        }

        $statusCode = $this->errorCodes[get_class($exception)] ?? 500;

        if (in_array('getStatusCode', get_class_methods($exception))) {
            $statusCode = $exception->getStatusCode();
        }

        if ($exception instanceof ValidationException) {
            $errors = collect($exception->errors())->flatten()->toArray();
            $message = implode(PHP_EOL, $errors);
        } else {
            $message = $this->errorMessages[get_class($exception)]
                ?? (strlen($exception->getMessage())
                    ? $exception->getMessage()
                    : 'Unknown server error!');
        }

        return \response()->json([
            'exception'      => get_class($exception),
            'statusCode' => $statusCode,
            'message'    => $message,
        ], $statusCode);
    }

    /**
     * Formats the response into JSON response with a "data" key.
     *
     * @param mixed $data
     * @param integer $statusCode
     * @return void
     */
    public function apiDataResponse($data, $statusCode = 200)
    {
        if (is_object($data))
            $data = (array) $data;

        return response()->json([
            'data' => $data
        ], $statusCode);
    }
}
