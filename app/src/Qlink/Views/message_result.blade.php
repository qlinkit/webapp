<style>
#draggable { 
    width: 65px;
    height: 65px;
    z-index: 1000;
    border: 0px solid #000;
    border-radius: 41px;
    padding: 0.5em;
    float: left;
    margin: 10px 10px 10px 0;
    background: rgb(46, 255, 0);
    font-size: 13px;
    text-align: center;
    display:none;
}
#droppable { 
    width: 150px;
    height: 150px;
    text-align: center;
    font-weight: bold;
    padding: 0.5em;
    margin: auto;
    margin-top: 20px;
    background: rgb(236, 236, 236);
    border: 0px solid;
    color: #4E4E4E;
    display:none;
    font-size: 0.8em;
  }
</style>

<link rel="stylesheet" href="/new/css/gradient.css" type="text/css">
<!-- Header -->
      <header id="header" class="alt">
          <div class="language">
                  <ul class="language-ul">
                      <li class="language-li">
                          <a href="/"><img src="/images/qlink_it_meta.png" class="icon_h"/></a>
                      </li>
                      <li class="language-li">
                          <a id="es" href="/?lang=es">Español</a>
                      </li>
                      <li class="language-li">
                          <a id="en" href="/?lang=en">English</a>
                      </li>
                      <li class="language-li">
                          <a id="it" href="/?lang=it">Italian</a>
                      </li>
                      <li class="language-li">
                          <a id="zh" href="/?lang=zh">中文</a>
                      </li>
                      <li class="language-li">
                          <a id="ru" href="/?lang=ru">Pусский</a>
                      </li>
                      <li class="language-li">
                          <a id="fr" href="/?lang=fr">Français</a>
                      </li>
                  </ul>
          </div>
      </header>

<section id="footer" class="footer-read">
          <div class="inner">
              <h2 class="major" id="read-title" style="display:none;"><strong id="major-text">{{ Lang::get('messages.reading_it') }}</strong></h2>

<div class="read-msj">
  <div class="header logo-center clearfix">
    <div class="header-inner clearfix">
      <div class="logo">
        <a href="/"></a>
        <div class="version" style="display:none;">beta</div>
      </div>
    </div>
  </div><!-- end header -->
  <div class="content clearfix">
   <div id="invalid" class="unsupport" style="display:none">
    <div id="quick_usupport_message" class="quick_usupport_message">
      <div class="quick_unsupport_message_title">
       <p>{{ Lang::get('messages.invalid_url_title') }}</p>
     </div>
     <div class="quick_alert_message_msg">
       <p>{{ Lang::get('messages.invalid_url_msg') }}</p>
     </div>
   </div>
 </div>
 <div id="container-read" class="content-inner">
  <div class="qlink-ios" style="display:none; text-align: center;">
    <div style="display:block;margin-top:80px;">
    {{ Form::button(  Lang::get('messages.read_in_web'),
      array('class' => 'qlink-it-forward qlink-it-forward-mobile button','style' => 'box-shadow: 0px 0px 20px 0px #000;', 'id' => 'read-web-qlink-button', 
      'onclick' => 'readFromIosMenu()', )) }} 
    </div>
    <div style="display:block;margin-top:20px;">
    {{ Form::button(  Lang::get('messages.read_in_ios'),
      array('class' => 'qlink-it-forward qlink-it-forward-mobile button','style' => 'box-shadow: 0px 0px 20px 0px #000;', 'id' => 'read-ios-qlink-button', 
      'onclick' => 'readMeIO()', )) }}
    </div>
  </div>
  <div id="quick_help_message" class="quick_alert_message" style="display:none">
    <div class="quick_alert_message_title">
        <p class="quick_alert_message_title_text">{{ Lang::get('messages.headup') }}</p>
        <p class="quick_alert_message_title_close" onclick="javascript:$('#quick_help_message').hide();">X</p>
    </div>
    <div class="quick_alert_message_msg">
      {{ Lang::get('messages.no_close') }}
    </div>
  </div>
  <div class="qlink-read" style="display:none">
    <div class="header-msj clearfix">
      <div class="icon"></div>
      <div class="title">...</div>
      <div class="attach-file"></div>
    </div>
    <div class="qlink-msj" id="msg-scroll-container">
      <div class="qlink-msj-inner" id="result_container_area"></div>
    </div>
    <div id="imprint_data" class="imprint_data">
      <span id="imprint_text"></span>
    </div>
    <div class="mjs-attach-files">
      <div class="mjs-attach-files-inner">
        <div class="attach-header">
          <h4>{{ Lang::get('messages.attachs') }}</h4>
        </div>
        <ul class="attach-file contact">
          <div id="links-area"></div>
        </ul>            
      </div>
    </div>
  </div>
  <div class="qlink-footer">
    {{ Form::button(  Lang::get('messages.new_qlink'), 
    array('class' => 'qlink-it button new-qlink-button icon fa-key','id' => 'reply-qlink-button','style' => 'display:none',
    'onclick' => 'doReply()', )) }}  
    {{ Form::button(  Lang::get('messages.reply_qlink'), 
    array('class' => 'qlink-it-forward button icon fa-mail-reply','id' => 'forward-qlink-button', 'style' => 'display:none',
    'onclick' => 'doForward()', )) }}  
    {{ Form::button(  '?', 
    array('class' => 'qlink-it-forward-help button','id' => 'forward-qlink-button-help', 'data-tooltip' => Lang::get('messages.use_answer_help'), 'style' => 'display:none',
    'onclick' => '', )) }} 
    {{ Form::button(  Lang::get('messages.new_qlink'),
    array('class' => 'qlink-it button new-qlink-button icon fa-key','id' => 'new-qlink-button','style' => 'display:none',
    'onclick' => 'location.href="/"', )) }}
  </div>
  <div id="draggable" class="ui-widget-content" style="cursor:pointer">
  </div>

  <div id="droppable" class="ui-widget-header">
    <p style="cursor:pointer">{{ Lang::get('messages.drag_text') }}</p>
  </div>
