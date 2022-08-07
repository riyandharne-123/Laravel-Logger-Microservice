<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class LoggerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $request->merge([
            'request_endpoint' => $request->getUri(),
            'request_started_at' => now()
        ]);

        return $next($request);
    }

    /**
     * Handle tasks after the response has been sent to the browser.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\Response  $response
     * @return void
     */
    public function terminate($request, $response)
    {
        $data = [
            'request' => $request->all(),
            'endpoint' => $request->request_endpoint,
            'response' => $response,
            'exception' => $response->exception,
            'request_started_at' => $request->request_started_at,
            'request_ended_at' => now()
        ];

        Redis::publish('public-api-logger', json_encode($data));
    }
}
