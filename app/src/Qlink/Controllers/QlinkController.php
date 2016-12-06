<?php namespace Qlink\Controllers;
/**
 * MIT License
 * Copyright (c) 2016 Lucas Mingarro, Ezequiel Alvarez, César Miquel, Ricardo Bianchi
 * https://opensource.org/licenses/MIT
 *
 * @author Ricardo Bianchi <rbianchi@qlink.it>
 */

use Qlink\Controllers\BaseController;
use Illuminate\Support\Facades\HTML;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Config;

class QlinkController extends BaseController {

    protected $config;

    public function __construct()
    {
        $this->config = Config::get('qlinkconfig.'.$this->getEnvironment());
    }

	public static function style($url, $attributes = array())
    {
        return HTML::style($url, $attributes);
    }

    public static function script($url, $attributes = array())
    {
        return HTML::script($url, $attributes);
    }

	public function getEnvironment()
	{
		return app()->environment();
	}
}
