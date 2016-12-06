<?php namespace Qlink\Models\Repositories;
/**
 * MIT License
 * Copyright (c) 2016 Lucas Mingarro, Ezequiel Alvarez, César Miquel, Ricardo Bianchi
 * https://opensource.org/licenses/MIT
 *
 * @author Ricardo Bianchi <rbianchi@qlink.it>
 */

use Qlink\Models\Repositories\RedisConnectionIP;

class RedisDBIP extends RedisConnectionIP {

    public function __construct() {
        parent::__construct();
    }

    public function get($ip)
    {
        return $this->redisConnectionIP->get($ip);
    }

    public function registerIP($ip, $countIP)
    {
        $this->redisConnectionIP->set($ip, $countIP);
        $this->redisConnectionIP->expire($ip, $countIP);
    }

}
