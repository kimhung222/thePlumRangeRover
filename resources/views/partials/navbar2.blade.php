<div style="position: relative">
	<nav class="navbar custom" id='sidebar'>
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar1" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<center>
					@if (!Auth::guest())
					<a class="navbar-brand" href="{{URL::to('/')}}">
						<img width="50%" src="{{ URL::asset('assets/img/penguin.png') }}">
					</a>
					@else
					<a class="navbar-brand" href="{{URL::to('login')}}">
						<img width="50%" src="{{ URL::asset('assets/img/penguin.png') }}">
					</a>
					@endif
				</center>
			</div>
			<ul class="nav navbar-nav collapse navbar-collapse" id="navbar1">
				<li><a href="{{URL::to('/')}}" style="text-decoration: none;color:inherit">Trang chủ</a></li>
				<li><a href="{{URL::to('listgames')}}" style="text-decoration: none;color:inherit">List Game</a></li>
				<li><a href="{{URL::to('estimate')}}" style="text-decoration: none;color:inherit">Tính giá Game</a></li> 
				<li><a href="{{URL::to('guide')}}" style="text-decoration: none;color:inherit">Hướng dẫn</a></li>
				@if (!Auth::guest())
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" style="text-decoration:none;color:inherit" aria-expanded="false">
						Quản lý
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="{{URL::to('posts')}}" style="text-decoration:none;color:inherit">Quản lý bài viết</a></li>
						<li><a href="{{URL::to('index_management')}}" style="text-decoration:none;color:inherit">Quản lý trang chính</a></li>
					</ul>
				</li>
				@endif  
			</ul>
			<div class="col-sm-3 col-md-3 navbar-right">
				<form class="navbar-form" role="search">
					<div class="input-group" id="navsearch">
						<input type="text" autocomplete="off" class="form-control" id="livesearch" placeholder="Tìm kiếm" name="q">
						<div class="input-group-btn">
							<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
						</div>
					</div>
				</form>                    
			</div>
			@if (!Auth::guest())
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
						{{ Auth::user()->name }} <span class="caret"></span>
					</a>

					<ul class="dropdown-menu" role="menu">
						<li>
							<a href="{{ url('/logout') }}"
							onclick="event.preventDefault();
							document.getElementById('logout-form').submit();">
							Logout
						</a>

						<form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
							{{ csrf_field() }}
						</form>
					</ul>
				</li>
			</ul>
			@endif
		</div>
	</nav>
	<div class="search-wrapper" id="result"></div>
</div>

