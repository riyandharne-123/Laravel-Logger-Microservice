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
            'log_id' => $log_id
        ]);

        $data = [
            'log_id' => $log_id,
            'request' => $request->all(),
            'started_at' => now()
        ];

        Redis::publish('logger-request', json_encode($data));

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
            'ended_at' => now()
        ];

        Redis::publish('logger-response', json_encode($data));
    }
}
