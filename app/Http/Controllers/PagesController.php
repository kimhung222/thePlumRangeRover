<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Post;
use App\Screenshot;
use App\Requirement;
use App\Gerne;
use App\Category;
use App\Order;
use DB;
use Cookie;
use Illuminate\Cookie\CookieJar;

class PagesController extends Controller
{
    //
	public function listall(Request $request){
		$query = $request->get('search');
		$value ="newRelease";
		if($query == "") {
			$posts = $posts = Post::orderBy('id', 'DESC')->paginate(20);
			return view('posts.posts_all',compact('posts'));
		} else {
			$posts = Post::where('name', 'like', '%'.$query.'%')->paginate(20);
			if(count($posts) == 0) {
				$posts = $posts = Post::orderBy('id', 'DESC')->paginate(20);
				$is_found = false;
			} else {
				$is_found = true;
			}
			return view('posts.posts_all', compact('posts', 'is_found', 'query','value'));
		}
	}

	public function index(){
		$new_posts = $posts =Post::where('is_new','=','1')->get();
		$discount_posts = $posts =Post::where('is_on_discount','=','1')->get();
		$length = (count($discount_posts));
		if(($length%4)!==0){
			$r = 4 - ($length%4);
			for ($i = 1; $i <= $r; $i++) {
				$discount_posts[$length-1+$i] = $discount_posts[$i];
			}
		}
		$length = (count($discount_posts));

		$popular_posts = $posts = Post::where('is_popular','=','1')->get();
		$count_pp = count($popular_posts);
		// dd($popular_posts[1]);
		return view('index',compact('new_posts','discount_posts','length','popular_posts','count_pp'));
	}

	public function estimate(){
		return view('estimate');
	}

	public function checkout(){
		return view('checkout');
	}

	public function guide(){
		return view('guide');
	}



	public function detail($post_id){

		$posts = Post::all();
		$screenshots = Screenshot::all();
		$post = $posts->find($post_id);
		$listscr = $screenshots = $screenshots->where('post_id',$post_id);
		$i = 0;
		$scrshot = array();
		foreach($listscr as $scr){
			$scr->index = $i;
			$i++;
			array_push($scrshot,$scr);
		}
		$scrinit = $scrshot[0];
		unset($scrshot[0]);

		$requirement = Requirement::where('post_id',$post_id)->firstOrFail();
		return view('dashboard.detail',compact('post','listscr','requirement','scrshot','scrinit'));
	}

	public function calculate(Request $request){
		$input = $request->all();
		$link = trim($input['link']);
		if(strpos($link,'/store.steampowered.com/app/') === false){
			$message = "Link nhập vào không đúng mẫu / Chỉ tính giá ở Steam Store";
			return view('estimate_error',compact('message'));
		}
		$link = str_replace("http://store.steampowered.com/app/","",$link);
		$link = str_replace("/","",$link);
		$api_link = 'http://store.steampowered.com/api/appdetails?appids='.$link.'&cc=my';
		// Handle Price
		//
		$game_id = intval($link);
		$result = file_get_contents($api_link);
		$data =  json_decode($result,true);

		if(!$data[$game_id]['success']){
			$message = " Không tồn tại game trong hệ thống steam";
			return view('estimate_error',compact('message'));
		}
		if($data[$game_id]['data']['is_free']){
			$message = " Game này free mà <(\") ";
			return view('estimate_error',compact('message'));
		}
		$post = DB::table('posts')->where('appid','LIKE','%'.$data[$game_id]['data']['steam_appid'].'%')->get();
		if(!count($post)==0){
			return redirect('/posts/'.$post[0]->id);
		}
		$header_image = $data[$game_id]['data']['header_image'];
		$name = $data[$game_id]['data']['name'];
		$background = $data[$game_id]['data']['background'];
		$price = $data[$game_id]['data']['price_overview']['final']/100;
		$price = round($price*47/9.5);
		$price = $price + (5 - $price%5);
		$card_price = round($price*1.25);
		$card_price = $card_price + (10 - $card_price%10);
		$comming_soon = $data[$game_id]['data']['release_date']['coming_soon'];
		if($comming_soon){
			$comming_soon = "Pre-order : ";
		}
		else{
			$comming_soon = '';
		}
		return view('after_estimate',compact('header_image','background','name','price','comming_soon','card_price'));

	}

