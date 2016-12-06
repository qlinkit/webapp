<?php namespace Qlink\Models\Repositories;
/**
 * MIT License
 * Copyright (c) 2016 Lucas Mingarro, Ezequiel Alvarez, César Miquel, Ricardo Bianchi, Sebastián Manusovich
 * https://opensource.org/licenses/MIT
 *
 * @author Ricardo Bianchi <rbianchi@qlink.it>
 */

use Qlink\Models\Repositories\RedisConnectionCaptcha;

class RedisDBCaptcha extends RedisConnectionCaptcha {

    public function __construct() {
        parent::__construct();
    }

	public function set($hash, $msg)
	{
		$this->redisConnectionCaptcha->set($hash, $msg);
	}

    public function get($hash)
    {
        return $this->redisConnectionCaptcha->get($hash);
    }

    public function setex($md5Hash, $expireSeconds, $msg)
    {
        $this->redisConnectionCaptcha->setex($md5Hash, $expireSeconds, $msg);
    }

    public function getset($hash, $msg)
    {
        return $this->redisConnectionCaptcha->getset($hash, $msg);
    }

    public function expire($hash, $seconds)
    {
        $this->redisConnectionCaptcha->expire($hash, $seconds);
    }
}
