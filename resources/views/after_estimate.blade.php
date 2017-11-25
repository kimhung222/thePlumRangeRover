@extends('layout.layout_after')
@section('body.content')
<style>
	body{
		color:white;
		background-image: url({{$background}});
		background-attachment: fixed;
		background-position: center;
		background-size: 100%;

	}
</style>
<center>
	<div class="estimate-title">
		{{$comming_soon}} {{$name}}
	</div>

	<div class="container">
		<div class="textbox-estimate">
			<div class="space-1"></div>
			<img src="{{$header_image}}">
			<div class="estimated-price">
					<p>Giá chuyển khoản: {{$price}}.000 ₫</p>
					<p>Giá Card        : {{$card_price}}.000 ₫</p>
			</div>
		</div>
		<!-- <button class="btn btn-success"> Yêu cầu mua </button> </hr> -->

		<a href="https://www.messenger.com/t/shopgamecanhcut" style="text-decoration:none;color:inherit">
			<button class="btn btn-success wrap-button">
				Liên hệ
			</button>
		</a>

		<a href="{{URL::to('estimate')}}" style="text-decoration:none;color:inherit">
			<button class="btn btn-danger wrap-button">
				Tính giá game khác
			</button>
		</a>
		<a href="{{URL::to('/')}}" style="text-decoration:none;color:inherit">
			<button class="btn btn-primary wrap-button">
				Về Trang Chủ
			</button>
		</a>
	</div>
</div>
</center>
<div class="space-3"></div>
<!-- Modal fullscreen -->
<!-- <div class="modal modal-fullscreen fade" id="modal-fullscreen" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">Tạo yêu cầu mua game</h4>
			</div>
			<div class="modal-body">
				AAAAAAAAAAAAAAAAAa

			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
		</div>
	</div>
</div> -->
</div>
@stop