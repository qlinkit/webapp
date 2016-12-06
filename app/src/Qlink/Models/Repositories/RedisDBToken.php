<?php namespace Qlink\Models\Repositories;
/**
 * MIT License
 * Copyright (c) 2016 Lucas Mingarro, Ezequiel Alvarez, César Miquel, Ricardo Bianchi, Sebastián Manusovich
 * https://opensource.org/licenses/MIT
 *
 * @author Ricardo Bianchi <rbianchi@qlink.it>
 */

use Qlink\Models\Repositories\RedisConnectionToken;

class RedisDBToken extends RedisConnectionToken {

    public function __construct() {
        parent::__construct();
    }

    public function get($hash)
    {
        return $this->redisConnectionToken->get($hash);
    }

    public function setex($hash, $expireSeconds, $msg)
    {
        $this->redisConnectionToken->setex($hash, $expireSeconds, $msg);
    }

    public function getset($hash, $msg)
    {
        return $this->redisConnectionToken->getset($hash, $msg);
    }

    public function expire($hash, $seconds)
    {
        $this->redisConnectionToken->expire($hash, $seconds);
    }
 
}
