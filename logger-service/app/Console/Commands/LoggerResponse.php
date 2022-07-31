<?php

namespace App\Console\Commands;

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

            $log = PublicApi::create([
                'log_id' => $data->log_id,
                'response' => $data->response,
                'duration' => $duration->format('%s Seconds %i Minutes'),
                'started_at' => $data->request_started_at,
                'ended_at' => $data->request_ended_at
            ]);

            echo 'logger-response: ' . $log->log_id . PHP_EOL;
        });
    }
}