</div>
</div><!-- end content -->

<div class="footer clearfix"></div><!-- end footer -->
<div id="ajax-error" class="question-message" style="display:none; cursor: default">
  <p>{{ Lang::get('messages.ajax_error') }}</p>             
  <input type="button" id="ok" value="{{ Lang::get('messages.ajax_error_ok') }}" />
</div>

</div>
<div id="response-container" style="display:none">

  <div id="xres" style="float:left"></div>
  <ul class="contact" style="display: inline-table;">
                  <li class="fa-envelope">
                      {{ Lang::get('messages.getdn') }}
                      <br />
                      <div class="field">
                          <label for="trk">DN</label>
                          <div style="display: inline-block;">
                              <input class="trk-input-container-inp" type="text" style="max-width: 140px;float: left;margin-bottom: 5px;" id="trk" value="" placeholder="__________"/>
                              <button id="trk-update" class="trk-update button icon fa-question-circle">{{ Lang::get('messages.check') }}</button>
                          </div>
                          <p id="trk-status" class="trk-input-container-status"></p>
                      </div>
                  </li>
                  <li class="fa-unlock-alt" id="li-entropy-container">
                    {{ Lang::get('messages.strength_text') }}<br />
                    <label>MONITOR</label>
                    <div id="entropy-container" style="width:100%;height:18px;background:#dddddd;text-align: center;position: relative;">
                      <div id="entropy-system-bar" style="width:30%;height:18px;background:rgba(76, 232, 241, 0.78);position: relative;float:left;">
                      </div>
                      <div id="entropy-bar" class="gradient-pattern" style="width:0%;height:18px;position: relative;float:left;">
                      </div>
                      <div style="position: absolute;width: 100%;">
                        <div style="width:30%;height:18px;position: relative;float:left;">
                          <span style="display:block;font-size: 10px;font-weight: bold;padding-top: 2px;color: #EAFFFF !important;">{{ Lang::get('messages.system_entropy') }}</span>
                        </div>
                        <div style="width:65%;height:18px;position: relative;float:left;">
                          <span style="display:block;font-size: 10px;font-weight: bold;padding-top: 2px;color: #EAFFFF !important;">{{ Lang::get('messages.user_entropy') }}</span>
                        </div>
                        <style>
                          .flecha_derecha {
                                    width: 0;
                                    height: 0;
                                    margin-top: 3px;
                                    border-top: 6px solid transparent;
                                    border-bottom: 6px solid transparent;
                                    border-left: 11px solid #fff;
                                    cursor: pointer;
                          }
                        </style>
                        <div id="toggle_entropy_viewer" class="flecha_derecha" style="position: relative;float:right;">
                        </div>
                      </div>
                      <div style="position: relative;width: 100%;">
                        <div class="strength-container">
                          <span class="move-mouse-entropy" data-tooltip-l="{{ Lang::get('messages.move_mouse') }}. {{ Lang::get('messages.move_mouse_desc') }}"><strong style="display: inline; margin-left: 10px;font-size: 11px;margin-top: -2px;color: #1BD9DC;">?</strong></span>
                          <span class="strength-label" id="strength-label">{{ Lang::get('messages.WEAK') }}</span>
                        </div>
                      </div>
                      <div style="position: relative;width: 100%;">
                        <div style="width:100%;height:18px;position: relative;float:left;">
                          <span id="entropy-viewer-msg" style="background-color: gray;text-align: left;word-break: break-all;display:none;font-size: 11px;float:left;font-weight: bold;padding-top: 2px;color: #ffffff;text-shadow: 0px 0px 6px #000;padding-left: 6px;padding-top: 6px;padding: 8px;border: 1px solid #fff;margin-top: 10px;"></span>
                          <span id="entropy-viewer" style="background-color: rgba(128, 128, 128, 0.41);text-align: left;word-break: break-all;display:none;font-size: 9px;float:left;font-weight: bold;padding-top: 2px;color: #ffffff;text-shadow: 0px 0px 6px #000;padding-left: 6px;padding-top: 6px;padding: 15px;margin-top: 28px;border-radius: 5px;box-shadow: inset 0 0 0 2px rgba(179, 238, 241, 0.91);"></span>
                        </div>
                      </div>
                    </div>
                  </li>
                  <li class="fa-truck" id="get-track">
                      {{ Lang::get('messages.trk_show_link') }}<br />
                      <div class="trk-number-container">
                        <button class="trk-show button icon fa-truck" onclick="$('.trk-number').show();$(this).hide();$('#trk').val($('#trkspan').html());">{{ Lang::get('messages.trk_number') }}</button>
                        <div class="trk-number" style="display:none">
                          <p>{{ Lang::get('messages.trk_description') }}</p>
                          <div class="trk-fast">  
                            <div class="trk-input-container">
                              <label class="trk-input-container-desc trk-mobile-none">{{ Lang::get('messages.trk_number') }}</label>
                              <div class="trk-input-container-desc">DN <span class="trk-input-container-inp" id="trkspan"/></div>
                            </div>
                          </div>
                        </div>  
                      </div>
                  </li>
                  <!-- <li class="fa-phone">(000) 000-0000</li>
                  <li class="fa-envelope"><a href="#">information@untitled.tld</a></li>
                  <li class="fa-twitter"><a href="#">twitter.com/untitled-tld</a></li>
                  <li class="fa-facebook"><a href="#">facebook.com/untitled-tld</a></li>
                  <li class="fa-instagram"><a href="#">instagram.com/untitled-tld</a></li> -->
              </ul>
              
