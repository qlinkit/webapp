<?php namespace Qlink\Models\Repositories;
/**
 * MIT License
 * Copyright (c) 2016 Lucas Mingarro, Ezequiel Alvarez, César Miquel, Ricardo Bianchi
 * https://opensource.org/licenses/MIT
 *
 * @author Ricardo Bianchi <rbianchi@qlink.it>
 */

use Qlink\Models\Repositories\RedisConnection;

class RedisDB extends RedisConnection {

    public function __construct() {
        parent::__construct();
    }

    public function get($hash)
    {
        return $this->redisConnection->get($hash);
    }

    public function setex($md5Hash, $expireSeconds, $msg)
    {
        $this->redisConnection->setex($md5Hash, $expireSeconds, $msg);
    }

    public function getset($hash, $msg)
    {
        return $this->redisConnection->getset($hash, $msg);
    }

    public function expire($hash, $seconds)
    {
        $this->redisConnection->expire($hash, $seconds);
    }
}
