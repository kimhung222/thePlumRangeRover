
@extends('layout.layout')
@section('body.content')
<style>
    body{
        background-image: url(../assets/wpp.jpg);
        background-size: 100%;
        background-attachment: fixed;
        background-position: center;
    }
</style>
<div class="wrap-all">
<div class="greet">
	<div class="container">
		<center>
			<span style="font-size:30px;
			font-family: 'Sriracha', cursive;">
			<marquee behavior="scroll" direction="left">Chào mừng bạn đến với Cánh cụt SHOP !!! </marquee>
		</span>
	</center>
</div>
</div>
<!-- Carousel -->
<div class="space-1"></div>
    <div class="total-wrapper">
        <div class="container">
            <div class="col-md-12">
                <div id="first-slider">
                    <div id="carousel-example-generic" class="carousel slide carousel-fade">
                        <!-- Indicators -->
                        <ol class="carousel-indicators">
                            @for($i=0;$i<$count_pp;$i++)
                                @if($i===0)
                                    <li data-target="#carousel-example-generic" data-slide-to="{{$i}}" class="active"></li>
                                @else
                                     <li data-target="#carousel-example-generic" data-slide-to="{{$i}}"></li> 
                                @endif
                            @endfor
                        </ol>
                        <!-- Wrapper for slides -->
                        <div class="carousel-inner" role="listbox">
                        @for($j=0;$j<$count_pp;$j++)
                            
                                @if($j===0)
                                    <div class="item active" style="background-image: url({{$popular_posts[$j]->carousel_img}});background-size:cover;background-repeat:no-repeat;">
                                @else
                                    <div class="item" style="background-image: url({{$popular_posts[$j]->carousel_img}});background-size:cover;background-repeat:no-repeat;">
                                @endif
                                    <div class="row">
                                        <div class="container">
                                            <div class="col-md-3 text-right">
                                                <!--<img style="max-width: 200px;" data-animation="animated zoomInLeft" src="http://s20.postimg.org/pfmmo6qj1/window_domain.png">-->
                                            </div>
                                            <div class="col-md-9 text-left">
                                                <span data-animation="animated bounceInDown" style="font-family:Bangers;color:rgba(231, 76, 60,1.0);font-size:50px;background-color:rgba(236, 240, 241,0.7);padding:15px;">{{$popular_posts[$j]->name}}</span>
                                                    <div class="space-2"></div>
                                                <span data-animation="animated bounceInUp" style="font-family:Quicksand;color:black;font-size:30px;background-color:rgba(236, 240, 241,1.0);padding:10px;">{{$popular_posts[$j]->current_price}}.000</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            
                        @endfor
                        </div>
                        <!-- End Wrapper for slides-->
                        <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                            <i class="fa fa-angle-left"></i><span class="sr-only">Previous</span>
                        </a>
                        <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                            <i class="fa fa-angle-right"></i><span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="space-2"></div>
        <!-- Game List -->
        <div class="container">
            <div class="row">
                <div class="row">
                    <div class="col-md-9">
                        <h1><span class="label label-danger">Bán chạy</span></h1>
                    </div>
                    <div class="col-md-3">
                        <!-- Controls -->
                        <div class="controls pull-right hidden-xs">
                            <a class="left fa fa-chevron-left btn btn-success" href="#carousel-example" data-slide="prev"></a>
                            <a class="right fa fa-chevron-right btn btn-success" href="#carousel-example" data-slide="next"></a>
                        </div>
                    </div>
                </div>
				<div class="space-1"></div>
                <div id="carousel-example" class="carousel slide hidden-xs" data-ride="carousel">
                    <!-- Wrapper for slides -->
                    <div class="carousel-inner"> 
                   @for($i=0;$i<$length;$i=$i+4)
                            @if($i===0) 
                                <div class="item active">
                            @else
                                <div class="item">
                            @endif
                                <div class="row">
                                    @for($j=0;$j<4;$j++)   
                                        <div class="col-sm-3">
                                            <div class="col-item">
                                                <div class="photo">
                                                    <img src="{{$discount_posts[$i+$j]->header_image}}" class="img-responsive" alt="a" />
                                                </div>
                                                <div class="info">
                                                    <div class="row">
                                                        <div class="classify-name">{{$discount_posts[$i+$j]->name}}</div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="price" style="width:50%;padding-left: 10%">
                                                            <h5 class="price-text-color">
                                                                {{$discount_posts[$i+$j]->current_price}}.000</h5>
                                                        </div>
                                                        <div class="price" style="width:50%;padding-left: 10%">
                                                            <h5 class="price-text-color">
                                                                {{$discount_posts[$i+$j]->card_price}}.000(CARD)</h5>
                                                        </div>
                                                    </div>
                                                    <div class="separator clear-left">
                                                        <p class="btn-add">
                                                            <i class="fa fa-shopping-cart"></i><a href="https://www.messenger.com/t/shopgamecanhcut" class="hidden-sm" target="_blank">Liên hệ</a></p>
                                                        <p class="btn-details">
                                                            <i class="fa fa-list"></i><a href="/posts/{{$discount_posts[$i+$j]->slug}}" class="hidden-sm" target="_blank">Chi tiết</a></p>
                                                    </div>
                                                    <div class="clearfix">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                       @endfor 


                    </div>
                </div>
            </div>
        </div>

        <!-- Game Grid -->
        <div class="space-2"></div>
        <div class="space-2"></div>

        <!-- List Game -->
        <div class="container">
            <div id="products" class="row list-group">
            @foreach($new_posts as $p)
                <div class="col-sm-3">
                    <div class="col-item" style="margin-top:20px;">
                        <div class="photo">
                            <img src="{{$p->header_image}}" class="img-responsive" alt="a" />
                        </div>
                        <div class="info">
                            <div class="row">
                                <div class="classify-name">{{$p->name}}</div>
                            </div>
                            <div class="row">
                                <div class="price" style="width:50%;padding-left: 10%">
                                        <h5 class="price-text-color">
                                            {{$p->current_price}}.000</h5>
                                </div>
                                <div class="price" style="width:50%;padding-left: 10%">
                                    <h5 class="price-text-color">
                                        {{$p->card_price}}.000(CARD)</h5>
                                </div>
                            </div>
                            <div class="separator clear-left">
                                <p class="btn-add">
                                    <i class="fa fa-shopping-cart"></i><a href="https://www.messenger.com/t/shopgamecanhcut" class="hidden-sm" target="_blank">Liên Hệ</a></p>
                                <p class="btn-details">
                                    <i class="fa fa-list"></i><a href="/posts/{{$p->slug}}" class="hidden-sm" target="_blank">Chi Tiết</a></p>
                            </div>
                            <div class="clearfix">
                            </div>
                        </div>
                    </div>
                </div>                
            @endforeach
            </div>
        </div>
        <center> <a class="btn btn-success" style="width:30%" href="/listgames"> Xem Thêm </a> </center>
        <div class="space-3"></div>
    </div>
        </div>
    </div>
</div>
@stop