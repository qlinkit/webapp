<?php namespace Qlink\Models\Services;
/**
 * MIT License
 * Copyright (c) 2016 Lucas Mingarro, Ezequiel Alvarez, César Miquel, Ricardo Bianchi
 * https://opensource.org/licenses/MIT
 *
 * @author Ricardo Bianchi <rbianchi@qlink.it>
 */

use Qlink\Models\Repositories\RedisDB;
use Qlink\Models\Repositories\RedisDBIP;
use Qlink\Models\Repositories\RedisDBFiles;
use Qlink\Models\Repositories\RedisDBToken;
use Qlink\Models\Repositories\RedisDBTracking;
use Qlink\Models\Repositories\RedisDBCaptcha;

class RedisService {

    protected $redisDB = null; 
    protected $redisDBIP = null;
    protected $redisDBFiles = null;
    protected $redisDBToken = null;
    protected $redisDBTracking = null;
    protected $redisDBCaptcha = null;

    public function __construct() {
        $this->redisDB = new RedisDB();
        $this->redisDBIP = new RedisDBIP();
        $this->redisDBFiles = new RedisDBFiles();
        $this->redisDBToken = new RedisDBToken();
        $this->redisDBTracking = new RedisDBTracking();
        $this->redisDBCaptcha = new RedisDBCaptcha();
    }

    public function setex($hash, $expireSeconds, $msg)
    {
        $this->redisDB->setex($hash, $expireSeconds, $msg);
    }

    public function get($hash)
    {
        return $this->redisDB->get($hash);
    }
 
    public function getset($hash, $msg)
    {
        return $this->redisDB->getset($hash, $msg);
    }

    public function expire($hash, $seconds)
    {
        $this->redisDB->expire($hash, $seconds);
    }

    public function waitIP($ip)
    {
        $countIP = $this->redisDBIP->get($ip);
        if ( $countIP != null )
        {
            sleep( $countIP );
            $countIP++;
        } else {
            $countIP = 1;
        }

        $this->registerIP($ip, $countIP);
        return;
    }

    public function registerIP($ip, $countIP)
    {
        $this->redisDBIP->registerIP($ip, $countIP);
    }

    public function setexfiles($hash, $expireSeconds, $msg)
    {
        $this->redisDBFiles->setex($hash, $expireSeconds, $msg);
    }

    public function getfiles($hash)
    {
        return $this->redisDBFiles->get($hash);
    }
 
    public function getsetfiles($hash, $msg)
    {
        return $this->redisDBFiles->getset($hash, $msg);
    }

    public function expirefiles($hash, $seconds)
    {
        $this->redisDBFiles->expire($hash, $seconds);
    }

    public function getToken($hash)
    {
        return $this->redisDBToken->get($hash);
    }

    public function setexToken($hash, $expireSeconds, $msg)
    {
        $this->redisDBToken->setex($hash, $expireSeconds, $msg);
    }

    public function getsetToken($hash, $msg)
    {
        return $this->redisDBToken->getset($hash, $msg);
    }

    public function expireToken($hash, $seconds)
    {
        $this->redisDBToken->expire($hash, $seconds);
    }

    public function setTracking($hash, $msg)
    {
	   $this->redisDBTracking->set($hash, $msg);
    }

    public function setexTracking($hash, $expireSeconds, $msg)
    {
        $this->redisDBTracking->setex($hash, $expireSeconds, $msg);
    }

    public function getTracking($hash)
    {
        return $this->redisDBTracking->get($hash);
    }

    public function getsetTracking($hash, $msg)
    {
        return $this->redisDBTracking->getset($hash, $msg);
    }

    public function expireTracking($hash, $seconds)
    {
        $this->redisDBTracking->expire($hash, $seconds);
    }

    public function setCaptcha($hash, $msg)
    {
       $this->redisDBCaptcha->set($hash, $msg);
    }

    public function setexCaptcha($hash, $expireSeconds, $msg)
    {
        $this->redisDBCaptcha->setex($hash, $expireSeconds, $msg);
    }

    public function getCaptcha($hash)
    {
        return $this->redisDBCaptcha->get($hash);
    }

    public function getsetCaptcha($hash, $msg)
    {
        return $this->redisDBCaptcha->getset($hash, $msg);
    }

    public function expireCaptcha($hash, $seconds)
    {
        $this->redisDBCaptcha->expire($hash, $seconds);
    }
    
}
