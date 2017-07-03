@extends('layout.layout_after')
@section('body.content')
<center>
	<div class="error-message">
		{{$message}}
	</div>
	<div class="space-1"></div>

	<a href="{{URL::to('estimate')}}" style="text-decoration:none;color:inherit">
		<button class="btn btn-primary"> Nhập lại link game </button>
	</a>
</center>
<div class="space-3"></div>
@stop