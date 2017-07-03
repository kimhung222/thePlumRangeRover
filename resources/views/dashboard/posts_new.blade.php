@extends('layout.layout_after')
@section('body.content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<ol class="breadcrumb">
				<li><a href="/">Trang chủ</a></li>
				<li><a href="{{ URL::to('posts') }}">Dashboard</a></li>
				<li class="active">Tạo bài viết mới</li>
			</ol>
		</div>
	</div>
</div>
<center>
<div class="title">
		<h1> Tạo bài viết mới </h1>
	</div>
</center>
<div class="space-1"></div>
<div class="container">
	{!! Form::open(['url' => 'new'])  !!}
	<div class="form-group">
		{!! Form::submit('Tạo',array('class' => 'btn btn-primary'))!!}
		<button type="reset" class="btn btn-danger">Reset</button>
	</div>
	<div class="form-group"> <strong>**</strong>
		{!! Form::label('name','Tên:') !!}
		{!! Form::text('name','' ,array('class'=>'form-control ')) !!}<br/>
	</div>
	<div class="form-group"> <strong>**</strong>
		{!! Form::label('current_price','Giá hiện tại:') !!}
		{!! Form::text('current_price','',array('class'=>'form-control ')) !!}<br/>
	</div>
	<div class="form-group"> <strong>**</strong>
		{!! Form::label('card_price','Giá Card:') !!}
		{!! Form::text('card_price','',array('class'=>'form-control ')) !!}<br/>
	</div>
	<div class="form-group">
		{!! Form::label('origin_price','Giá gốc:') !!}
		{!! Form::text('origin_price','',array('class'=>'form-control ')) !!}<br/>
	</div>

	<div class="form-group"> <strong>**</strong>
		{!! Form::label('header_image','Ảnh header:') !!}
		{!! Form::text('header_image','',array('class'=>'form-control ','placeholder'=>'460x215')) !!}<br/>
	</div>
	<div class="form-group"> <strong>**</strong>
		{!! Form::label('background','Ảnh nền:') !!}
		{!! Form::text('background','',array('class'=>'form-control ')) !!}<br/>
	</div>
	<div class="form-group"> 
		{!! Form::label('carousel_img','Ảnh carousel:') !!}
		{!! Form::text('carousel_img','',array('class'=>'form-control ')) !!}<br/>
	</div>
	<hr>
		<div class="form-group"> <strong>**</strong>
		{!! Form::label('publisher','Thể loại:') !!}
		<span style="color:black"><button class="btn" type="button" onclick="add('Action')"> Action </button> <button class="btn" type="button"  onclick="add('Adventure')">Adventure</button> <button class="btn" type="button"  onclick="add('Horror')" >Horror</button> <button class="btn" type="button"  onclick="add('Sports')" >Sports</button> <button class="btn" type="button"  onclick="add('Strategy')" >Strategy</button></span>
		{!! Form::text('show_tag','',array('class'=>'form-control ','id'=>'gerne_handle')) !!}<br/>
	</div>
	<hr>
	<div class="form-group"> <strong>**</strong>
		{!! Form::label('pic1','Ảnh 1:') !!}
		{!! Form::text('pic1','',array('class'=>'form-control','placeholder'=>'750x421')) !!}<br/>
	</div>
	<div class="form-group"> <strong>**</strong>
		{!! Form::label('pic2','Ảnh 2:') !!}
		{!! Form::text('pic2','',array('class'=>'form-control ','placeholder'=>'750x421')) !!}<br/>
	</div>
	<div class="form-group"> <strong>**</strong>
		{!! Form::label('pic3','Ảnh 3:') !!}
		{!! Form::text('pic3','',array('class'=>'form-control ','placeholder'=>'750x421')) !!}<br/>
	</div>
	<div class="form-group"> <strong>**</strong>
		{!! Form::label('pic4','Ảnh 4:') !!}
		{!! Form::text('pic4','',array('class'=>'form-control ','placeholder'=>'750x421')) !!}<br/>
	</div>
	<div class="form-group"> <strong>**</strong>
		{!! Form::label('pic5','Ảnh 5:') !!}
		{!! Form::text('pic5','',array('class'=>'form-control ','placeholder'=>'750x421')) !!}<br/>
	</div>

	<hr>
	<div class="form-group"> <strong>**</strong>
		{!! Form::label('minimum','Cấu hình tối thiểu:') !!}
		{!! Form::textarea('minimum','<ul>
								<strong>Minimum:</strong><br><ul class="bb_ul"><li><strong>OS:</strong> <br></li><li><strong>Processor:</strong> <br></li><li><strong>Memory:</strong> <br></li><li><strong>Graphics:</strong><br></li><li><strong>DirectX:</strong> <br></li><li><strong>Storage:</strong> </li></ul>							</ul>',array('class'=>'form-control summernote','id' => 'technig')) !!}<br/>
	</div>
	<div class="form-group"> <strong>**</strong>
		{!! Form::label('recommended','Cấu hình yếu cầu:') !!}
		{!! Form::textarea('recommended','<ul>
								<strong>Recommended:</strong><br><ul class="bb_ul"><li><strong>OS:</strong> <br></li><li><strong>Processor:</strong> <br></li><li><strong>Memory:</strong> <br></li><li><strong>Graphics:</strong><br></li><li><strong>DirectX:</strong> <br></li><li><strong>Storage:</strong> </li></ul>							</ul>',array('class'=>'form-control summernote','id' => 'technig')) !!}<br/>
	</div>
	<hr>
	<div class="form-group"> <strong>**</strong>
		{!! Form::label('short_description','Mô tả ngắn gọn:') !!}
		{!! Form::textarea('short_description','',array('class'=>'form-control summernote','id' => 'technig')) !!}<br/>
	</div>
	<div class="form-group"> <strong>**</strong>
		{!! Form::label('developer','Nhà phát triển:') !!}
		{!! Form::text('developer','',array('class'=>'form-control ')) !!}<br/>
	</div>
	<div class="form-group"> <strong>**</strong>
		{!! Form::label('publisher','Nhà phát hành:') !!}
		{!! Form::text('publisher','',array('class'=>'form-control ')) !!}<br/>
	</div>
	{!! Form::close() !!}
</div>
	<script src="//cdn.ckeditor.com/4.5.11/standard/ckeditor.js"></script>
	CKEDITOR.replace( 'minimum' );
	CKEDITOR.replace( 'recommended' );
	CKEDITOR.replace( 'short_description' );
	<script type="text/javascript">
		function add(type){
			var linh = document.getElementById('gerne_handle');
			if(linh.value.includes(type)){
				linh.value = linh.value.replace(type,'');
			}
			else{
				linh.value = linh.value+' '+type;
			}
		}
	</script>
@stop


