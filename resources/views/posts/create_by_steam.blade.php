@extends('layout.layout_after')
@section('body.content')
<div class="estimate-title">
	Tạo bài viết bằng link Steam
</div>
<div class="container">
	<div class="textbox-estimate">
		<div class="space-1"></div>
		<center>
			{!! Form::open(['url' => 'crawl'])  !!}
			{!! Form::text('link') !!}
			</br>
			</br>
			</br>
			{!! Form::submit('Create', array('class' => 'btn btn-success'))!!}
			{!! Form::close() !!}	
<!-- 			<form>
				<input type="text"  required> 
				<br/>
				<button class="btn btn-success">
					Kiểm tra
				</button>
			</form> -->
		</center>
	</div>
</div>	
<div class="space-3"></div>
@stop