<?php namespace Qlink\Models\Repositories;
/**
 * MIT License
 * Copyright (c) 2016 Lucas Mingarro, Ezequiel Alvarez, César Miquel, Ricardo Bianchi, Sebastián Manusovich
 * https://opensource.org/licenses/MIT
 *
 * @author Ricardo Bianchi <rbianchi@qlink.it>
 */

use Qlink\Models\Repositories\RedisConnectionFiles;

class RedisDBFiles extends RedisConnectionFiles {

    public function __construct() {
        parent::__construct();
    }

    public function get($hash)
    {
        return $this->redisConnectionFiles->get($hash);
    }

    public function setex($hash, $expireSeconds, $msg)
    {
        $this->redisConnectionFiles->setex($hash, $expireSeconds, $msg);
    }

    public function getset($hash, $msg)
    {
        return $this->redisConnectionFiles->getset($hash, $msg);
    }

    public function expire($hash, $seconds)
    {
        $this->redisConnectionFiles->expire($hash, $seconds);
    }

}
