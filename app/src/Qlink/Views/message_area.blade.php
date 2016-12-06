@if ($class == 'warning' )
    <div class="alert alert-danger" role="alert">
        <strong>{{ Lang::get('messages.oh_snap') }}</strong>  {{ $data }}.
    </div>
@else
	<div id="result_container" class="hash_result_area">
    
	</div>
@endif