	public function join(){
/*		$posts = DB::table('posts')
		->join('post_has_genres', 'posts.id', '=', 'post_has_genres.post_id')
		->join('genres', 'genres.id', '=', 'post_has_genres.genres_id')
		->select('posts.name','posts.current_price','posts.header_image','genres.description')
		->get();*/
		return;
	}

	public function livesearch(Request $request){
		if($request->ajax()){
			$answer = DB::table('posts')->where('name','LIKE','%'.$request->search.'%')->limit(5)->get();
			if($answer){
				return Response($answer);
			}
		}
		return '';
	}

	public function livesearch_index(Request $request){
		if($request->ajax()){			
		$answer =Post::where('name','LIKE','%'.$request->search_index.'%')
        ->where('is_new','=','0')
        ->Where('is_popular','=','0')
        ->Where('is_on_discount','=','0')
        ->get();
			if($answer){
				return Response($answer);
			}
		}
		return '';
	}

	public function livesearch_image(Request $request){
		if($request->ajax()){			
			$img_arr = Screenshot::where('post_id','=',$request->post_id)->limit(3)->get();
			if($img_arr){
				return Response($img_arr);
			}
		}
		return '';	
	}

	public function post_search(Request $request){
		$query = $request->input('name');
		if($query==""){
			$message = "";
			$posts = Post::paginate(20);
			return view('dashboard.posts',compact('posts','message'));
		}
		$posts = DB::table('posts')->where('name','LIKE','%'.$query.'%')->paginate(20);
		if(!count($posts)==0){
			$message = '';
			return view('dashboard.posts',compact('posts','message'));
		}
		else{
			$posts = Post::paginate(20);
			$message = "Không tìm thấy game phù hợp";
			return view('dashboard.posts',compact('posts','message'));
		}
	}

	public function suggest(Request $request){
		if($request->ajax()){
			$answer = DB::table('posts')->where('name','LIKE','%'.$request->search.'%')->limit(5)->get();
			if($answer){
				return Response($answer);
			}
		}
		return '';
	}

	public function test(){
		$posts = array();
		$total = 0;
		if(!isset($_COOKIE['cart']) || $_COOKIE['cart']==''){
			$flag = false;
		}
		else{
			$linh =  $_COOKIE['cart'];
			$flag = true;
			$items = explode(' ',$linh);
			foreach ($items as $i) {
				$post = Post::find(intval($i));
				array_push($posts,$post);
				$total = $total + intval($post->current_price);
			}
		}
		// dd($total/100 *20000);
		return view('test',compact('posts','total','flag'));
	}
	public function store(Request $request){
		$input = $request->all();
		$order = new Order();
		// dd($input);
		$order->name = $input['name'];
		$order->type = 'NORMAL';
		$order->payments =  $input['payments'];
		$order->payment_account = $input['payment_account'];
		$order->facebook = $input['facebook'];
		$order->email = $input['email'];
		$order->tel = $input['tel'];
		$order->game_list = $_COOKIE['cart'];
		$linh =  $_COOKIE['cart'];
		$items = explode(' ',$linh);
		$total = 0;
		foreach ($items as $i) {
			$post = Post::find(intval($i));
			$total = $total + intval($post->current_price);
		}
		$order->total = $total;
		$order->save();
		setcookie('cart','',time()+86400*3,'/local');
		setcookie('cart','',time()+86400*3,'/');
		$payment = $order->payment;

		return view('orders.done',compact('total','payment'));
	}

	public function getListGameByGenre($genre) {		
		if($genre==='Horror'){
			$posts = Post::where('show_tag', 'like', '%Violent%')->orWhere('show_tag','like','%Gore%')->orWhere('show_tag','like','%Horror%')->paginate(20);	
		}
		elseif($genre==='Sports'){
			$posts = Post::where('show_tag','like','%Sports%')->orWhere('show_tag','like','%Racing%')->paginate(20);
		}
		else{
			$posts = Post::where('show_tag', 'like', '%'.$genre.'%')->paginate(20);
		}
		return view('posts.posts_all',compact('posts', 'genre'));
	}
	public function filterListGame($value){
		if($value==="newRelease"){
			$posts = Post::orderBy('id','DESC')->paginate(20);
		}elseif($value==="onPopular"){
			$posts = Post::where('is_popular','=','1')->paginate(20);
		}elseif($value==="onDiscount"){
			$posts = Post::where('is_on_discount','=','1')->paginate(20);
		}elseif($value==="isNew"){
			$posts = Post::where('is_new','=','1')->paginate(20);
		}
		return view('posts.posts_all',compact('posts','value'));
	}
}
