<?php namespace Qlink\Controllers;
/**
 * MIT License
 * Copyright (c) 2016 Lucas Mingarro, Ezequiel Alvarez, César Miquel, Ricardo Bianchi, Sebastián Manusovich
 * https://opensource.org/licenses/MIT
 *
 * @author Ricardo Bianchi <rbianchi@qlink.it>
 */

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cookie;
use Qlink\Controllers\QlinkController;
class CorpController extends QlinkController {

    public $layout = 'layouts.corp';

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
	    $header = View::make('corp.section-header',
            array(
            )
        )->render();

    	$detail = View::make('corp.section-detail-left',
            array(
            )
        )->render();

        $download = View::make('corp.section-download',
            array(
            )
        )->render();

        $features = View::make('corp.section-services',
            array(
            )
        )->render();

        $faq = View::make('corp.section-faq',
            array(
            )
        )->render();

		$privacy = View::make('corp.section-privacy',
            array(
            )
        )->render();

        $video = View::make('corp.section-video')->render();

        $about = View::make('corp.section-testimonial',
            array(
            )
        )->render();

        $advisory = View::make('corp.section-advisory',
            array(
            )
        )->render();

        $footer = View::make('corp.section-footer',
            array(
            )
        )->render();

    	$bodyView = View::make( 'corp.body',
    		array(
                'header'=> $header,
                'detail'=> $detail,
                'features'=> $features,
                'download'=> $download,
                'faq'=> $faq,
				'privacy'=> $privacy,
                'video' => $video,
                'about' => $about,
                'advisory' => $advisory,
                'footer'=> $footer,
            )
    	);

    	$this->layout->bodyView = $bodyView;
    }
}
