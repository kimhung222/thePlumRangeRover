@extends('layout.layout_after')
@section('body.content')
<style>
body{
    color:white;
    background-color: #2c3e50;
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-position: center;
    font-family: 'Sriracha', cursive;
}

</style>

    <div class="space-1"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="post-name-zone" style="font-family: 'Sriracha', cursive;">
                    Quản lý trang chính
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="searchbar" style="color:black">
            <div class="row">
                <div class="col-md-6">
                    {!! Form::open(['url' => '/index_management', 'method' => 'get', 'id' => 'search-game-form']) !!}
                        <input type="text" name="search" class="col-md-4" value="<?= isset($query) ? $query : '' ?>">
                    {!! Form::close() !!}
                </div>
                <div class="col-md-3">
                    <div class="sort-box col-md-3 pull-right">
                        <select id="sel1">
							<option value="{{url('/index_management')}}" <?= (!isset($status) || $status == "") ? 'selected' : '' ?>>Tất cả </option>
							<option value="{{url('index_management/popular')}}" <?= (isset($status) && $status == "popular") ? 'selected' : '' ?>>Nổi bật</option>
							<option value="{{url('index_management/discount')}}" <?= (isset($status) && $status == "discount") ? 'selected' : '' ?>>Đang khuyến mãi</option>
							<option value="{{url('index_management/new')}}" <?= (isset($status) && $status == "new") ? 'selected' : '' ?>>Mới</option>
						</select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="space-2"></div>
    <div class="space-2"></div>
    <div class="container">
        @if(isset($is_found))
            @if($is_found == false)
                <div class="col-md-5">
                    <p>Không tìm thấy kết quả phù hợp! </p>
                </div>
            @endif
        @endif

        <div class="col-md-3" style="float:right">
            <div class="pull-right">
                <button class="btn btn-primary back" data-toggle="modal" data-target="#modal-fullscreen"> Thêm </button>
            </div>
        </div>
    </div>
    <div class="container" id="post-content">
        <div class="col-lg-12">
            <table class="table table-hovered">
                <thead>
                    <tr>
                        <th class="text-center">Steam ID</th>
                        <th class="text-center">Tên</th>
                        <th class="text-center" colspan="3"> Trạng thái</th>
                        <th class="text-center"> Wallpaper </th>
                        <th></th>
                        <th></th>
                    </tr>
                    <tr>
                        <th></th>
                        <th></th>
                        <th class="text-center">Nổi bật</th>
                        <th class="text-center">Mới</th>
                        <th class="text-center">Đang khuyến mãi</th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $p)
                        <tr>
                            <td class="text-center">{{$p->appid}}</td>
                            <td class="text-center">{{$p->name}}</td>
                            <td class="text-center">
                                @if($p->is_popular===1)
                                    <button class="btn btn-success btn-status" postid="{{$p->id}}" name="popular">
                                        {{$p->is_popular}}
                                    </button>
                                @else
                                    <button class="btn btn-danger btn-status" postid="{{$p->id}}" name="popular">
                                        {{$p->is_popular}}
                                    </button>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($p->is_new===1)
                                    <button class="btn btn-success btn-status" postid="{{$p->id}}" name="new">
                                        {{$p->is_new}}
                                    </button>
                                @else
                                    <button class="btn btn-danger btn-status" postid="{{$p->id}}" name="new">
                                        {{$p->is_new}}
                                    </button>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($p->is_on_discount===1)
                                    <button class="btn btn-success btn-status" postid="{{$p->id}}" name="discount">
                                        {{$p->is_on_discount}}
                                    </button>
                                @else
                                    <button class="btn btn-danger btn-status" postid="{{$p->id}}" name="discount">
                                        {{$p->is_on_discount}}
                                    </button>
                                @endif
                            </td>
                            <td class="text-center">{{$p->carousel_img}}</td>
                            <td class="text-center"><button class="btn btn-success">
                                    V
                                </button></td>
                            <td class="text-center"><button class="btn btn-danger">
                                    X
                                </button></td>
                        </tr> 
                    @endforeach
                   <!-- <tr>
                        <td class="text-center">1231</td>
                        <td class="text-center">Hitman</td>
                        <td class="text-center"><button class="btn btn-danger">
								No
							</button></td>
                        <td class="text-center"><button class="btn btn-success">
								Yes
							</button></td>
                        <td class="text-center"><button class="btn btn-success">
								Yes
							</button></td>
                        <td class="text-center">Linh ảnhhhhh</td>
                        <td class="text-center"><button class="btn btn-success">
								V
							</button></td>
                        <td class="text-center"><button class="btn btn-danger">
								X
							</button></td>
                    </tr> -->
                </tbody>
            </table>

            <!-- Modal -->
        </div>
    </div>

    <div class="modal modal-fullscreen fade" id="modal-fullscreen" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="background-color:#ffffff">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <center>
                        <h4 class="modal-title" id="myModalLabel">Thêm game vào trang chính</h4>
                    </center>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="col-xs-12 col-md-offset-1">
                            <form class="form-horizontal">
                                <div class="form-group">
                                    <center>
                                        <input type="text" style="max-width: 600px" class="form-control" name="index_game" id="index_game" placeholder="Nhập tên game" autocomplete="off">
                                    </center>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="search-index-wrapper" id="index-result">
                </div>
            </div>
        </div>
    </div>
    <script>
    $('#post-content').on('click', '.btn-status', function(e){
        e.preventDefault();
        var btn = $(this);
        $.ajax({
            type: 'POST',
            url: "http://www.canhcutshop.com/index_management/update",
            data: {
                "_token": "{{ csrf_token() }}",
                'post_id': btn.attr("postid"),
                'name': btn.attr("name")
            },
            success: function(data) {
                if(data.status == "OK") {
                    btn.text(data.content);
                    if(data.content == 0) {
                        btn.removeClass("btn-success").addClass("btn-danger");
                    } else {
                        btn.removeClass("btn-danger").addClass("btn-success");
                    }
                } else {
                    alert("Co loi xay ra!");
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    });

    document.onkeydown=function(evt){
        var keyCode = evt ? (evt.which ? evt.which : evt.keyCode) : event.keyCode;
        if(keyCode == 13)
        {
            document.getElementById('search-game-form').submit();
        }
    }

    $('#sel1').change(function() {
        var url = $(this).val();
        window.location = url;
    });

    $('#index-result').on('click', 'button', function(e){
        e.preventDefault();
        var btn = $(this);
        $.ajax({
            type: 'POST',
            url: "http://www.canhcutshop.com/index_management/update",
            data: {
                "_token": "{{ csrf_token() }}",
                'post_id': btn.attr("post_id"),
                'name': btn.attr("name")
            },
            success: function(data) {
                if(data.status == "OK") {
                    btn.removeClass("btn-success").addClass("btn-danger");
                } else {
                    alert("Co loi xay ra!");
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    });
    $('.close').on('click', function(e){
        e.preventDefault();
        location.reload();
    })
    </script>
@stop

@section('javascript')

@stop