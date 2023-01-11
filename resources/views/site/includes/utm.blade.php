@if(!empty(Request::all()))
	<link rel="canonical" href="{{ Request::url() }}" />
@endif