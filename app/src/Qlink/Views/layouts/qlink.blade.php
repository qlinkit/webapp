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
    {{ Qlink\Controllers\LandingNewController::style("/css/global.min.css?1970") }}

    {{ Qlink\Controllers\LandingNewController::script("/js/jquery-2.1.1.min.js") }}
    {{ Qlink\Controllers\LandingNewController::script("/js/jquery.mobile.custom.min.js") }}
    {{ Qlink\Controllers\LandingNewController::script("/js/jquery.blockUI.min.js") }}
    {{ Qlink\Controllers\LandingNewController::script("/js/jquery-ui.min.js") }}
    {{ Qlink\Controllers\LandingNewController::script("/js/jquery-collision.min.js") }}
    {{ Qlink\Controllers\LandingNewController::script("/js/bootstrap.min.js") }}
    {{ Qlink\Controllers\LandingNewController::script("/js/bootstrap.file-input.min.js") }}
    {{ Qlink\Controllers\LandingNewController::script("/js/jquery.autosize.min.js") }}
    {{ Qlink\Controllers\LandingNewController::script("/js/jquery.placeholder.min.js") }}
    {{ Qlink\Controllers\LandingNewController::script("/js/application.js?1970") }}
    {{ Qlink\Controllers\LandingNewController::script("/js/xss.min.js") }}
    {{ Qlink\Controllers\LandingNewController::script("/js/jquery.zeroclipboard.min.js") }}
    {{ Qlink\Controllers\LandingNewController::script("/js/sha256.js") }}
    {{ Qlink\Controllers\LandingNewController::script("/js/aes.js") }}
    {{ Qlink\Controllers\LandingNewController::script("/js/pbkdf2.js") }}
    {{ Qlink\Controllers\LandingNewController::script("/js/lzw.min.js") }}
</head>
<body>
    <div class="public-container">
        <div class="public-left">
        </div>
        <div class="public-right">
            <div class="public-img">
                <div class="public-gradient">
                </div>
            </div>
        </div>
    </div>
    <script>jsConfig = JSON.parse('<?php echo $jsConfig;?>');</script>
    <div class="page">

        <div id="operative">
            {{ $contentBody }}
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
    </div>
    <script>
        var aux = '<?php echo $localeMessages;?>';
        aux = aux.replace(/\n/g, '');
        localeMessages = JSON.parse(aux);
    </script>
</body>
</html>
