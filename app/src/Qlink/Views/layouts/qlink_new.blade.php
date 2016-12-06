<!doctype html>
<!--[if IE 8 ]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9 ]> <html lang="en" class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en"> <!--<![endif]-->
<html>
<head>
	<title>{{ Lang::get('corp.meta_title') }}</title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="description" content="{{ Lang::get('corp.meta_desc') }}">
	<meta name="keywords" content="{{ Lang::get('corp.meta_keywords') }}">
	<meta name="twitter:site" content="@qlink_it" />
	<meta name="twitter:card" content="summary" />
	<meta name="twitter:title" content="{{ Lang::get('corp.meta_title') }}" />
	<meta name="twitter:url" content="https://qlink.it" />
	<meta name="twitter:image" content="{{ Lang::get('corp.meta_image') }}" />
	<meta name="twitter:description" content="{{ Lang::get('corp.meta_desc') }}" />
	<meta property="og:title" content="{{ Lang::get('corp.meta_title') }}" />
	<meta property="og:description" content="{{ Lang::get('corp.meta_desc') }}" />
	<meta property="og:image" content="{{ Lang::get('corp.meta_image') }}" />
	<meta property="og:image:secure_url" content="{{ Lang::get('corp.meta_image_ssl') }}" />
	<meta property="og:url" content="https://qlink.it" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scaleable=no">
	<link rel="shortcut icon" href="" />
	<link rel="icon" href="favicon.ico"/>
	<meta name="author" content="qlink team"/>


	<!--[if lte IE 8]><script src="new/js/ie/html5shiv.js"></script><![endif]-->
	<link rel="stylesheet" href="/new/css/main.css?2130" />
	<!--[if lte IE 9]><link rel="stylesheet" href="new/css/ie9.css" /><![endif]-->
	<!--[if lte IE 8]><link rel="stylesheet" href="new/css/ie8.css" /><![endif]-->
	<link rel="stylesheet" href="/new/css/circles.css" type="text/css">

	<script src="/new/js/skel.min.js"></script>
	<script src="/js/jquery-2.1.1.min.js"></script>
	<script src="/new/js/jquery.scrollex.min.js"></script>


	{{ Qlink\Controllers\LandingNewController::script("/js/jquery.mobile.custom.min.js") }}
	{{ Qlink\Controllers\LandingNewController::script("/js/jquery.blockUI.min.js") }}
	{{ Qlink\Controllers\LandingNewController::script("/js/jquery-ui.min.js") }}
	{{ Qlink\Controllers\LandingNewController::script("/js/jquery.ui.touch-punch.min.js") }}
	{{ Qlink\Controllers\LandingNewController::script("/js/jquery-collision.min.js") }}
	{{ Qlink\Controllers\LandingNewController::script("/js/qrcode.js") }}
	{{ Qlink\Controllers\LandingNewController::script("/js/bootstrap.min.js") }}
	{{ Qlink\Controllers\LandingNewController::script("/js/bootstrap.file-input.js") }}

	{{ Qlink\Controllers\LandingNewController::script("/js/jquery.autosize.min.js") }}
	{{ Qlink\Controllers\LandingNewController::script("/js/jquery.placeholder.min.js") }}
	{{ Qlink\Controllers\LandingNewController::script("/js/application.min.js?2130") }}
	{{ Qlink\Controllers\LandingNewController::script("/js/xss.min.js") }}
	{{ Qlink\Controllers\LandingNewController::script("/js/jquery.zeroclipboard.min.js") }}
	{{ Qlink\Controllers\LandingNewController::script("/js/sha256.js") }}
	{{ Qlink\Controllers\LandingNewController::script("/js/aes.js") }}
	{{ Qlink\Controllers\LandingNewController::script("/js/pbkdf2.js") }}
	{{ Qlink\Controllers\LandingNewController::script("/js/lzw.min.js") }}
