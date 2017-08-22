
@extends('layout.layout_after')
@section('body.content')

<div class="estimate-title">
	Tính giá game trên STEAM
</div>
<div class="container">
	<div class="textbox-estimate">
		<div class="space-1"></div>
		<center>
<!-- 			<form>
				<input type="text"  required> 
				<br/>
				<button class="btn btn-success">
					Kiểm tra
				</button>
			</form> -->
			{!! Form::open(['url' => 'calculate'])  !!}
				<input type="text" name="link" placeholder="http://store.steampowered.com/app/SteamID/Tên_Game" style="font-size:15px">
				</br>
				</br>
				</br>
				{!! Form::submit('Kiểm tra', array('class' => 'btn btn-success'))!!}
			{!! Form::close() !!}
		</center>
	</div>
</div>
<div class="space-3"></div>
@stop