</div>

<div>

<ul class="copyright" style="display:none;">
    <li>&copy; Qlink.it - 2015 All rights reserved.</li>
    <li>Qlinkit Security</li>
    <li>
      <div id="quick_warning_message" style="background-color: #FFE614;
                                          color: #282828;
                                          font-size: 11px;
                                          padding: 5px;
                                          text-align: right;
                                          float:left;
                                          ">
        <div class="quick_success_message_title">
          <p class="quick_success_message_title_text">{{ Lang::get('messages.read_warnings') }}</p>
        </div>
      </div>
    </li>
    <li style="display: inherit;float: right;">
      <div class="social-icons ">
          <div class="social-icon social-icon-gp"><a href="https://play.google.com/store/apps/details?id=com.qlink.easytech.ar" alt="google play" target="_blank"></a></div>      
          <div class="social-icon social-icon-tw"><a href="https://twitter.com/qlink_it" target="_blank"></a></div>
          <div class="social-icon social-icon-fb"><a href="https://www.facebook.com/qlink.it" target="_blank"></a></div>
          <div class="social-icon social-icon-ap"><a href="https://itunes.apple.com/us/app/qlink.it/id984967263?ls=1&mt=8" alt="app store" target="_blank"></a></div>
          <div class="social-icon social-icon-yt"><a href="https://www.youtube.com/channel/UCPBSupntu1u97I9fXZDBX9A" alt="you tube" target="_blank"></a></div>
      </div>
    </li>
