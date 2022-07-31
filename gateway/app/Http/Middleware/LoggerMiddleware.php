<?php

namespace App\Http\Middleware;

use Closure;
use Ramsey\Uuid\Uuid;
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
        $log_id = Uuid::uuid4();

        $request->merge([
            'log_id' => $log_id,
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
            'log_id' => $request->log_id,
            'response' => $response,
            'request_started_at' => $request->request_started_at,
            'request_ended_at' => now()
        ];

        Redis::publish('public-api-logger', json_encode($data));
    }
}
