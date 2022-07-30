<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

//models
use App\Models\PublicApi;

class LoggerRequest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logger-request:subscribe';

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
        Redis::subscribe(['logger-request'], function($data) {
            $data = json_decode($data);

            PublicApi::create([
                'log_id' => $data->log_id,
                'request' => $data->request,
                'started_at' => $data->started_at
            ]);

            echo 'logger-request: ' . $data->log_id . PHP_EOL;
        });
    }
}
