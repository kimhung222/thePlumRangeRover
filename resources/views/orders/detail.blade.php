@extends('layout.layout_after')
@section('body.content')
<style>
	body{
		font-family: 'Sriracha', cursive;
	}
	.big{
		font-size: 20px;
	}
</style>
<div class="big">
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<ol class="breadcrumb">
				<li><a href="/orders">Quản lý đơn hàng</a></li>
				<li> Đơn hàng số {{$order->id}}</li>
			</ol>
		</div>
	</div>
</div>
<div>
	<div class="space-1"></div>
	<div class="container">
		<p><strong>Tên</strong>: {{$order->name}}</p>
		<p><strong>Facebook</strong>: {{$order->facebook}}</p>
		<p><strong>Tổng số tiền</strong>: {{$order->total}}</p>
		<p><strong>Hình thức thanh toán</strong>: {{$order->payments}}</p>
		<p><strong>Tài khoản thanh toán</strong>: {{$order->payment_account}}</p>
	</div>
	<div class="container">
		<h3> List Game mua </h3>
		<div class="list-group">
			@foreach($posts as $p)
			<a href="/posts/{{$p->id}}" class="list-group-item">{{$p->name}}</a>
			@endforeach
		</div>
	</div>

	<div class="space-3"></div>
</div>
	@stop