    <script>localeCode = "{{$lang}}";</script>
    <link rel="stylesheet" href="/new/css/gradient.css" type="text/css">

    <!-- Page Wrapper -->
    <div id="page-wrapper">

      <!-- Header -->
      <header id="header" class="alt">
          <div class="language">
                  <ul class="language-ul">
                      <li class="language-li">
                          <a href="/"><img src="/images/qlink_it_meta.png" class="icon_h"/></a>
                      </li>
                      <li class="language-li">
                          <a href="/?lang=es">Español</a>
                      </li>
                      <li class="language-li">
                          <a href="/?lang=en">English</a>
                      </li>
                      <li class="language-li">
                          <a href="/?lang=it">Italian</a>
                      </li>
                      <li class="language-li">
                          <a href="/?lang=zh">中文</a>
                      </li>
                      <li class="language-li">
                          <a href="/?lang=ru">Pусский</a>
                      </li>
                      <li class="language-li">
                          <a href="/?lang=fr">Français</a>
                      </li>
                  </ul>
          </div>
          <nav>
              <a href="#menu" id="m1">Menu</a>
              <a href="#menu" id="m2"></a>
          </nav>
      </header>

      
      <!-- Menu -->
      <nav id="menu">
          <div class="inner">
              <h2>Menu</h2>
              <ul class="links">
                  <li><a href="{{$qlink_corporate_site_url}}?lang={{$lang}}#how-it-works" target="_blank">{{ Lang::get('corp.menu_howitworks') }}</a></li>
                  <li><a href="{{$qlink_corporate_site_url}}?lang={{$lang}}#features" target="_blank">{{ Lang::get('corp.menu_features') }}</a></li>
                  <li><a href="{{$qlink_corporate_site_url}}?lang={{$lang}}#faq" target="_blank">{{ Lang::get('corp.menu_faq') }}</a></li>
                  <li><a href="{{$qlink_corporate_site_url}}?lang={{$lang}}#video" target="_blank">{{ Lang::get('corp.menu_video') }}</a></li>
                  <li><a href="{{$qlink_corporate_site_url}}?lang={{$lang}}#advisory" target="_blank">{{ Lang::get('corp.menu_advisory') }}</a></li>

                  <!-- <li>
                  <div id="quick_warning_message" style="background-color: deeppink;
                                                        color: white;
                                                        font-size: 11px;
                                                        padding: 5px;
                                                        text-align: right;
                                                        ">
                    <div class="quick_success_message_title">
                      <p class="quick_success_message_title_text">{{ Lang::get('messages.read_warnings') }}</p>
                    </div>
                  </div>
                  </li> -->
              </ul>
              <a href="#" class="close">Close</a>
          </div>
      </nav>

      <!-- Banner -->
      <!-- <section id="banner">
          <div class="inner">
              <h2 class="major">Qlink.it</h2>
              <p>Qlink.it is a new, free, and very simple and secure way to send confidential information through the Internet.</p>   
          </div>
      </section> -->


      <!-- Footer -->
      <section id="footer">
          <div class="inner">
              <h2 class="major"><strong id="major-text">GO SIMPLE AND SECURE!</strong></h2>
              <p id="step-number" style="
                  float:left;
                  height: 33px;
                  width: 33px;
                  border: solid 2px rgba(255, 198, 229, 0.91);
                  text-align: center;
                  border-radius: 50px;
                  background: #FF0065;
                  color: #FFF;
              ">1</p>
              <p id="step-text" style="width: 80%;margin-left: 5px;display: inline-block;height: 44px;">{{ Lang::get('messages.tip_text') }}</p>

              @include('message_form_res_new')
              
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
                      <div style="position: absolute;width: 100%;z-index: 10000;" class="labels-entropy">
                        <div style="width:30%;height:18px;position: relative;float:left;">
                          <span style="display:block;font-size: 10px;padding-top: 2px;color: #385A5A !important;">{{ Lang::get('messages.system_entropy') }}</span>
                        </div>
                        <div style="width:65%;height:18px;position: relative;float:left;">
                          <span style="display:block;font-size: 10px;padding-top: 2px;color: #385A5A !important;">{{ Lang::get('messages.user_entropy') }}</span>
                        </div>
                        <style>
                          .flecha_derecha {
                                    width: 0;
                                    height: 0;
                                    margin-top: 3px;
                                    border-top: 6px solid transparent;
                                    border-bottom: 6px solid transparent;
                                    border-left: 10px solid #fff;
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
              <div class="marketing-place-container" style="
              text-align: center;
              border-top: solid 2px rgba(179, 238, 241, 0.91);
              padding-top: 35px;">
                <h3 class="major"><strong id="major-text">{{ Lang::get('messages.try_app') }}</strong></h3>
                <div class="marketing-div" style="">
                  <a href="https://play.google.com/store/apps/details?id=com.qlink.easytech.ar" target="_blank">
                    <img src="/images/andprom.png" class="marketing-img" style="">
                  </a>
                </div>
                <div class="marketing-div">
                  <a href="https://itunes.apple.com/us/app/qlink.it/id984967263?ls=1&amp;mt=8" target="_blank">
                    <img src="/images/iosprom.png" class="marketing-img">
                  </a>
                </div>
                <div class="marketing-div">
                  <a href="https://chrome.google.com/webstore/detail/qlinkit-client-for-gmail/cbpanjdedkeainbhlbjjlihnmgifmmbe" target="_blank">
                    <img src="/images/chromeprom.png" class="marketing-img marketing-img-highlight">
                  </a>
                </div>
              </div>
              <ul class="copyright">
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
          </div>
      </section>

    </div>

    

    
    

    
