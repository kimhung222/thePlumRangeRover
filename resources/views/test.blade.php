@extends('layout.layout_after')
@section('body.content')
<style>
	.main{
		color:#2c3e50;
		font-family: 'Sriracha';
		background-color: rgba(127, 140, 141,0.6);
	}
</style>

<div class="container main">
	<center>
		<div class="space-1"></div>
		@if($flag)
		<table class="table table-striped">
			<thead>
				<th width="40%"></th>
				<th class="center">Tên</th>
				<th class="center">Giá</th>
				<th class="center"></th>
			</thead>
			<tbody>
				@foreach($posts as $p)
				<tr>
					<td class="center" width="30%"><img width="50%" src="{{$p->header_image}}"></td>
					<td class="center">{{$p->name}}</td>
					<td class="center">{{$p->current_price}}</td>
					<td><button class="btn btn-danger del" data-id="{{$p->id}}">Xóa khỏi giỏ</button> </td>
				</tr>
				@endforeach
			</tbody>
			<tfoot>
				<tr>
					<td class="center" colspan="2">Total</td>
					<td class="center" colspan="1">{{$total}}</td>
					<td></td>
				</tr>
			</tfoot>
		</table>
		<div class="space-1 pull-right">
			<button class="btn btn-warning"> Tiếp tục chọn game </button>
			<button class="btn btn-danger cancel"> Hủy giỏ hàng</button>
			<button class="btn btn-success checkout" data-toggle="modal" data-target="#modal-fullscreen" > Thanh toán</button>
		</div>
		<!-- Modal fullscreen -->
		<div class="modal modal-fullscreen fade" id="modal-fullscreen" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title" id="myModalLabel">Tạo yêu cầu mua game</h4>
					</div>
					<div class="modal-body">
						<div class="container">
							<form class="form-horizontal" method="POST" action="{{url('/orders/create')}}">
								{{ csrf_field() }}
								<div class="form-group">
									<label class="control-label col-sm-2" for="name">Tên:</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="name" id="name" placeholder="Vui lòng nhập tên của bạn" required>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2" for="facebook">Facebook:</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="facebook" id="facebook" placeholder="Ví dụ: https://www.facebook.com/leonkyagami1" required>
									</div>
								</div>
								<div class="form-group">
								<label class="control-lable col-sm-2" for="payments">Hình thức thanh toán:</label>
									<div class="col-sm-10">
										<select class="form-control" id="payments" name="payments" required>
											<option value="vcb">Vietcombank</option>
											<option value="acb">ACB</option>
											<option value="vpbank">VPBank</option>
											<option value="card">Thẻ điện thoại</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2" for="payment_account">Tài khoản thanh toán:</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" id="payment_account" name="payment_account"placeholder="Tài khoản thanh toán của bạn" required>
									</div>
								</div>

								<div class="form-group">
									<label class="control-label col-sm-2" for="email">Email:</label>
									<div class="col-sm-10">
										<input type="email" class="form-control" name="email" id="email" placeholder="Email">
									</div>
								</div>

								<div class="form-group">
									<label class="control-label col-sm-2" for="tel">SĐT:</label>
									<div class="col-sm-10">
										<input type="tel" class="form-control" name="tel" id="tel" placeholder="Số điện thoại">
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-10">
										<button type="submit" class="btn btn-default">Tạo yêu cầu</button>
										<button type="reset" class="btn btn-default">Làm mới</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
				</div>
			</div>
		</div>
	</div>
	@else
	<h1>
		Vui lòng chọn sản phẩm vào trong giỏ !
		<div class="space-1">
			<a class="btn btn-primary" href="{{URL::to('/listgames')}}"> Chọn sản phẩm </a>
		</div>
		<div class="space-3"></div>
	</h1>
	@endif
</center>
</div>

<div class="space-3"></div>
<div class="space-3"></div>
<div class="space-3"></div>
@stop