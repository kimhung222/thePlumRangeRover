@extends('layout.layout_after')
@section('body.content')
<style>
	body{
		color:white;
		background-image: url({{$post->background}});
		background-attachment: fixed;
		background-position: center;
		background-size: 100%;
	}
</style>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<ol class="breadcrumb">
				<li><a href="/">Trang chủ</a></li>
				@if (!Auth::guest())
				<li><a href="{{ URL::to('posts') }}">List Games</a></li>
				@else
				<li><a href="{{URL::to('listgames')}}"> List Games</a></li>
				@endif
				<li class="active">{{$post->name}}</li>
			</ol>
		</div>
	</div>
</div>

	<div class="alert alert-success alertt">
	<strong>Thành công!</strong> Đã thêm {{$post->name}} name vào giỏ
	</div>
	
<div class="space-2"></div>
<div class="container">
	<div class="row">
		<div class="col-md-9">
			<div class="post-name-zone">
				{{$post->name}} 
			</div>
		</div>
		@if (!Auth::guest())
		<div class="col-md-3">
			<div class="pull-right">
				<a href="{{ URL::to('posts/'.$post->id.'/edit') }}">
					<button class="btn btn-primary back"> Edit </button></a>
				</div>
			</div>
			@endif
		</div>
	</div>
	<div class="spance-1"></div>
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<div id="myCarousel" class="carousel slide" data-ride="carousel">
					<!-- Indicators -->
					<ol class="carousel-indicators">
						<li data-target="#myCarousel" data-slide-to="{{$scrinit->index}}" class="active"></li>
						@foreach($scrshot as $scr)
						<li data-target="#myCarousel" data-slide-to="{{$scr->index}}"></li>
						@endforeach
					</ol>
					<div class="carousel-inner" id="carousel-innerr" role="listbox">
						<div class="item active img-responsive center-block">
							<img width="750px"  src="{{$scrinit->path_thumbnail}}">
						</div>
						@foreach ($scrshot as $scr)
						<div class="item img-responsive center-block">
							<img width="750px"  src="{{$scr->path_thumbnail}}">
						</div>
						@endforeach
					</div>
					<!-- Left and right controls -->
					<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
						<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
						<span class="sr-only">Previous</span>
					</a>
					<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
						<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
						<span class="sr-only">Next</span>
					</a>
				</div>
				<div class="space-2"></div>
				<div class="post-requirement">
					{!!$requirement->minimum!!}
					<hr/>
					{!!$requirement->recommended!!}
				</div>			
			</div>
			<div class="col-md-4">
				<div class="post-short-intro">
					<img width="400px" src="{{$post->header_image}}">
					<div class="post-short-description">
						{!! $post->short_description !!}
					</div>
					<div class="post-gerne">

					</div>
					<div class="post-dev">
						<b>DEVELOP:</b> {{$post->developer}} 
						<br/>
						<br/>
						<b>PUBLISHER:</b> {{$post->publisher}}
					</div>
				</div>
				<div class="space-1"></div>
				<div class="post-price-zone">
					<div class="linh">{{$post->card_price}}.000 VND (Card)</div>
					<div class="price">
						{{$post->current_price}}.000 VND
					</div>
					<div class="add">
						<center>
							<!--<button class="btn btn-success add" data-id="{{$post->id}}">
								Thêm vào giỏ
							</button> -->
							<a href="https://www.messenger.com/t/shopgamecanhcut" class="btn btn-success add">Liên Hệ</a>
						</center>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="space-3"></div>
	@stop