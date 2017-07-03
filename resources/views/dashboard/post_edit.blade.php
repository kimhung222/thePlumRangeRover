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
				<li><a href="{{ URL::to('posts') }}">Dashboard</a></li>
				<li class="active">{{$post->name}}</li>
			</ol>
		</div>
	</div>
</div>

<center>
	<div class="title">
		<h1> {!! $post->name !!} </h1>
		<h3> {!! $post->appid !!} </h3>
	</div>
</center>
<div class="container">
	{!!Form::model($post,['method' => 'PATCH', 'action' => ['PostsController@update',$post->id] ]) !!}
	<div class="form-group">
		{!! Form::submit('Update',array('class' => 'btn btn-primary'))!!}
		<button type="reset" class="btn btn-danger">Reset</button>
	</div>
	<div class="form-group">
		{!! Form::label('name','Tên:') !!}
		{!! Form::text('name',$post->name,array('class'=>'form-control ')) !!}<br/>
	</div>
	<div class="form-group">
		{!! Form::label('is_released','Đã phát hành:') !!}
		<span>Hint: 0(chưa) hoặc 1(đã ra mắt)</span>
		{!! Form::text('is_released',$post->is_released,array('class'=>'form-control ')) !!}<br/>
	</div>
	<div class="form-group">
		{!! Form::label('current_price','Giá hiện tại:') !!}
		{!! Form::text('current_price',$post->current_price,array('class'=>'form-control ')) !!}<br/>
	</div>
	<div class="form-group">
		{!! Form::label('card_price','Giá card:') !!}
		{!! Form::text('card_price',$post->card_price,array('class'=>'form-control ')) !!}<br/>
	</div>
	<div class="form-group">
		{!! Form::label('origin_price','Giá gốc:') !!}
		{!! Form::text('origin_price',$post->origin_price,array('class'=>'form-control ')) !!}<br/>
	</div>
	<div class="form-group">
		{!! Form::label('header_image','Ảnh header:') !!}
		{!! Form::text('header_image',$post->header_image,array('class'=>'form-control ')) !!}<br/>
	</div>
	<div class="form-group">
		{!! Form::label('background','Ảnh nền:') !!}
		{!! Form::text('background',$post->background,array('class'=>'form-control ')) !!}<br/>
	</div>
	<div class="form-group"> 
		{!! Form::label('carousel_img','Ảnh carousel:') !!}
		{!! Form::text('carousel_img','',array('class'=>'form-control')) !!}<br/>
	</div>
	<div class="form-group">
		{!! Form::label('detailed_description','Mô tả chi tiết:') !!}
		{!! Form::textarea('detailed_description',$post->detailed_description,array('class'=>'form-control ckeditor','id' => 'technig')) !!}<br/>
	</div>
	<div class="form-group">
		{!! Form::label('about_the_game','Thông tin chung:') !!}
		{!! Form::textarea('about_the_game',$post->about_the_game,array('class'=>'form-control ckeditor','id' => 'technig')) !!}<br/>
	</div>
	<div class="form-group">
		{!! Form::label('short_description','Mô tả ngắn gọn:') !!}
		{!! Form::textarea('short_description',$post->short_description,array('class'=>'form-control ckeditor','id' => 'technig')) !!}<br/>
	</div>
	<div class="form-group">
		{!! Form::label('developer','Nhà phát triển:') !!}
		{!! Form::text('developer',$post->developer,array('class'=>'form-control ')) !!}<br/>
	</div>
	<div class="form-group">
		{!! Form::label('publisher','Phát hành:') !!}
		{!! Form::text('publisher',$post->publisher,array('class'=>'form-control ')) !!}<br/>
	</div>
	{!! Form::close() !!}
</div>
	<script src="//cdn.ckeditor.com/4.5.11/standard/ckeditor.js"></script>
<script type="text/javascript">
         CKEDITOR.replace( 'messageArea',
         {
          customConfig : 'config.js',
          toolbar : 'simple'
          })
</script> 
@stop
