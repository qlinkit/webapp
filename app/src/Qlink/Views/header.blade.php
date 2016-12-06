<nav class="navbar navbar-default navbar-fixed-top navbar-inverse" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <!-- <span class="sr-only">Toggle navigation</span> -->
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <div class="visible-xs">
            <a href="/"><img src="/images/qlink-alphamob_logo.png" alt="qlink it" class="navbar-brand" /></a>
      </div> 
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#existing-content-menu" class="navbar-link" data-toggle="modal"
            data-target="#aboutUs" onClick="javascript:_paq.push(['trackEvent', 'Menu', 'Clicked','About']);">{{ Lang::get('topmenu.about') }}</a></li>
        <li><a href="#existing-content-menu" class="navbar-link" data-toggle="modal"
            data-target="#youtubeHelp" onClick="javascript:_paq.push(['trackEvent', 'Menu', 'Clicked','Video Help']);">{{ Lang::get('topmenu.video') }}</a></li>
        <li><a href="#existing-content-menu" class="navbar-link" data-toggle="modal"
            data-target="#helpTxt" onClick="javascript:_paq.push(['trackEvent', 'Menu', 'Clicked','Text Help']);">{{ Lang::get('topmenu.help') }}</a></li>
        <li><a href="#existing-content-menu" class="navbar-link" data-toggle="modal"
            data-target="#faqTxt" onClick="javascript:_paq.push(['trackEvent', 'Menu', 'Clicked','FAQ']);">{{ Lang::get('topmenu.faq') }}</a></li>            
      </ul>
    </div>
   <!-- <p class="navbar-text navbar-right"><a href="#existing-content-menu" class="navbar-link" data-toggle="modal"
   data-target="#youtubeHelp" onClick="javascript:_paq.push(['trackEvent', 'Menu', 'Clicked','Video Help']);">video </a></p>
      <p class="navbar-text navbar-right"><a href="#existing-content-menu" class="navbar-link" data-toggle="modal"
   data-target="#youtubeHelp" onClick="javascript:_paq.push(['trackEvent', 'Menu', 'Clicked','Video Help']);">help</a></p> -->
  </div><!-- /.container-fluid -->
</nav>
<!-- about -->
<div id="aboutUs" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="HelpModal" aria-hidden="true">
 <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h2 class="modal-title" id="myModalLabel">{{ Lang::get('topmenu.about') }}</h2>
      </div>
      <div class="modal-body">      
        <p>{{ Lang::get('topmenu.about_us')}}</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div><!-- /.modal -->
<!-- Youtube help -->
<div class="modal fade" id="youtubeHelp">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>  
          <h4 class="modal-title" id="myModalLabel">video</h4>
      </div>
      <div class="modal-body">
        <center>        
        <div class="embed-responsive embed-responsive-16by9">
          <iframe class="embed-responsive-item" src="//www.youtube-nocookie.com/embed/OMDm9_NwquI?rel=0" frameborder="0" allowfullscreen></iframe>
        </div>
        </center>
      </div>  
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- help -->
<div id="helpTxt" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="HelpModal" aria-hidden="true">
 <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">{{ Lang::get('messages.close') }}</span></button>
        <h2 class="modal-title" id="myModalLabel">{{ Lang::get('help.title') }}</h2>
      </div>
      <div class="modal-body">
        <h4>{{ Lang::get('help.step_one_title')}}</h4>
        <p>{{ Lang::get('help.step_one')}}</p>
        
        <h4>{{ Lang::get('help.step_two_title')}}</h4>
        <p>{{ Lang::get('help.step_two')}}</p>
        <img src="/images/help_step01.png" class="img-responsive" alt="Responsive image">
        <h4>{{ Lang::get('help.step_three_title')}}</h4>
        <p>{{ Lang::get('help.step_three')}}</p>
        <p class="lead text-center">And that's it!</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div><!-- /.modal -->
<!-- faq -->
<div id="faqTxt" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="HelpModal" aria-hidden="true">
 <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h2 class="modal-title" id="myModalLabel">{{ Lang::get('faq.title') }}</h2>
      </div>
      <div class="modal-body">
        <h4>{{ Lang::get('faq.how_works_title')}}</h4>
        <p>{{ Lang::get('faq.how_works')}}</p>

        <h4>{{ Lang::get('faq.how_long_title')}}</h4>
        <p>{{ Lang::get('faq.how_long')}}</p>
        
        <h4>{{ Lang::get('faq.how_secure_title')}}</h4>
        <p>{{ Lang::get('faq.how_secure')}}</p>

        
        <h4>{{ Lang::get('faq.advantages_title')}}</h4>
        <p>{{ Lang::get('faq.advantages')}}</p>
        <img src="/images/get_smart.jpg" class="img-responsive img-thumbnail" alt="Responsive image">

        <h4>{{ Lang::get('faq.quantum_title')}}</h4>
        <p>{{ Lang::get('faq.quantum')}}</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div><!-- /.modal -->
