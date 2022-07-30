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
        Redis::subscribe(['logger-response'], function($data) {
            $data = json_decode($data);

            $log = PublicApi::where('log_id', '=', $data->log_id)->first();

            if(isset($log)) {
                $start = date_create($log->started_at);
                $end = date_create($log->ended_at);
                $duration = date_diff($start, $end);

                $log->response = $data->response;
                $log->ended_at = $data->ended_at;
                $log->duration = $duration->format('%s Seconds %i Minutes');
                $log->save();
            }

            echo 'logger-response: ' . $data->log_id . PHP_EOL;
        });
    }
}
