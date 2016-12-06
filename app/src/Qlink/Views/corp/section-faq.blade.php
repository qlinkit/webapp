<!-- =========================
    FAQ
============================== -->
<section class="app-brief" id="faq">

<div class="container">

	<div class="row">

		<!-- BRIEF -->
		<div class="col-md-12 left-align wow fadeInLeft animated" data-wow-offset="10" data-wow-duration="1.5s">

			<!-- SECTION TITLE -->
			<h2 class="dark-text">{{ Lang::get('corp.faq_title') }}</h2>

			<div class="colored-line-left">
			</div>

			<br/>

			<div id="faq-accordion">
				@for ($i = 1; $i <= 8; $i++ )
					<h3 class="faq-toggle">{{ $i }}. {{ Lang::get('corp.faq' . $i . '_q') }}</h3>
					<div class="faq-content">{{ Lang::get('corp.faq' . $i . '_a') }}</div>
				@endfor

				{{-- ultima faq --}}
				<h3 class="faq-toggle">9. {{ Lang::get('corp.faq9_q') }}</h3>
				<div class="faq-content">
					{{ Lang::get('corp.faq9_a') }}
					<br/><a href="{{ URL::asset('corp/docs/advanced-faq.pdf');}}"><i class="icon_document"></i> {{ Lang::get('corp.download_faq_link') }}</a>
				</div>
			</div>
		</div>
		<!-- /ENDBRIEF -->

	</div>
	<!-- /END ROW -->

</div>
<!-- /END CONTAINER -->

</section>
<!-- /END SECTION -->
