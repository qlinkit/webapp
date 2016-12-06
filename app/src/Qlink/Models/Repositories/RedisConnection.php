<?php namespace Qlink\Models\Repositories;
/**
 * MIT License
 * Copyright (c) 2016 Lucas Mingarro, Ezequiel Alvarez, César Miquel, Ricardo Bianchi, Sebastián Manusovich
 * https://opensource.org/licenses/MIT
 *
 * @author Ricardo Bianchi <rbianchi@qlink.it>
 */

use Illuminate\Support\Facades\Redis;

class RedisConnection {

    protected $redisConnection;
    public function __construct() {
        $this->redisConnection = Redis::connection('default');
    }

}
