<?php namespace Qlink\Controllers;
/**
 * MIT License
 * Copyright (c) 2016 Lucas Mingarro, Ezequiel Alvarez, César Miquel, Ricardo Bianchi
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
use Qlink\Models\Services\RedisService;
use Qlink\Models\Utils\RandomHasher;
use Qlink\Models\Repositories\MongoAPI;
use Qlink\Models\Entities\MongoQlinkMemory;
use Weboap\Winput\Facades\Winput;
class LandingNewController extends QlinkController {

	public $layout = 'layouts.qlink_new';
	const EXPIRE_SECONDS_DEFAULT = 86400; // 24horas
	const EXPIRE_SECONDS_TRACKING = 604800; // 7 dias
	const TRACKING_NUMBER_CODE = "DN";
	const TRACKING_NUMBER_LENGHT = 10;
	const TRACKING_STATUS_PENDING_READ = 0;
	const TRACKING_STATUS_READED = 1;

	const RANDOM_PASSPHRASE_LENGHT = 10;
	const PASSPHRASE_SALT = '1e23e006d72e4a70e9510d';
	const KEY_LENGHT = 12;
	const STATIC_PASSPHRASE = '';
	const TOKEN_SECONDS_LIVE = 21600; // 6horas
	const APP_ANDROID_CURRENT_VERSION = '1.71';
	const WEB_CURRENT_VERSION = '2.0';
	const FORCE_TEXT = '	Con motivo de brindarle mayor seguridad a sus comunicaciones y mejorar la calidad de nuestro servicio, le solicitamos que para seguir usando nuestra aplicación actualice a la última versión disponible en Play Store.
	Le agradecemos su colaboración. 
	El equipo de Qlink.it

-----------------

	On the occasion of providing greater security for their communications and improve the quality of service, we ask you to continue using our application upgrade to the latest version available at Play Store.
	We appreciate your cooperation.
	The Qlink.it team
	';
	const FORCE_UPDATE = true;

	protected $mongoMemory;
	protected $redisService = null;
	protected $hasherUtil = null;

	public function __construct()
	{
		parent::__construct();
		$this->mongoMemory = new MongoAPI( new MongoQlinkMemory() );
		$this->redisService = new RedisService();
		$this->hasherUtil = new RandomHasher();
	}

	public function welcome()
	{
		$ip = Request::getClientIp();
		if ( $this->config['enabled_anti_fire'] )
		{
			$this->redisService->waitIP( $ip );
		}

		$url = $this->config['site_url'];

		$replyIntent = Input::get('reply');
		$isReply = 'false';
		if ( $replyIntent != null && $replyIntent == 't' )
		{
			$isReply = 'true';
		}

		$this->layout->title = Lang::get('messages.app_title');
		$this->layout->contentBody = View::make( 'message_form_new', array( 'lang' => Config::get('app.locale'), 'env' => $this->getEnvironment(), 'data' => '' ,'siteUrl' => url('/', array(), $this->config['secure_site']), 'reply_intent' => $isReply, 'x_token' => $this->getToken(), 'qlink_corporate_site_url' => $this->config['qlink_corporate_site_url'] ) );
		$this->layout->contentHeader = View::make( 'header', array( 'env' => $this->getEnvironment(), 'headerTitle' => Lang::get('messages.header_title') ) );
		$this->layout->contentFooter = View::make( 'footer', array( 'env' => $this->getEnvironment(), 'footerText' => Lang::get('messages.footer_text') ) );
	}

	public function forward()
	{
		$ip = Request::getClientIp();
		if ( $this->config['enabled_anti_fire'] )
		{
			$this->redisService->waitIP( $ip );
		}

		$url = $this->config['site_url'];

		$replyIntent = Input::get('reply');
		$isReply = 'false';
		if ( $replyIntent != null && $replyIntent == 't' )
		{
			$isReply = 'true';
		}


		$data = View::make( 'message_form_res_new', array( 'env' => $this->getEnvironment(), 'data' => '' ,'siteUrl' => url('/', array(), $this->config['secure_site']), 'reply_intent' => $isReply, 'x_token' => $this->getToken(), 'qlink_corporate_site_url' => $this->config['qlink_corporate_site_url'] ) )->render();
		return Response::json(array('status'=>'OK', 'data'=>$data));
	}

	public function injectios()
	{
		// Prevenir de un brute force
		$ip = Request::getClientIp();
		if ( $this->config['enabled_anti_fire'] )
		{
			$this->redisService->waitIP( $ip );
		}

		$replyIntent = Input::get('replyIntent');
		
		/*********************************************************************************/

		$xToken = Winput::get('x_token');
		$tokenState = $this->redisService->getToken($xToken);
		
		if ( $tokenState == null || $tokenState != "A" )
		{
			return Response::json(array('status' => 'FAIL', 'hash' => null, 'expireDate' => null ));
		}

		$from = Winput::get('from');
		$imprint = Winput::get('imprint');
		$captcha = Winput::get('captcha');
		$files = Winput::get('files');
		$namesFiles = Winput::get('namesFiles');

		// Server storage selection
		$servnum = "one";
		if ( isset( $this->config['current_storage'] ) )
		{
			$allowedServers = $this->config['allowed_servers'];
			if ( in_array($this->config['current_storage'], $allowedServers) )
			{
				$servnum = $this->config['current_storage'];
			}
		}

		if ( $from != null && ( strpos($from,'app_android') !== false || strpos($from,'app_ios') !== false ) )
		{
			$files = json_decode( $files );
			$namesFiles = json_decode( $namesFiles );
		}

		// Encode json msg
		$msg = json_encode(Winput::get('msg'));

		// Timestamp y TimezoneOffset
		$n = Winput::get('n');
		$timestamp = Winput::get('randomHash');

		// Seed para el qlink que viene y para el actual
		$nextSeed = $timestamp; // Seed del qlink que viene es el timestamp de este qlink
		$thisSeed = $this->redisService->getset('nextSeed', $nextSeed);
		if ( $thisSeed == null )
		{
			$this->redisService->set('nextSeed', $nextSeed);
			$thisSeed = 0;
		}

		if ( trim($msg) == '' ) {
			return Response::json(array('status' => 'ERROR', 'hash' => '', 'alert' => Lang::get('messages.error1')));
		}

		// Ira en la url al destinatario
		$randomPassphrase = $this->hasherUtil->generateRandomString( self::RANDOM_PASSPHRASE_LENGHT, $thisSeed );

		// Obtengo un token
		$keyHash = $this->hasherUtil->generateRandomString( self::KEY_LENGHT, $thisSeed );

		// Token que va a ir en la url
		$userToken = self::STATIC_PASSPHRASE.$randomPassphrase.$keyHash;

		if ( !isset( $this->config['expire_seconds'] ) )
			$expireSeconds = self::EXPIRE_SECONDS_DEFAULT;
		else
			$expireSeconds = $this->config['expire_seconds'];

		// Calculo el día de expiración según el timestamp y el timezone del cliente
		$date = new \DateTime();
		$date->setTimestamp($timestamp/1000);
		if ( $n > 0 ) {
			$date->sub(new \DateInterval('PT'.$n.'M'));
		} else {
			$n = -1 * $n;
			$date->add(new \DateInterval('PT'.$n.'M'));
		}
		$date->add(new \DateInterval('PT'.$expireSeconds.'S'));
		$expireDate = $date->format('Y-m-d H:i:s A') . " (" . Lang::get('messages.local_time') . ")";

		// Firma
		if ( $imprint != null && $imprint == "true" )
		{
			$country = "Reserved"; // TODO: get country for current IP
			$city = ""; // TODO: get city for current IP
			if ( $country != "Reserved" )
				$geoip = $country . ", " . $city . " ($ip)";
			else
				$geoip = $ip;

			$msg = array("ip"=>$geoip, "msg"=>$msg);
			$msg = json_encode($msg);
		} else {
			$msg = array("ip"=>null, "msg"=>$msg);
			$msg = json_encode($msg);
		}

		// Encripto en mensaje
		$msg = $this->hasherUtil->encrypt( $msg, $randomPassphrase.self::PASSPHRASE_SALT );

		// Seteo el mensaje con un tiempo de expiracion y compimido
		$compressedMsg = gzcompress($msg);
		$this->redisService->setex($keyHash, $expireSeconds, $compressedMsg);

		// Captcha required
		if ( $captcha == null )
			$captcha = "false";
		$this->redisService->setexCaptcha($keyHash, self::EXPIRE_SECONDS_TRACKING, $captcha);

		// Genero un tracking number
		$trackingCode = $this->hasherUtil->generateRandomNumber( self::TRACKING_NUMBER_LENGHT, $timestamp );
		$trackingNumber = self::TRACKING_NUMBER_CODE . $trackingCode;
		$cStat = array("blue" => $keyHash, "status" => self::TRACKING_STATUS_PENDING_READ);
		$this->redisService->setexTracking($trackingNumber, self::EXPIRE_SECONDS_TRACKING, json_encode($cStat));
		$this->redisService->setexTracking($keyHash, self::EXPIRE_SECONDS_TRACKING, $trackingNumber);

		$trackingNumber = self::TRACKING_NUMBER_CODE . " " . $trackingCode;

		/*
		 * State of memory
		 */
		$nowDate = new \DateTime();
		$fnowDate = $nowDate->format('Y-m-d');
		$mongoMemoryStatus = $this->mongoMemory->getCollectionEntity()
			->where( 'date', '=', $fnowDate )
			->get();

		if ( count($mongoMemoryStatus) == 0 )
		{
			$mongoObject = array(
					'date'=>$fnowDate,
					'usedram'=>0,
					'msgcount'=>0,
					'usedfs'=>0,
					'filecount'=>0,
					'app_android'=>0,
					'app_ios'=>0,
					'chrome_app'=>0,
					'web_app'=>0,
					'other_app'=>0
					);
			$this->mongoMemory->insert( $mongoObject );
		}

		$elMongo = $this->mongoMemory->getCollectionEntity()->where( 'date', '=' , $fnowDate )->get();
		if ( isset($elMongo[0]->other_app) )
		{
			switch($from)
			{
			    case 'app_android';
			    	$this->mongoMemory->getCollectionEntity()->where( 'date', '=' , $fnowDate )->increment('app_android', 1);
			    case 'app_ios';
			    	$this->mongoMemory->getCollectionEntity()->where( 'date', '=' , $fnowDate )->increment('app_ios', 1);
			    case 'chrome_app';
			    	$this->mongoMemory->getCollectionEntity()->where( 'date', '=' , $fnowDate )->increment('chrome_app', 1);
			    	break;
			    case 'web_app';
			    	$this->mongoMemory->getCollectionEntity()->where( 'date', '=' , $fnowDate )->increment('web_app', 1);
			    	break;
			    default;
			        $this->mongoMemory->getCollectionEntity()->where( 'date', '=' , $fnowDate )->increment('other_app', 1);
			        break;
			}
		}

		$this->mongoMemory->getCollectionEntity()
			->where( 'date', '=' , $fnowDate )
			->increment('usedram', strlen($compressedMsg));
		$this->mongoMemory->getCollectionEntity()
			->where( 'date', '=' , $fnowDate )
			->increment('msgcount', 1);
		/**********************************************************************/

		// Genero los files
		if ( $files != null )
		{
			$injectDate = new \DateTime();
			$injectDate = $injectDate->format('Y-m-d');

			foreach( $files as $key => $jsonEncriptedFile )
			{
				if ( $from != null && strpos($from,'app_android') !== false )
					$encf = $this->hasherUtil->encrypt( $jsonEncriptedFile, $randomPassphrase.self::PASSPHRASE_SALT );
				else
					$encf = $this->hasherUtil->encrypt( json_encode($jsonEncriptedFile), $randomPassphrase.self::PASSPHRASE_SALT );

				$this->mongoMemory->getCollectionEntity()
					->where( 'date', '=' , $fnowDate )
					->increment('usedfs', strlen($encf));

				$this->mongoMemory->getCollectionEntity()
					->where( 'date', '=' , $fnowDate )
					->increment('filecount', 1);

				$pathFile = app_path() . "/encfiles/" . $servnum . "/" . $injectDate . "/" . md5($keyHash) . $key . ".enc";
				$dirName = dirname($pathFile);
				if (!is_dir($dirName))
				{
					mkdir($dirName, 0700, true);
				}

				$fp = fopen($pathFile,"wb");
				fwrite($fp,$encf);
				fclose($fp);
				chmod($pathFile, 0700);
			}

			$nFiles = array();
			$nFiles[0]['name'] = $namesFiles[0];
			$nFiles[0]['date'] = $injectDate;
			$this->redisService->setexfiles($keyHash, $expireSeconds, json_encode($nFiles));
		}

		$url = url($servnum, array('qlink' => $userToken), $this->config['secure_site']);
		$lang = Config::get('app.locale');
		$gnUrl = url('dnstat?lang='.$lang.'&trk='.$trackingCode, null, $this->config['secure_site']);

		return Response::json(array('status' => 'OK', 'hash' => $url, 'expireDate' => $expireDate, 'tn' => $trackingNumber, 'tnlk' => $gnUrl ));
	}

	public function inject()
	{
		// Prevenir de un brute force
		$ip = Request::getClientIp();
		if ( $this->config['enabled_anti_fire'] )
		{
			$this->redisService->waitIP( $ip );
		}

		$replyIntent = Input::get('replyIntent');
		
		/*********************************************************************************/

		$xToken = Winput::get('x_token');
		$tokenState = $this->redisService->getToken($xToken);

		if ( $tokenState == null || $tokenState != "A" )
		{
			return Response::json(array('status' => 'FAIL', 'hash' => null, 'expireDate' => null ));
		}

		$from = Winput::get('from');
		$imprint = Winput::get('imprint');
		$captcha = Winput::get('captcha');
		$files = Winput::get('files');
		$namesFiles = Winput::get('namesFiles');

		//*******************
		if ( $from == null )
		{
			return Response::json(array('status' => 'ERROR', 'hash' => '', 'alert' => Lang::get('messages.error1')));
		}

		if ( $from == 'app_android' )
		{
			return Response::json(array('status' => 'ERROR', 'hash' => '', 'alert' => Lang::get('messages.error1')));
		}

		if( strpos($from,'app_android') !== false && substr($from, -2) != '71' && substr($from, -2) != '72' && substr($from, -2) != '73' ) 
		{
			return Response::json(array('status' => 'ERROR', 'hash' => '', 'alert' => Lang::get('messages.error1')));			
		}
		//*******************


		// Server storage selection
		$servnum = "one";
		if ( isset( $this->config['current_storage'] ) )
		{
			$allowedServers = $this->config['allowed_servers'];
			if ( in_array($this->config['current_storage'], $allowedServers) )
			{
				$servnum = $this->config['current_storage'];
			}
		}

		if ( $from != null && ( strpos($from,'app_android') !== false || strpos($from,'app_ios') !== false ) )
		{
			$files = json_decode( $files );
			$namesFiles = json_decode( $namesFiles );
		}

		// Encode json msg
		$msg = json_encode(Winput::get('msg'));

		// Timestamp y TimezoneOffset
		$n = Winput::get('n');
		$timestamp = Winput::get('randomHash');

		// Seed para el qlink que viene y para el actual
		$nextSeed = $timestamp; // Seed del qlink que viene es el timestamp de este qlink
		$thisSeed = $this->redisService->getset('nextSeed', $nextSeed);
		if ( $thisSeed == null )
		{
			$this->redisService->set('nextSeed', $nextSeed);
			$thisSeed = 0;
		}

		if ( trim($msg) == '' ) {
			return Response::json(array('status' => 'ERROR', 'hash' => '', 'alert' => Lang::get('messages.error1')));
		}

		// Ira en la url al destinatario
		$randomPassphrase = $this->hasherUtil->generateRandomString( self::RANDOM_PASSPHRASE_LENGHT, $thisSeed );

		// Obtengo un token
		$keyHash = $this->hasherUtil->generateRandomString( self::KEY_LENGHT, $thisSeed );

		// Token que va a ir en la url
		$userToken = self::STATIC_PASSPHRASE.$randomPassphrase.$keyHash;

		if ( !isset( $this->config['expire_seconds'] ) )
			$expireSeconds = self::EXPIRE_SECONDS_DEFAULT;
		else
			$expireSeconds = $this->config['expire_seconds'];

		// Calculo el día de expiración según el timestamp y el timezone del cliente
		$date = new \DateTime();
		$date->setTimestamp($timestamp/1000);
		if ( $n > 0 ) {
			$date->sub(new \DateInterval('PT'.$n.'M'));
		} else {
			$n = -1 * $n;
			$date->add(new \DateInterval('PT'.$n.'M'));
		}
		$date->add(new \DateInterval('PT'.$expireSeconds.'S'));
		$expireDate = $date->format('Y-m-d H:i:s A') . " (" . Lang::get('messages.local_time') . ")";

		// Firma
		if ( $imprint != null && $imprint == "true" )
		{
			$country = "Reserved"; // TODO: get country for current IP
			$city = ""; // TODO: get city for current IP
			if ( $country != "Reserved" )
				$geoip = $country . ", " . $city . " ($ip)";
			else
				$geoip = $ip;

			$msg = array("ip"=>$geoip, "msg"=>$msg);
			$msg = json_encode($msg);
		} else {
			$msg = array("ip"=>null, "msg"=>$msg);
			$msg = json_encode($msg);
		}

		// Encripto en mensaje
		$msg = $this->hasherUtil->encrypt( $msg, $randomPassphrase.self::PASSPHRASE_SALT );

		// Seteo el mensaje con un tiempo de expiracion y compimido
		$compressedMsg = gzcompress($msg);
		$this->redisService->setex($keyHash, $expireSeconds, $compressedMsg);

		// Captcha required
		if ( $captcha == null )
			$captcha = "false";
		$this->redisService->setexCaptcha($keyHash, self::EXPIRE_SECONDS_TRACKING, $captcha);

		// Genero un tracking number
		$trackingCode = $this->hasherUtil->generateRandomNumber( self::TRACKING_NUMBER_LENGHT, $timestamp );
		$trackingNumber = self::TRACKING_NUMBER_CODE . $trackingCode;
		$cStat = array("blue" => $keyHash, "status" => self::TRACKING_STATUS_PENDING_READ);
		$this->redisService->setexTracking($trackingNumber, self::EXPIRE_SECONDS_TRACKING, json_encode($cStat));
		$this->redisService->setexTracking($keyHash, self::EXPIRE_SECONDS_TRACKING, $trackingNumber);

		$trackingNumber = self::TRACKING_NUMBER_CODE . " " . $trackingCode;

		/*
		 * State of memory
		 */
		$nowDate = new \DateTime();
		$fnowDate = $nowDate->format('Y-m-d');
		$mongoMemoryStatus = $this->mongoMemory->getCollectionEntity()
			->where( 'date', '=', $fnowDate )
			->get();

		if ( count($mongoMemoryStatus) == 0 )
		{
			$mongoObject = array(
					'date'=>$fnowDate,
					'usedram'=>0,
					'msgcount'=>0,
					'usedfs'=>0,
					'filecount'=>0,
					'app_android'=>0,
					'app_ios'=>0,
					'chrome_app'=>0,
					'web_app'=>0,
					'other_app'=>0
					);
			$this->mongoMemory->insert( $mongoObject );
		}

		$elMongo = $this->mongoMemory->getCollectionEntity()->where( 'date', '=' , $fnowDate )->get();
		if ( isset($elMongo[0]->other_app) )
		{
			switch($from)
			{
			    case 'app_android';
			    	$this->mongoMemory->getCollectionEntity()->where( 'date', '=' , $fnowDate )->increment('app_android', 1);
			    case 'app_ios';
			    	$this->mongoMemory->getCollectionEntity()->where( 'date', '=' , $fnowDate )->increment('app_ios', 1);
			    case 'chrome_app';
			    	$this->mongoMemory->getCollectionEntity()->where( 'date', '=' , $fnowDate )->increment('chrome_app', 1);
			    	break;
			    case 'web_app';
			    	$this->mongoMemory->getCollectionEntity()->where( 'date', '=' , $fnowDate )->increment('web_app', 1);
			    	break;
			    default;
			        $this->mongoMemory->getCollectionEntity()->where( 'date', '=' , $fnowDate )->increment('other_app', 1);
			        break;
			}
		}

		$this->mongoMemory->getCollectionEntity()->where( 'date', '=' , $fnowDate )->increment('usedram', strlen($compressedMsg));
		$this->mongoMemory->getCollectionEntity()->where( 'date', '=' , $fnowDate )->increment('msgcount', 1);
		/**********************************************************************/

		// Genero los files
		if ( $files != null )
		{
			$injectDate = new \DateTime();
			$injectDate = $injectDate->format('Y-m-d');

			foreach( $files as $key => $jsonEncriptedFile )
			{
				if ( $from != null && strpos($from,'app_android') !== false )
					$encf = $this->hasherUtil->encrypt( $jsonEncriptedFile, $randomPassphrase.self::PASSPHRASE_SALT );
				else
					$encf = $this->hasherUtil->encrypt( json_encode($jsonEncriptedFile), $randomPassphrase.self::PASSPHRASE_SALT );

				$this->mongoMemory->getCollectionEntity()->where( 'date', '=' , $fnowDate )->increment('usedfs', strlen($encf));
				$this->mongoMemory->getCollectionEntity()->where( 'date', '=' , $fnowDate )->increment('filecount', 1);

				$pathFile = app_path() . "/encfiles/" . $servnum . "/" . $injectDate . "/" . md5($keyHash) . $key . ".enc";
				$dirName = dirname($pathFile);
				if (!is_dir($dirName))
				{
					mkdir($dirName, 0700, true);
				}

				$fp = fopen($pathFile,"wb");
				fwrite($fp,$encf);
				fclose($fp);
				chmod($pathFile, 0700);
			}

			$nFiles = array();
			$nFiles[0]['name'] = $namesFiles[0];
			$nFiles[0]['date'] = $injectDate;
			$this->redisService->setexfiles($keyHash, $expireSeconds, json_encode($nFiles));
		}

		$url = url($servnum, array('qlink' => $userToken), $this->config['secure_site']);
		$lang = Config::get('app.locale');
		$gnUrl = url('dnstat?lang='.$lang.'&trk='.$trackingCode, null, $this->config['secure_site']);

		return Response::json(array('status' => 'OK', 'hash' => $url, 'expireDate' => $expireDate, 'tn' => $trackingNumber, 'tnlk' => $gnUrl ));
	}

	public function tokenizer()
	{
		$operationToken = $this->getToken();
		return Response::json(array('status' => 'OK', 'x_token' => $operationToken));
	}

	public function appversion()
	{
		return Response::json(array('status' => 'OK', 'fup' => self::FORCE_UPDATE, 'fup_text' => self::FORCE_TEXT, 'current_version' => self::APP_ANDROID_CURRENT_VERSION, 'web_current_version' => self::WEB_CURRENT_VERSION ));
	}

	private function getToken() {
		$operationToken = hash('sha256', str_random(40), false);
		$this->redisService->setexToken($operationToken, self::TOKEN_SECONDS_LIVE, 'A');
		return $operationToken;
	}

	private function isValidTrk($str)
	{
		return (bool)!preg_match ("/[^0-9]/", $str);
	}

	private function isValidHash($str)
	{
		return (bool)preg_match('`^[a-zA-Z0-9+/]+={0,2}$`', $str);
	}

	private function isValidServer($str)
	{
		if ( $str == 'one' || $str == 'two' || $str == 'three' || $str == 'four' )
		{	 
			return true;
		}
		return false;
	}

	public function seekAndDestroy($servnum, $hash, $res = null)
	{
		$this->layout->title = Lang::get('messages.app_title');
		$this->layout->contentHeader = View::make( 'header', array( 'env' => $this->getEnvironment(), 'headerTitle' => Lang::get('messages.header_title') ) );
		$this->layout->contentFooter = View::make( 'footer', array( 'env' => $this->getEnvironment(), 'footerText' => Lang::get('messages.footer_text') ) );
		if ( !$this->isValidHash( $hash ) || !$this->isValidServer( $servnum ) || $res != null ) {
			$this->layout->contentBody = View::make( 'invalid_url' );
		} else {
			$allowedServers = $this->config['allowed_servers'];
			if ( !in_array($servnum, $allowedServers) )
				return Redirect::to('/#');

			$token = substr($hash, self::RANDOM_PASSPHRASE_LENGHT);
			$captcha = $this->redisService->getCaptcha($token);
			if ( $captcha == null ) {
				$captcha = "false";
			}
			$this->layout->contentBody = View::make( 'message_result', array( 'env' => $this->getEnvironment(), 'hash' => $hash, 'serv' => $servnum, 'req_cap' => $captcha ) );
		}
	}

	public function dnStat() {
		$cStat = $this->getStatusCode();

		if ( $cStat != null ) {
	        $cStat = json_decode( $cStat );
        	$status = $cStat->status;
		} else {
			$this->layout->contentBody = View::make( 'status_result', array( 'env' => $this->getEnvironment(), 'status'=>'FAIL', 'trkStatus'=>Lang::get('messages.trk_no_track') ) );
			return;
		}

		$statusMsg = "";
		if ( $status == 0 )
		{
			$statusMsg = Lang::get('messages.trk_unread');
		} elseif ( $status == 1 ) {
			$statusMsg = Lang::get('messages.trk_read');
		} else {
			$statusMsg = Lang::get('messages.trk_no_track');
		}
		$this->layout->contentBody = View::make( 'status_result', array( 'env' => $this->getEnvironment(), 'status'=>'OK', 'trkStatus'=>$statusMsg ) );
	}

	public function gtrkStatus()
	{
		$cStat = $this->getStatusCode();
		if ( $cStat != null ) {
	        $cStat = json_decode( $cStat );
        	$status = $cStat->status;
		} else {
			return Response::json(array('status'=>'FAIL', 'trkStatus'=>null));
		}
		return Response::json(array('status'=>'OK', 'trkStatus'=>$status));
	}

	private function getStatusCode()
	{
		$ip = Request::getClientIp();
		if ( $this->config['enabled_anti_fire'] )
		{
			$this->redisService->waitIP( $ip );
		}

		$trk = Winput::get('trk');

		if ( !$this->isValidTrk($trk) ) {
			return null;
		}
	
		$trackingNumber = self::TRACKING_NUMBER_CODE . $trk;
		$cStat = $this->redisService->getTracking($trackingNumber);
		return $cStat;
	}

	public function readMessageios() 
	{
		$ip = Request::getClientIp();
		if ( $this->config['enabled_anti_fire'] )
		{
			$this->redisService->waitIP( $ip );
		}

		$userToken = Winput::get('hash');
		$from = Winput::get('from');
		$servnum = Winput::get('servnum');

		if ( !$this->isValidHash( $userToken ) || !$this->isValidServer( $servnum ) ) {
			return Response::json(array('status'=>'FAIL', 'data'=>null, 'imprint'=> null, 'message'=>"Error", 'noMore'=>null, 'nversion'=>true, 'read'=>null, 'namesFiles'=>null, 'encFiles'=>null));
		}

		$allowedServers = $this->config['allowed_servers'];
		if ( !in_array($servnum, $allowedServers) ) {
			return Response::json(array('status'=>'FAIL', 'data'=>null, 'imprint'=> null, 'message'=>"Error", 'noMore'=>null, 'nversion'=>true, 'read'=>null, 'namesFiles'=>null, 'encFiles'=>null));
		}

		// Firma
		$imprint = null;

		// Obtengo el randomPassphrase que necesito para desencriptar el mensaje y el key
		$userToken = substr( $userToken, strlen(self::STATIC_PASSPHRASE) );
		$randomPassphrase = substr($userToken,0,self::RANDOM_PASSPHRASE_LENGHT);

		$hash = substr($userToken, self::RANDOM_PASSPHRASE_LENGHT);

		// Esta linea trae el mensaje y en el mismo commando lo setea vacio
		// ( Esta bueno como medida de seguridad porque si el mesaje fue leido -> fue borrado )
		$msg = $this->redisService->getset($hash,'');
		$files = $this->redisService->getsetfiles($hash,'');

		$class = 'success';
		$isRead = false;
		if ( $msg == null ) {
			$msg = Lang::get('messages.expired');
			$class = 'warning';

			$st = $this->redisService->getTracking($hash);
			$cStat = $this->redisService->getTracking($st);
			$cStat = json_decode( $cStat );
			if ( $cStat->status == 1 ) {
				$isRead = true;
				$msg = Lang::get('messages.expired_read');
			}
		} else {
			// Descopmprimo
			$msg = gzuncompress( $msg );
			// Desencripto
			$msg = $this->hasherUtil->decrypt($msg, $randomPassphrase.self::PASSPHRASE_SALT);
			$msgAux = json_decode($msg);
			if ( $msgAux->ip != null )
			{
				$imprint = $msgAux->ip;
			}

			$msg = $msgAux->msg;

			// Update tracking status to READED
			$trackingNumber = $this->redisService->getTracking($hash);
			if ( $trackingNumber != null )
			{
				$cStat = array('blue'=>$hash, 'status'=>self::TRACKING_STATUS_READED);
				$this->redisService->setTracking( $trackingNumber, json_encode($cStat) );
			}
		}

		// De todas formas automaticamente expiro el mensaje
		$this->redisService->expire($hash, 0);
		$this->redisService->expirefiles($hash, 0);

		// Obtengo los files
		$namesFiles = null;
		$encFiles = null;
		if ( $files != null )
		{
			$nFiles = json_decode( $files );
			$namesFiles = array();
			$injectDate = null;
			if ( isset( $nFiles[0]->name ) )
			{
				$injectDate = $nFiles[0]->date;
				$namesFiles[0] = $nFiles[0]->name;
			} else {
				$namesFiles = $nFiles;
			}

			$encFiles = array();
			foreach( $namesFiles as $key => $oneFile )
			{
				if ( $injectDate != null ) {
					$path = app_path() . "/encfiles/" . $servnum . "/" . $injectDate . "/" . md5($hash) . $key . ".enc";
				} else {
					$path = app_path() . "/encfiles/" . $servnum . "/" . md5($hash) . $key . ".enc";
				}
				$oneEncFile = fopen($path, "r") or die("Unable to open file!");
				$encFiles[$key] = $this->hasherUtil->decrypt( fread($oneEncFile,filesize($path)), $randomPassphrase.self::PASSPHRASE_SALT);

				$order   = array("\\n");
				$replace = '';
				$encFiles[$key] = str_replace($order, $replace, $encFiles[$key]);

				// Borro el file del filesystem de forma segura
				fclose($oneEncFile);
				$cmd = "srm " . $path;
				exec($cmd . " > /dev/null &");
			}
		}

		if ( $from != null && ( strpos($from,'app_android') !== false || strpos($from,'app_ios') !== false ) ) {
			if ( $namesFiles == null )
			{
				$namesFiles = array();
				$encFiles = array();
			}
			if ( $imprint == null )
				$imprint = "";
		}

		if ( $class == 'warning' ) {
			$data = View::make( 'message_area', array( 'env' => $this->getEnvironment(), 'data' => $msg, 'class' => $class, 'siteUrl' => url('/', array(), $this->config['secure_site']) ) )->render();
		} else {
			$data = View::make( 'message_area', array( 'env' => $this->getEnvironment(), 'data' => '', 'class' => $class, 'siteUrl' => url('/', array(), $this->config['secure_site']) ) )->render();
		}

		$noMore = false;
		if ( $class == 'warning' ) {
			$noMore = true;
		}

		// Acondicionar los json
		$order   = array("\\\\n");
		$replace = '';
		$msg = str_replace($order, $replace, $msg);

		$order   = array("\\\\","\\\\","\\\\");
		$replace = '';
		$msg = str_replace($order, $replace, $msg);

		$order   = array('\"');
		$replace = '"';
		$msg = str_replace($order, $replace, $msg);

		$order   = array('"{');
		$replace = '{';
		$msg = str_replace($order, $replace, $msg);

		$order   = array('}"');
		$replace = '}';
		$msg = str_replace($order, $replace, $msg);

		return Response::json(array('status'=>'OK', 'data'=>$data, 'imprint'=> $imprint, 'message'=>$msg, 'noMore'=>$noMore, 'nversion'=>true, 'read'=>$isRead, 'namesFiles'=>$namesFiles, 'encFiles'=>$encFiles));
	}

	public function readMessage()
	{
		$ip = Request::getClientIp();
		if ( $this->config['enabled_anti_fire'] )
		{
			$this->redisService->waitIP( $ip );
		}

		$userToken = Winput::get('hash');
		$from = Winput::get('from');
		$servnum = Winput::get('servnum');

		//*******************
		if ( $from == null )
		{
			return Response::json(array('status'=>'FAIL', 'data'=>null, 'imprint'=> null, 'message'=>"Error", 'noMore'=>null, 'nversion'=>true, 'read'=>null, 'namesFiles'=>null, 'encFiles'=>null));
		}

		if ( $from == 'app_android' )
		{
			return Response::json(array('status'=>'FAIL', 'data'=>null, 'imprint'=> null, 'message'=>"Error", 'noMore'=>null, 'nversion'=>true, 'read'=>null, 'namesFiles'=>null, 'encFiles'=>null));
		}

		if( strpos($from,'app_android') !== false && substr($from, -2) != '71' && substr($from, -2) != '72' && substr($from, -2) != '73' ) 
		{
			return Response::json(array('status'=>'FAIL', 'data'=>null, 'imprint'=> null, 'message'=>"Error", 'noMore'=>null, 'nversion'=>true, 'read'=>null, 'namesFiles'=>null, 'encFiles'=>null));			
		}
		//*******************

		if ( !$this->isValidHash( $userToken ) || !$this->isValidServer( $servnum ) ) {
			return Response::json(array('status'=>'FAIL', 'data'=>null, 'imprint'=> null, 'message'=>"Error", 'noMore'=>null, 'nversion'=>true, 'read'=>null, 'namesFiles'=>null, 'encFiles'=>null));
		}

		$allowedServers = $this->config['allowed_servers'];
		if ( !in_array($servnum, $allowedServers) ) {
			return Response::json(array('status'=>'FAIL', 'data'=>null, 'imprint'=> null, 'message'=>"Error", 'noMore'=>null, 'nversion'=>true, 'read'=>null, 'namesFiles'=>null, 'encFiles'=>null));
		}

		// Firma
		$imprint = null;

		// Obtengo el randomPassphrase que necesito para desencriptar el mensaje y el key
		$userToken = substr( $userToken, strlen(self::STATIC_PASSPHRASE) );
		$randomPassphrase = substr($userToken,0,self::RANDOM_PASSPHRASE_LENGHT);

		$hash = substr($userToken, self::RANDOM_PASSPHRASE_LENGHT);

		// Esta linea trae el mensaje y en el mismo commando lo setea vacio
		// ( Esta bueno como medida de seguridad porque si el mesaje fue leido -> fue borrado )
		$msg = $this->redisService->getset($hash,'');
		$files = $this->redisService->getsetfiles($hash,'');

		$class = 'success';
		$isRead = false;
		if ( $msg == null ) {
			$msg = Lang::get('messages.expired');
			$class = 'warning';

			$st = $this->redisService->getTracking($hash);
			$cStat = $this->redisService->getTracking($st);
			$cStat = json_decode( $cStat );
			if ( $cStat->status == 1 ) {
				$isRead = true;
				$msg = Lang::get('messages.expired_read');
			}
		} else {
			// Descopmprimo
			$msg = gzuncompress( $msg );
			// Desencripto
			$msg = $this->hasherUtil->decrypt($msg, $randomPassphrase.self::PASSPHRASE_SALT);
			$msgAux = json_decode($msg);
			if ( $msgAux->ip != null )
			{
				$imprint = $msgAux->ip;
			}

			$msg = $msgAux->msg;

			// Update tracking status to READED
			$trackingNumber = $this->redisService->getTracking($hash);
			if ( $trackingNumber != null )
			{
				$cStat = array('blue'=>$hash, 'status'=>self::TRACKING_STATUS_READED);
				$this->redisService->setTracking( $trackingNumber, json_encode($cStat) );
			}
		}

		// De todas formas automaticamente expiro el mensaje
		$this->redisService->expire($hash, 0);
		$this->redisService->expirefiles($hash, 0);

		// Obtengo los files
		$namesFiles = null;
		$encFiles = null;
		if ( $files != null )
		{
			$nFiles = json_decode( $files );
			$namesFiles = array();
			$injectDate = null;
			if ( isset( $nFiles[0]->name ) )
			{
				$injectDate = $nFiles[0]->date;
				$namesFiles[0] = $nFiles[0]->name;
			} else {
				$namesFiles = $nFiles;
			}

			$encFiles = array();
			foreach( $namesFiles as $key => $oneFile )
			{
				if ( $injectDate != null ) {
					$path = app_path() . "/encfiles/" . $servnum . "/" . $injectDate . "/" . md5($hash) . $key . ".enc";
				} else {
					$path = app_path() . "/encfiles/" . $servnum . "/" . md5($hash) . $key . ".enc";
				}
				$oneEncFile = fopen($path, "r") or die("Unable to open file!");
				$encFiles[$key] = $this->hasherUtil->decrypt( fread($oneEncFile,filesize($path)), $randomPassphrase.self::PASSPHRASE_SALT);

				$order   = array("\\n");
				$replace = '';
				$encFiles[$key] = str_replace($order, $replace, $encFiles[$key]);

				// Borro el file del filesystem de forma segura
				fclose($oneEncFile);
				$cmd = "srm " . $path;
				exec($cmd . " > /dev/null &");
			}
		}

		if ( $from != null && ( strpos($from,'app_android') !== false || strpos($from,'app_ios') !== false ) ) {
			if ( $namesFiles == null )
			{
				$namesFiles = array();
				$encFiles = array();
			}
			if ( $imprint == null )
				$imprint = "";
		}

		if ( $class == 'warning' ) {
			$data = View::make( 'message_area', array( 'env' => $this->getEnvironment(), 'data' => $msg, 'class' => $class, 'siteUrl' => url('/', array(), $this->config['secure_site']) ) )->render();
		} else {
			$data = View::make( 'message_area', array( 'env' => $this->getEnvironment(), 'data' => '', 'class' => $class, 'siteUrl' => url('/', array(), $this->config['secure_site']) ) )->render();
		}

		$noMore = false;
		if ( $class == 'warning' ) {
			$noMore = true;
		}

		// Acondicionar los json
		$order   = array("\\\\n");
		$replace = '';
		$msg = str_replace($order, $replace, $msg);

		$order   = array("\\\\","\\\\","\\\\");
		$replace = '';
		$msg = str_replace($order, $replace, $msg);

		$order   = array('\"');
		$replace = '"';
		$msg = str_replace($order, $replace, $msg);

		$order   = array('"{');
		$replace = '{';
		$msg = str_replace($order, $replace, $msg);

		$order   = array('}"');
		$replace = '}';
		$msg = str_replace($order, $replace, $msg);

		return Response::json(array('status'=>'OK', 'data'=>$data, 'imprint'=> $imprint, 'message'=>$msg, 'noMore'=>$noMore, 'nversion'=>true, 'read'=>$isRead, 'namesFiles'=>$namesFiles, 'encFiles'=>$encFiles));
	}

}