</head>
<body>

	<body>
		<script>jsConfig = JSON.parse('<?php echo $jsConfig;?>');</script>

		<div id="operative">
			{{ $contentBody }}
		</div>

		<div id="warnings" class="qlink-content" style="display:none;">
			<div class="quick_alert_message quick_warnings_message">
				<div class="quick_warnings_message_title">
					<p class="quick_warnings_message_title_text">{{ Lang::get('messages.warnings_title') }}</p>
					<p id="uncheck-warnings" class="quick_warnings_message_title_close">X</p>
				</div>
				<br />
				<div class="quick_alert_message_msg">
					{{ Lang::get('messages.warnings_detail') }}
				</div>
			</div>
		</div>


		<div class="footer clearfix"></div><!-- end footer -->
		<div id="question" class="question-message" style="display:none; cursor: default"> 
			<p>{{ Lang::get('messages.internet_fail') }}</p> 
			<input type="button" id="yes" value="{{ Lang::get('messages.internet_reinte') }}" /> 
			<input type="button" id="no" value="{{ Lang::get('messages.internet_cancel') }}" /> 
		</div>
		<div id="question-entropy" class="question-message" style="display:none;cursor: default;font-size: 13px;padding: 14px;"> 
			<p>{{ Lang::get('messages.move_mouse') }}. {{ Lang::get('messages.move_mouse_desc') }}</p> 
			<input type="button" id="ok-entropy" style="margin-top: 10px;" value="{{ Lang::get('messages.ajax_error_ok') }}" />
		</div>
		<div id="ajax-error" class="question-message" style="display:none; cursor: default">
			<p>{{ Lang::get('messages.ajax_error') }}</p> 
			<input type="button" id="ok" value="{{ Lang::get('messages.ajax_error_ok') }}" />
		</div>

		<div id="unsupport" class="unsupport" style="display:none">
			<div id="quick_usupport_message" class="quick_usupport_message">
				<div class="quick_unsupport_message_title">
					<p>{{ Lang::get('messages.unsupported_title') }}</p>
				</div>
				<div class="quick_alert_message_msg">
					<p>{{ Lang::get('messages.unsupported_msg') }}</p>
					<img src="/images/supportbr.jpg"/>
				</div>
			</div>
		</div>

		<div id="public-mark" class="quick_alert_message" style="display:none">
			<div style="width:100%; height:100%;">
				<div class="quick_alert_message_title">
					<p class="quick_alert_message_title_text"></p>
					<p class="quick_alert_message_title_close" style="text-align: right;margin-right: 8px;font-weight: bold;" onclick="javascript:$('#forpub').unblock();$('#forpub').hide();">X</p>
				</div>
				<div class="quick_alert_message_msg">
					<div class="marketing-div-public">
						<a href="https://play.google.com/store/apps/details?id=com.qlink.easytech.ar" target="_blank">
							<img src="/images/andprom.png" class="marketing-img-public" style="width:100%;">
						</a>
					</div>
				</div>
			</div>
		</div>
		<!-- Scripts -->

		<div id="forpub" style="position: fixed; width:100%; height:100%; background:none;top: 0;display:none;"></div>
		<script src="/new/js/util.js"></script>
		<!--[if lte IE 8]><script src="new/js/ie/respond.min.js"></script><![endif]-->
		<script src="/new/js/main.js"></script>

		<script>
		var aux = '<?php echo $localeMessages;?>';
		aux = aux.replace(/\n/g, '');
		localeMessages = JSON.parse(aux);

		$(document).ready(function() {
			$("#check-warnings").click(
				function() {
					$('#warnings').fadeIn( "slow", function() {
						$("html, body").animate({ scrollTop: $(document).height()-$(window).height() });
					});

				}
			);
			$("#uncheck-warnings").click(
				function() {
					$('#warnings').fadeOut( "slow", function() {
					});
				}
			);
		});
		</script>
	</body>
	</html>
