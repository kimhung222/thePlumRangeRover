@extends('layout.layout_after')
@section('body.content')
<style>
	body{
		background-image: url(http://photoservice.gamesao.vn/Resources/Upload/Images/News/76b55bbf-cb08-4f90-a2f7-2d8a5fd4cbd0.jpg);
		background-attachment: fixed;
		background-position: center;
		background-size: 100%;
	}
	td{
		text-align:center; 
		vertical-align:middle;
	}
</style>

<div style="background-color:rgba(44, 62, 80,0.6)">
	<div class="container">
		<form method="POST" action="{{url('/post_name_search')}}">
			{{ csrf_field() }}
			<center>
				@if($message)
				<div class="label label-danger" style="font-size:20px;">
					{{$message}}
				</div>
				@endif
			</center>
			<div class="searchbar" style="color:black">
				<div class="row">
					<div class="col-md-7">
						<input type="text" id="name" name="name" class="col-md-5"  placeholder="Tìm kiếm theo tên">
						<button type="submit" class="btn btn-primary"> Search </button>
					</div>
					<div class="col-md-4">
<!-- 						<div class="sort-box col-md-3">
							<select id="option" name="option">
								<option>Tìm theo: </option>
								<option value="name">Tên</option>
								<option value="appid">Steam ID</option>
							</select>
						</div> -->
					</div>
				</div>
			</div>
		</form>
		<div class="button-group">
			<a href="{{URL::to('posts/make')}}" class="btn btn-primary" style="border-radius:0!important"> Tạo bài viết qua Steam </a>
			<a href="{{URL::to('/new_post')}}" class="btn btn-primary" style="border-radius:0!important"> Viết bài </a>
		</div>
		<div class="space-1"></div>
		<div class="space-1"></div>
		<table class="table table-hovered ">
			<thead>
				<tr>
					<th class="text-center">ID</th>
					<th class="text-center">SteamID</th>
					<th class="text-center">Tên</th>
					<th class="text-center">Giá hiện tại</th>
					<th class="text-center">Giá gốc</th>
					<th class="text-center">Trạng thái</th>
					<th colspan="3" class="text-center">Tác vụ</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($posts as $p)
				<tr>
					<td>{{$p->id}}</td>
					<td>{{$p->appid}}</td>
					<td>{{$p->name}}</td>
					<td>{{$p->current_price}}</td>
					<td>{{$p->origin_price}}</td>
					<td>{{$p->status}}</td>
					<td>
						<a href="{{ URL::to('posts/'.$p->id) }}">
							<button class="btn btn-success">
								View
							</button>
						</a>
					</td>
					<td>
						<a href="{{URL::to('posts/'.$p->id.'/edit')}}">
							<button class="btn btn-primary" style="display:inline">
								Edit
							</button>
						</a>
					</td>
					<td>
						{!! Form::open([
						'route' => ['posts.destroy', $p->id],
						'method' => 'DELETE',
						'style' =>'display: inline'
						])
						!!}
						<button class="btn btn-danger" type="submit"> Delete </button>
						{!! Form::close() !!}
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		<center>
			{!! $posts->render() !!}
		</center>
	</div>
</div>

	<!-- Modal -->
<!-- 		<div class="modal fade" id="myModal" role="dialog">
	<div class="modal-dialog"> -->

		<!-- Modal content-->
<!-- 				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Xóa game khỏi dữ liệu ?</h4>
					</div>
					<div class="modal-body">
						<center>
							<button type="submit" style="width:100px;height:50px;" class="btn btn-danger"> Yes </button>
							
							<button type="button" class="btn btn-default" data-dismiss="modal" style="width:100px;height:50px;" >No</button>
						</center>
					</div>
				</div>

			</div>
		</div> -->
		@stop