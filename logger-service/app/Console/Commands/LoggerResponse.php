<?php

namespace App\Console\Commands;

use Ramsey\Uuid\Uuid;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

//models
use App\Models\PublicApi;

class LoggerResponse extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logger-response:subscribe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Subscribe to a Redis channel';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Redis::subscribe(['public-api-logger'], function($data) {
            $data = json_decode($data);

            $start = date_create($data->request_started_at);
            $end = date_create($data->request_ended_at);
            $duration = date_diff($start, $end);
            $log_id = Uuid::uuid4();

            $log = PublicApi::create([
                'log_id' => $log_id->toString(),
                'endpoint' => $data->endpoint,
                'exception' => !empty($data->response->exception) ? true : false,
                'request' => $data->request,
                'response' => $data->response,
                'duration' => $duration->format('%i Minutes %s Seconds %f Milliseconds'),
                'started_at' => $data->request_started_at,
                'ended_at' => $data->request_ended_at
            ]);

            echo 'logger-response: ' . $log->log_id . PHP_EOL;
        });
    }
}
