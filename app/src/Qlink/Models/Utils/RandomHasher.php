<?php namespace Qlink\Models\Utils;
/**
 * MIT License
 * Copyright (c) 2016 Lucas Mingarro, Ezequiel Alvarez, César Miquel, Ricardo Bianchi
 * https://opensource.org/licenses/MIT
 *
 * @author Ricardo Bianchi <rbianchi@qlink.it>
 */

use Illuminate\Support\Facades\Crypt;

class RandomHasher {

    public function __construct() {
    }

    public function encrypt($msg, $pass)
    {
        Crypt::setKey($pass);
        return Crypt::encrypt($msg);
    }

    public function decrypt($secret, $pass)
    {
        Crypt::setKey($pass);
        return Crypt::decrypt($secret);
    }

    public function getToken() {

        return md5(uniqid(rand(), true));
    }
   
    public function generateRandomString($length = 16, $seeded = 0) {
       mt_srand($this->makeSeed()+$seeded);

       $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
       $randomString = '';
       for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[mt_rand(0, strlen($characters) - 1)];
       }
       return $randomString;
    }

    public function generateRandomNumber($length = 16, $seeded = 0) {
       mt_srand($this->makeSeed()+$seeded);

       $characters = '0123456789';
       $randomString = '';
       for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[mt_rand(0, strlen($characters) - 1)];
       }
       return $randomString;
    }

    private function makeSeed()
    {
      list($usec, $sec) = explode(' ', microtime());
      return (float) $sec + ((float) $usec * 100000);
    }
}
