<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Cookie\CookieJar;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Requirement;
use App\Screenshot;
use Goutte\Client;
use App\Category;
use App\Order;
use App\Gerne;
use App\Post;
use Cookie;
use DB;


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

		//$posts = Post::all();
		$screenshots = Screenshot::all();
		$post = Post::where('id', $post_id)
            ->orWhere('slug', $post_id)
            ->firstOrFail();
		$listscr = $screenshots = $screenshots->where('post_id',$post->id);
		$i = 0;
		$scrshot = array();
		foreach($listscr as $scr){
			$scr->index = $i;
			$i++;
			array_push($scrshot,$scr);
		}
		$scrinit = $scrshot[0];
		unset($scrshot[0]);

		$requirement = Requirement::where('post_id',$post->id)->firstOrFail();
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
		$link = explode('/',$link);
		$link = $link[0];
		$steam_id = $link;
		$link = str_replace("/","",$link);
		$api_link = 'http://store.steampowered.com/api/appdetails?appids='.$link;
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
		$res = $this->comparePrice($steam_id);
		$price = intval(($res['final_price'])/1000);
		$price = $price + (5 - $price % 5);
		$card_price = round($price*1.25);
		$card_price = $card_price + (10 - $card_price%10);
		$name = $name . ' ' . $res['chosen_region'];
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

	public function comparePrice($steam_id){
        $client = new Client();
        $region_prices = array(
            'jp' => array(
                'price' => "",
                'percent' =>""
            ),
            'kr' => array(
                'price' => "",
                'percent' =>""
            ),
            'nz' => array(
                'price' => "",
                'percent' =>""
            ),
            'ca' => array(
                'price' => "",
                'percent' =>""
            ),
            'uk' => array(
                'price' => "",
                'percent' =>""
            ),
            'no' => array(
                'price' => "",
                'percent' =>""
            ),                                                            
        );
        $guzzleClient = new \GuzzleHttp\Client(array( 'curl' => array( CURLOPT_SSL_VERIFYPEER => false, ), )); 
        $client->setClient($guzzleClient);
        $crawler = $client->request('GET', 'https://steamdb.info/app/'. $steam_id .'/');
        //dd($crawler->html());
        // $crawler->filter(".cc")->each(function($node){
        //     echo ($node->html());
        // });
        // Get the based price
        //dd($crawler->html());
        $crawler->filter('.owned')->each(function($node){
            $node_parts = explode("\n",$node->text());
            foreach($node_parts as $part){
                if(strpos($part,"$") !== false){
                    $base_price = $part;
                }
            }
        });
        
        // Get another by region
        // Japanese Yen: jp
        // South Korean Won: kr
        // New Zealand Dollar: nz
        // Canadian Dollar: ca
        // British Pound: uk
        // Norwegian Krone: no
        $text_tables = $crawler->filter('.table-prices > tbody > tr')->each(function($node){
            return $node->text();
        });
        foreach($text_tables as $text){
            if(strstr($text,"Yen")){
                $tokens = explode("\n",trim($text,"\""));
                $region_prices['jp']['price'] = $tokens[4];
                $region_prices['jp']['percent'] = $tokens[5];
            }
            if(strstr($text,"South Korean Won")){
                $tokens = explode("\n",trim($text,"\""));
                $region_prices['kr']['price'] = $tokens[4];
                $region_prices['kr']['percent'] = $tokens[5];
            }
            if(strstr($text,"New Zealand Dollar")){
                $tokens = explode("\n",trim($text,"\""));
                $region_prices['nz']['price'] = $tokens[4];
                $region_prices['nz']['percent'] = $tokens[5];
            }
            if(strstr($text,"Canadian Dollar")){
                $tokens = explode("\n",trim($text,"\""));
                $region_prices['ca']['price'] = $tokens[4];
                $region_prices['ca']['percent'] = $tokens[5];
            }
            if(strstr($text,"British Pound")){
                $tokens = explode("\n",trim($text,"\""));
                $region_prices['uk']['price'] = $tokens[4];
                $region_prices['uk']['percent'] = $tokens[5];
            }
            if(strstr($text,"Norwegian Krone")){
                $tokens = explode("\n",trim($text,"\""));
                $region_prices['no']['price'] = $tokens[4];
                $region_prices['no']['percent'] =  $tokens[5];
            }             
        }
        $percent_price = array();
        foreach($region_prices as $price){
            if($this->convertPercent2Int($price['percent']) > -13 ){
                $price['price'] = floatval(str_replace("$","",$price['price']));
                array_push($percent_price,$price);
            }
        }
        $max = $percent_price[0]['price'];
        for($i=0;$i<count($percent_price);$i++){
            for($j=$i+1;$j<count($percent_price);$j++){
                if($percent_price[$i]['price'] > $percent_price[$j]['price']){
                    $temp = $percent_price[$i];
                    $percent_price[$i] = $percent_price[$j];
                    $percent_price[$j] = $temp;
                }
            }
        }
        $mlinh = $percent_price[0]['price'];
        $percent_price[0]['price'] = "$".$percent_price[0]['price'];
        $chosen_region = array_search($percent_price[0],$region_prices);
        $final_price = floatval($mlinh)*22000;

		$res = array(
			'chosen_region' => $chosen_region,
			'final_price'   => $final_price
		);
        return $res;
    }

    public function removeHtmlTag( $s){
        $temp = "";
        for($i=0;$i<count($s);$i++){
            if($s[$i]=="<" || $s[$i]==">" ){
                countinue;
            }else{
                $temp = $temp . $s[$i];
            }
        }
        return $temp;
    }

    public function filterTableRow($s){
        $converted_price = -1;
        $price_discount = 99;
        $elements = explode("\n",$s);
        foreach($elements as $e){
            if(strpos($e,"$")){
                $converted_price = removeHtmlTag($e);
            }
            if(strpos($e,"price-discount")){
                $price_discount = removeHtmlTag($e);
            }
        }
        return array(
            'price' => $converted_price,
            'discount' => $price_discount
        );
    }
    

    public function convertPercent2Int($number){
        $number = str_replace("%","",$number);
        $number = str_replace("+","",$number);
        return floatval($number);
    }

    public function roundPrice($number){
        $number = round(intval($number)/1000);
        $balance = $number % 10;
        if($balance%10 >=5 ){
            $number = $number + 10 - ($balance % 5);
        }else{
            $number = $number - $balance;
        }       
        return intval($number*1000);
    }
}
