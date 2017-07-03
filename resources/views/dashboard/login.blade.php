@extends('layout.layout')
@section('body.content')
<center>
	<div class="modal-dialog">
		<div class="loginmodal-container">
			<img src="assets/img/penguin.png"> <span>Shop</span><br>
			<form>
				<input type="text" name="user" placeholder="Tên tài khoản">
				<input type="password" name="pass" placeholder="Mật khẩu">
				<input type="submit" name="login" class="login loginmodal-submit" value="Đăng nhập">
			</form>
<!-- 
				<div class="login-help">
					<a href="#">Register</a> - <a href="#">Forgot Password</a>
				</div> -->
			</div>
		</div>
	</center>
	@stop