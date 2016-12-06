<!-- =========================
     HEADER
============================== -->
<header class="header" data-stellar-background-ratio="0.5" id="home">

<!-- COLOR OVER IMAGE -->
<div class="color-overlay"> <!-- To make header full screen. Use .full-screen class with color overlay. Example: <div class="color-overlay full-screen">  -->

	<!-- STICKY NAVIGATION -->
	<div class="navbar navbar-inverse bs-docs-nav navbar-fixed-top sticky-navigation">
		<div class="container">
			<div class="navbar-header">

				<!-- LOGO ON STICKY NAV BAR -->
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#kane-navigation">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				</button>

				<a class="navbar-brand" href="../"><img src="corp/images/logo-black.png" alt=""></a>

			</div>

			<!-- NAVIGATION LINKS -->
			<div class="navbar-collapse collapse" id="kane-navigation">
				<ul class="nav navbar-nav navbar-right main-navigation">
					<li><a href="#home">{{ Lang::get('corp.menu_home') }}</a></li>
					<li><a href="#how-it-works">{{ Lang::get('corp.menu_howitworks') }}</a></li>
					<li><a href="#video">{{ Lang::get('corp.menu_video') }}</a></li>
					<li><a href="#features">{{ Lang::get('corp.menu_features') }}</a></li>
					<li><a href="#download">{{ Lang::get('corp.menu_download') }}</a></li>
					<li><a href="#faq">{{ Lang::get('corp.menu_faq') }}</a></li>
					<li><a href="#advisory">{{ Lang::get('corp.menu_advisory') }}</a></li>
					{{-- <li><a href="#download">Download</a></li> --}}
				</ul>
			</div>
		</div> <!-- /END CONTAINER -->
	</div> <!-- /END STICKY NAVIGATION -->


	<!-- CONTAINER -->
	<div class="container">

		<!-- ONLY LOGO ON HEADER -->
		<!-- <div class="only-logo">
			<div class="navbar">
				<div class="navbar-header">
					<img src="corp/images/logo.png" alt="">
				</div>
			</div>
		</div>  -->
		<!-- /END ONLY LOGO ON HEADER -->

		<div class="row home-contents">
			<div class="col-md-6 col-sm-6">

				<!-- HEADING AND BUTTONS -->
				<div class="intro-section">

					<!-- WELCOM MESSAGE -->
					<h1 class="intro">{{ Lang::get('corp.tagline') }}</h1>
					<h5>{{ Lang::get('corp.brief_intro') }}</h5>

					<!-- BUTTON -->
					<div class="buttons" id="download-button">

						<a href="#download" class="btn btn-default btn-lg standard-button"  title="{{ Lang::get('corp.button_web_version_title') }}"><i class="icon_cloud_alt"></i>{{ Lang::get('corp.button_web_version') }}</a>
						{{-- <a href="#download" class="btn btn-default btn-lg standard-button" title="{{ Lang::get('corp.button_download_title') }}"><i class="icon_cloud-download_alt"></i>{{ Lang::get('corp.button_download') }}</a> --}}

					</div>
					<!-- /END BUTTONS -->

				</div>
				<!-- /END HEADNING AND BUTTONS -->

			</div>


			<div class="col-md-6 col-sm-6 hidden-xs">

			    <!-- PHONE IMAGE WILL BE HIDDEN IN TABLET PORTRAIT AND MOBILE-->
			    <div class="phone-image">
			    <img src="corp/images/single-nexus-5-message.png" class="img-responsive" alt="">
			    </div>

			</div>

		</div>
		<!-- /END ROW -->

	</div>
	<!-- /END CONTAINER -->
</div>
<!-- /END COLOR OVERLAY -->
</header>
<!-- /END HEADER -->
