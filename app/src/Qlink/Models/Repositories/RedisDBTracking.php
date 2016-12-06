<?php namespace Qlink\Models\Repositories;
/**
 * MIT License
 * Copyright (c) 2016 Lucas Mingarro, Ezequiel Alvarez, César Miquel, Ricardo Bianchi, Sebastián Manusovich
 * https://opensource.org/licenses/MIT
 *
 * @author Ricardo Bianchi <rbianchi@qlink.it>
 */

use Qlink\Models\Repositories\RedisConnectionTracking;

class RedisDBTracking extends RedisConnectionTracking {

    public function __construct() {
        parent::__construct();
    }

	public function set($hash, $msg)
	{
		$this->redisConnectionTracking->set($hash, $msg);
	}

    public function get($hash)
    {
        return $this->redisConnectionTracking->get($hash);
    }

    public function setex($md5Hash, $expireSeconds, $msg)
    {
        $this->redisConnectionTracking->setex($md5Hash, $expireSeconds, $msg);
    }

    public function getset($hash, $msg)
    {
        return $this->redisConnectionTracking->getset($hash, $msg);
    }

    public function expire($hash, $seconds)
    {
        $this->redisConnectionTracking->expire($hash, $seconds);
    }
}
