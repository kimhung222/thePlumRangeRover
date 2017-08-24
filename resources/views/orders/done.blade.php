@extends('layout.layout_after')
@section('body.content')
<style>
	.container{
		font-family: 'Sriracha', cursive;
		color:black;
	}
</style>
<div class="space-3"></div>
<div class="space=3"></div>
<center>
	<div class="container">
		<h1>Yêu cầu mua hàng của bạn đã được gửi</h1>
		<h3> Vui lòng gửi số tiền {{$total}} từ tài khoản của bạn vào tài khoản một trong những tài khoản sau : </br>
			<div class="space-1"></div>
			<div class="well">
				<ul>
					<li>
						- <strong>Vietcombank</strong>, stk: 0071000870823, tên tk: VO NGUYEN NHAT HOANG, chi nhánh: Tân Bình. 
					</li>
					<li>
						-<strong> ACB</strong>, stk: 218342129, tên tk: VO NGUYEN NHAT HOANG, chi nhánh: Tô Ký
					</li>
					<li>
						-<strong> Vietinbank</strong>, stk: 101010010431648, tên tk: VO NGUYEN NHAT HOANG, chi nhánh: 9 HCM 
					</li>
					<li>
						-<strong> VPBank</strong>, stk: 107307408, tên tk: VO NGUYEN NHAT HOANG, chi nhánh: HCM
					</li>
				</ul>
			</div>
			Sau khi hoàn tất giao dịch 1 thời gian chúng tôi sẽ gửi lại sản phẩm cho bạn qua Facebook, Email;

			Mọi thắc mắc hoặc các vấn đề cần giải quyết vui lòng liên lạc:
			<ul>
				<li><strong>Facebook: https://www.facebook.com/hoang.vo.31191</strong></li>
				<li><strong> SĐT</strong> :</li>
				<li><strong> Email</strong>:</li>
			</ul> 
		</h3>
	</div>
</center>
<div class="space-3"></div>
<div class="space-3"></div>
<div class="space-3"></div>
@stop