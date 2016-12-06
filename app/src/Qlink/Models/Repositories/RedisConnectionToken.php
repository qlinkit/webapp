<?php namespace Qlink\Models\Repositories;
/**
 * MIT License
 * Copyright (c) 2016 Lucas Mingarro, Ezequiel Alvarez, César Miquel, Ricardo Bianchi
 * https://opensource.org/licenses/MIT
 *
 * @author Ricardo Bianchi <rbianchi@qlink.it>
 */

use Illuminate\Support\Facades\Redis;

class RedisConnectionToken {

    protected $redisConnectionToken;
    public function __construct() {
        $this->redisConnectionToken = Redis::connection('token');
    }

}
