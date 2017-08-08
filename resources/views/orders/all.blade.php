@extends('layout.layout_after')
@section('body.content')
<div style="background-color:rgba(44, 62, 80,0.6)">
	<div class="container">
		<form method="POST" action="{{url('orders_search')}}">
			{{ csrf_field() }}
			<center>
				@if($message!='')
				<div class="label label-danger" style="font-size:20px;">
					{{$message}}
				</div>
				@endif
				<div class="space-1"></div>
			</center>
			<div class="searchbar" style="color:black">
				<div class="row">
					<div class="col-md-7">
						<input type="text" id="search" name="search" class="col-md-5">
						<button type="submit" class="btn btn-primary"> Search </button>
					</div>
					<div class="col-md-4">
						<div class="sort-box col-md-3">
							<select name="option" id="option">
								<option value="">Tìm theo: </option>
								<option value="name">Tên</option>
								<option value="payments">Hình thức thanh toán</option>
								<option value="payment_account">Tài khoản thanh toán</option>
							</select>
						</div>
					</div>
				</div>	
			</div>
		</form>
	</div>
	<div class="space-1"></div>
</div class="space-1"></div>
<div class="container">
	<table class="table table-hovered ">
		<thead>
			<tr>
				<th class="text-center">ID</th>
				<th class="text-center">Tên</th>
				<th class="text-center">Loại</th>
				<th class="text-center">Trạng thái</th>
				<th class="text-center">Hình thức thanh toán</th>
				<th class="text-center">Tài khoản thanh toán</th>
				<th class="text-center">Facebook</th>
				<th class="text-center">Tổng cộng</th>
				<th colspan="3" class="text-center">Tác vụ</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($orders as $o)
			<tr>
				<td class="text-center">{{$o->id}}</td>
				<td class="text-center">{{$o->name}}</td>
				<td class="text-center">{{$o->type}}</td>
				<td class="text-center">{{$o->status}}</td>
				<td class="text-center">{{$o->payments}}</td>
				<td class="text-center">{{$o->payment_account}}</td>
				<td class="text-center">{{$o->facebook}}</td>
				<td class="text-center">{{$o->total}}</td>
				<td class="text-center">
					<a href="{{ URL::to('orders/'.$o->slug) }}">
						<button class="btn btn-success">
							Xem
						</button>
					</a>
				</td>
				<td class="text-center">
					{!! Form::open([
					'route' => ['orders.update', $o->id],
					'method' => 'PATCH',
					'style' =>'display: inline'
					])
					!!}
					<button class="btn btn-primary" type="submit"> Thay đổi </button>
					{!! Form::close() !!}	
				</td>
				<td class="text-center">
					{!! Form::open([
					'route' => ['orders.destroy', $o->id],
					'method' => 'DELETE',
					'style' =>'display: inline'
					])
					!!}
					<button class="btn btn-danger" type="submit"> Xóa </button>
					{!! Form::close() !!}						
				</td>
				<td></td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
<center>
	{!! $orders->render() !!}
</center>
</div>
</div>
</div>
@stop