</ul>

</section>
<script type="text/javascript">
$(document).ready(function() {
	var supportedBr = checkBrSupport();       
  if ( !supportedBr )
    return;

  if ( msieVersion() ) {
    var s = document.createElement("script");
    s.type = "text/javascript";
    s.src = "https://qlink.it/js/FileSaver.js";
    $("head").append(s);
  }

  var iOS = ( navigator.userAgent.match(/(iPad|iPhone|iPod)/g) ? true : false );
  if ( iOS )
  {
    $('.qlink-ios').show();
    $( "#droppable" ).hide();
    $( "#draggable" ).hide();
  } else {
    if ( "{{$req_cap}}" == "true" ) 
    {
      genHumanID();  
    } else {
      readMe();
    }
    
  }
});

function genHumanID() {
  var ww = $(window).width();
  var wh = $(window).height();

  var xPos = Math.floor(Math.random() * (ww - 225 - 0 + 1)) + 50;
  var yPos = Math.floor(Math.random() * (wh - 255 - 0 + 1)) + 60;

  $( "#droppable" ).show();
  $( "#draggable" ).show();
  $( "#droppable" ).css({top: yPos, left: xPos, position:'absolute'});
  do {
    xPos = Math.floor(Math.random() * (ww - 145 - 0 + 1)) + 50;
    yPos = Math.floor(Math.random() * (wh - 165 - 0 + 1)) + 60;
    $( "#draggable" ).css({top: yPos, left: xPos, position:'absolute'});
    var hit = $("#droppable").collision("#draggable");
  } while( hit.length > 0 );
  //readMe();

  $( "#draggable" ).css({top: yPos, left: xPos, position:'absolute'});
  $( "#draggable" ).draggable();
  $( "#droppable" ).droppable({
    drop: function( event, ui ) {
      $( this ).hide();
      $( "#draggable" ).hide();
      $('.qlink-ios').hide();
      $( ".qlink-read" ).show();
      $(".copyright").show();
      $("#header").remove();
      readQlink('{{$serv}}','{{$hash}}');
    }
  });
}

function readFromIosMenu() {
    $('.qlink-ios').hide();
    $( ".qlink-read" ).hide();

    if ( "{{$req_cap}}" == "true" )
    {
      genHumanID();  
    } else {
      readMe();
    }
}

function readMe() {
    $('.qlink-ios').hide();
    $( ".qlink-read" ).show();
    $("#header").remove();
    readQlink('{{$serv}}','{{$hash}}');
}

function readMeIO() {
    $('.qlink-ios').hide();
    var pathname = location.pathname;
    var urlhash = location.hash;
    setTimeout(function () {
        
    }, 2000);
    window.location = "qlink:/" + pathname + urlhash;
}

var pathname = location.pathname;
var urlhash = location.hash;

$("#es").attr("href", pathname + "?lang=es" + urlhash);
$("#en").attr("href", pathname + "?lang=en" + urlhash);
$("#it").attr("href", pathname + "?lang=it" + urlhash);
$("#fr").attr("href", pathname + "?lang=fr" + urlhash);
$("#ru").attr("href", pathname + "?lang=ru" + urlhash);
$("#zh").attr("href", pathname + "?lang=zh" + urlhash);

</script>
