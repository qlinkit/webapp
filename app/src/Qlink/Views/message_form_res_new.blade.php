<div class="form-container">
<div class="field">




<div class="qlink-inner clearfix">
  {{ Form::open(array('route' => 'inject','method' => 'post', 'autocomplete' => 'off', 'class' => 'qlink-form','accept-charset' => 'UTF-8')) }}            
  <input type="hidden" id="x_token" name="x_token" value="{{$x_token}}"/>
  <div id="qlink_textarea_form">
    <div  class="qlink">
      <div class="qlink-msj" id="msg-scroll-container">
        <div id="last-qlink-message" class="quick_message_title">
          <label for="message">{{ Lang::get('messages.message_trans') }}</label>
        </div>
        {{ Form::textarea('qlink_message', '', array('id' => 'qlink_textarea', 'autocorrect' => 'off', 'spellcheck' => 'false', 'autocomplete' => 'off', 'cols' => '30', 'style' => 'display:none', 'rows' => '10', 'maxlength' => 2000 
        ,'placeholder'=>Lang::get('messages.msg_placeholder'))) }}
      </div>
      <div class="tool-bar">
        <div class="toolbar-group">
        </div>
        <div class="toolbar-group">
          <div class="tool tool-txt-aling-left"></div>
          <div class="tool tool-txt-aling-center"></div>
          <div class="tool tool-txt-aling-rigth"></div>
        </div>       
        <input type="file" title="{{ Lang::get('messages.attach_file') }}" id="files" class="attached-files" name="files[]"/>
        <div class="leters-counter">2000</div>
      </div>
    </div>
    <div id="msg-error" class="alert-error" style="display:none">
      <span></span>
    </div>
    <div class="msj-instructions">
      <div class="chk_imprint">
        <div class="chk_capt" data-tooltip-l="{{ Lang::get('messages.captcha_verify_help')}}" style="float: right;margin-left: 19px;">
          <input name="captcha" id="captcha" type="checkbox"> 
          <label for="captcha" style="padding-right: 0px;">{{ Lang::get('messages.captcha_verify') }}</label>
        </div>
        <div class="chk_capt" data-tooltip-l="{{ Lang::get('messages.include_ip_help')}}" style="float: right;margin-left: 19px;">
          <input name="imprint" id="imprint" type="checkbox"> 
          <label for="imprint" style="padding-right: 0px;">{{ Lang::get('messages.imprint_qlink') }}</label>
        </div>
      </div>
    </div>
  </div>
  <div class="qlink-footer">
    <div id="form-files" class="form-files">
      <output id="list"></output>
    </div>
    <div id='qlink-button-container'>
      {{ Form::button( 'qlink it!', 
      array('class' => 'qlink-it qlink-it-ql button icon fa-hand-o-right','id' => 'qlink-button')) }}                 
    </div>  

     

    <div id="hash_result">
      <div class="qlink-link hash_result">
        <div class="qlink-link-inner clearfix">
          <input type="text" onpaste="event.preventDefault();event.stopPropagation();return false;" oncut="event.preventDefault();event.stopPropagation();return false;" id="hash_result_text" class="hash_result_text link">
          <button id="share_by_mail" type="button" class="share-link icon fa-share-alt" onclick="openShare();"><span class="share_title_button">{{ Lang::get('messages.share') }}</span></button>  
          
        </div>
        <div id="share-menu" class="share-menu">
          <ul>
            <li>
              <button id="by_mail" type="button" class="by_email" onclick="sendQlink();">
                <div class="span-menu">{{ Lang::get('messages.share_email') }}<div>
                </button>
              </li>
              <li>
                <a id="tw-share" class="tw-share" target="_blank" href="http://twitter.com/?status=">
                  <button id="by_tw" type="button" class="by_tw">
                    <div class="span-menu">{{ Lang::get('messages.share_in') }} Twitter<div>
                    </button>
                  </a>
                </li>
                <!--
                <li>
                  <a id="fb-share" class="fb-share" target="_blank" href="http://www.facebook.com/share.php?u=&t=">
                    <button id="by_fb" type="button" class="by_fb">
                      <div class="span-menu">{{ Lang::get('messages.share_in') }} Facebook<div>
                    </button>
                  </a>
                </li>
                <li>
                  <a id="gm-share" class="gm-share" target="_blank" href="https://plus.google.com/share?url=">
                    <button id="by_gm" type="button" class="by_gm">
                      <div class="span-menu">{{ Lang::get('messages.share_in') }} Google+<div>
                    </button>
                  </a>
                </li>
              -->
              <li id="sharing-container" class="sharing-container">
                <a id="ws-share" class="ws-share" href="whatsapp://send?text=">
                  <button id="by_what" type="button" class="by_what">
                    <div class="span-menu">{{ Lang::get('messages.share_whatsapp') }}</div>
                  </button>
                </a>
              </li>   
              <li class="hover-action">
                <button id="zclip" class="zclip" type="button">
                  <div class="span-menu">{{ Lang::get('messages.share_copy') }}</div>
                </button>
              </li>     
            </ul>
          </div>
        </div>
        <div class="expiry-time timestamp-expire">
          <span>{{ Lang::get('messages.expire_date') }}&nbsp;</span>
          <span id="expire_date"></span>
        </div>
        <div id="qr-code-scan" style="float: left;margin-top: 11px;margin-bottom: 15px;border-radius: 5px;border: 0;box-shadow: inset 0 0 0 1px rgba(179, 238, 241, 0.91);padding: 5px;"></div>
        <div id='new-qlink-button-container' style="display: inline; float: right; margin-bottom: 15px;">
            {{ Form::button(  Lang::get('messages.new_qlink'), 
            array('class' => 'qlink-it button qlink-it-desk icon fa-key','id' => 'new-qlink-button',
            'onclick' => 'location.href="/"', )) }}                 
        </div> 

                </div>
                <div id='new-qlink-button-container-mobile-container' style="display:none">
                  <div id='new-qlink-button-container-mobile'>
                    {{ Form::button(  Lang::get('messages.new_qlink'),
                    array('class' => 'qlink-it button qlink-it-mobile icon fa-key','id' => 'new-qlink-button-mobile', 'style'=>'display:none',
                    'onclick' => 'location.href="/"', )) }}

                  </div>
                </div>
              </div>
              {{ Form::close() }}
            </div><!-- end qlink-inner -->

          </div></div>



          <script type="text/javascript">
          $(document).ready(function() {
            init();

            setTimeout(function () {
              if ( document.forms[0] )
              {  
                document.forms[0].reset();
                $('#qlink_textarea').show();
              }
            }, 1000)

            var supportedBr = checkBrSupport();       
            if ( !supportedBr )
              return;

            $('input[type=file]').bootstrapFileInput();
            replyIntent = '{{$reply_intent}}';
            $("#quick_help").click(
              function() {
                $("#quick_help_message").show();
                $('.top-content').hide();
              }
              );
            $(".quick_help_message_title").click(
              function() {
                $("#quick_help_message").hide();
                $('.top-content').show();
              }                       
              );
            $("#quick_help_close").click(
              function() {
                $("#quick_help_message").hide();
                $('.top-content').show();
              }                       
              );
            $("#qlink-button").click(
              function() {
                createQlink();                
              }
              );
// File Handler Listener
document.getElementById('files').addEventListener('change', handleFileSelect, false);
$('.span-menu').click(
  function() {
    $('#share-menu').hide();
  }
  );
});

function openShare() {
$('#share-menu').show();  
}
</script>
