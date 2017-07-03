@extends('layout.layout_after')
@section('body.content')
<div class="space-2"></div>
<div class="container">
	<div class="searchbar" style="background-color: rgba(236, 240, 241, 0.8);">
		<div class="row">
		<div class="col-md-7" style="position:relative">
			{!! Form::open(['url' => '/listgames', 'method' => 'get', 'id' => 'search-game-form']) !!}
				<input id="suggest" type="text" name="search" placeholder="Nhập tên game cần tìm" class="col-md-5" value="<?= isset($query) ? $query : '' ?>">
			{!! Form::close() !!}
<!-- 				<div id ="suggest_all">
					<div class="suggest-container">
						<div class="suggest-item">
							<a href="/">Batman the Arkham VR</a>
						</div>
					</div>
				</div> -->
			</div>
<!--			<div class="col-md-4">
				<div class="sort-box col-md-3">
					<select id="sel1">
						<option>Lọc theo: </option>
						<option>2</option>
						<option>3</option>
						<option>4</option>
					</select>
				</div>
			</div>-->
			<ul class="nav nav-pills">
				<li class="<?=(isset($value) && $value=="newRelease") ? 'active' : 'hj' ?>"><a href="{{ URL::to('listgames/filter/newRelease') }}">Tất cả</a></li>
				<li class="<?=(isset($value) && $value=="onPopular") ? 'active' : 'hj' ?>"><a href="{{ URL::to('listgames/filter/onPopular') }}">Nổi bật</a></li>
				<li class="<?=(isset($value) && $value=="onDiscount") ? 'active' : 'hj' ?>"><a href="{{ URL::to('listgames/filter/onDiscount') }}">Đang khuyến mãi</a></li>
				<li class="<?=(isset($value) && $value=="isNew") ? 'active' : 'hj' ?>"><a href="{{ URL::to('listgames/filter/isNew') }}">Bán chạy</a></li>
			</ul>
		</div>
	</div>
	<div class="space-1"></div>
	<div class="row">
		<div class="col-xs-8">
			@if(isset($is_found))
				@if($is_found == false)
					<p>Không tìm thấy kết quả phù hợp</p>
				@endif
			@endif
			@foreach ($posts as $p)
			<a style="text-decorations:none;"" href="{{ URL::to('posts/'.$p->id) }}">
				<div class="game-float-wrapper">
					<div class="game-item">
						<div>
							<img  src="{{$p->header_image}}">
						</div>
						<div class="game-item-name">
							{{$p->name}}
						</div>
						<div class="game-item-price">
							<span>{{$p->current_price}}.000</span>
						</div>
						<div class="game-item-categories">
							<span>{{$p->show_tag}}</span>
						</div>
					</div>
                    <div class="item-tool-tip">
                        <div class="tool-tip-wrapper" id="style1" data-id="{{$p->id}}">
                            <center>
                                <p class="tool-tip-name">{{$p->name}}</p>
                                <p class="tool-tip-origin-price"> Giá : {{$p->current_price}}.000 VND </p>
                                <p class="tool-tip-card-price"> Giá Card : {{$p->card_price}}.000 </p>
                                <p class="tool-tip-badge">
									@if($p->is_popular>0)
										<span class="badge badge-error">Bán chạy</span>
									@endif
									@if($p->is_on_discount>0)
										<span class="badge badge-warning">Đang khuyến mãi</span>
									@endif
                                </p>
								<div class="tool-tip-images"></div>
                            </center>
                        </div>
                    </div>
				</div>
			</a>
			@endforeach
			<center>
				@if(is_array($posts))
				{!! $posts->render() !!}
				@endif
			</center>
		</div>

		<div class="col-xs-4">
			<div class="panel panel-default no-radius fixed">
				<div class="panel-heading panel-title">Theo thể loại</div>
				<div class="panel-body">
					<div class="list-group no-radius">
						<a style="border-radius:0" href="{{ URL::to('listgames') }}" class="<?= isset($genre) ? 'list-group-item' : 'list-group-item active' ?>">Tất cả</a>
						<a href="{{ URL::to('listgames/Action') }}" class="<?= (isset($genre) && $genre == "Action") ? 'list-group-item active' : 'list-group-item' ?>">Hành động</a>
						<a href="{{ URL::to('listgames/Adventure') }}" class="<?= (isset($genre) && $genre == "Adventure") ? 'list-group-item active' : 'list-group-item' ?>">Phiêu lưu</a>
						<a href="{{ URL::to('listgames/Horror') }}" class="<?= (isset($genre) && $genre == "Horror") ? 'list-group-item active' : 'list-group-item' ?>">Kinh dị</a>
						<a href="{{ URL::to('listgames/Strategy') }}" class="<?= (isset($genre) && $genre == "Strategy") ? 'list-group-item active' : 'list-group-item' ?>">Chiến thuật</a>
						<a href="{{ URL::to('listgames/RPG') }}" class="<?= (isset($genre) && $genre == "RPG") ? 'list-group-item active' : 'list-group-item' ?>">Nhập vai</a>
						<a href="{{ URL::to('listgames/Indie') }}" class="<?= (isset($genre) && $genre == "Indie") ? 'list-group-item active' : 'list-group-item' ?>">Indie</a>
						<a href="{{ URL::to('listgames/Sports') }}" class="<?= (isset($genre) && $genre == "Sports") ? 'list-group-item active' : 'list-group-item' ?>">Thể Thao</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	document.onkeydown=function(evt){
        var keyCode = evt ? (evt.which ? evt.which : evt.keyCode) : event.keyCode;
        if(keyCode == 13)
        {
            document.getElementById('search-game-form').submit();
        }
    }
	$(document).ready(function() {
		$('.game-float-wrapper').hover(function() {
			var des = $(this).find('.item-tool-tip');
			var jax = $(this).find('.tool-tip-wrapper');
			var $post_id = jax.data('id');
			var res = jax.find('.tool-tip-images');
			var result = '';
			if(res.html()==''){
				$.ajax({
					type: 'get',
					url: "/liveimg",
					data:{
						'post_id' : $post_id
					},
					success: function(data){
						for(var i=0;i<data.length;i++){
							result+=
								"<img src="+data[i].path_thumbnail +">";
						}
						res.html(result);	
					}
				});
				
			}
			des.show();
		});
		$('.game-float-wrapper').mouseleave(function() {
			$(this).find('.item-tool-tip').hide();
		});
	});
</script>
@stop