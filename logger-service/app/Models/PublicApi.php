<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class PublicApi extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'public_api_logs';

    protected $primaryKey = '_id';

    public $timestamps = false;

    protected $fillable = [
        'log_id', 'endpoint', 'exception', 'request', 'response', 'duration', 'started_at', 'ended_at'
    ];
}
