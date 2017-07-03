<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Order;
use App\Post;
use DB;

class OrdersController extends Controller
{
	public function __construct(){
		$this->middleware('auth');
	}

	public function index(){
		$orders = Order::orderBy('id','DESC')->paginate(20);
		$message = '';
		return view('orders.all',compact('orders','message'));
	}

	public function show($order_id){
		
		$order = Order::find($order_id);
		$linh = $order->game_list;
		$items = explode(' ',$linh);
		$posts = array();
		foreach ($items as $i) {
			$post = Post::find(intval($i));
			array_push($posts,$post);
		}
		return view('orders.detail',compact('order','posts'));
	}

	public function create(){

	}

	public function store(){

	}

	public function destroy($order_id){
		$order = Order::find($order_id);
		$order->delete();
		return redirect('orders');
	}

	public function update($order_id){
		$order = Order::find($order_id);
		$order->status = "DONE";
		$order->save();
		return redirect('orders');

	}

	public function edit(){

	}

	public function order_search(Request $request){
		$input = $request->all();
		if($input['option']==""){
			$input['option'] = 'name';
		}
		if($input['search']==""){
			$message = "";
			$orders = Order::orderBy('id','DESC')->paginate(20);
			return view('orders.all',compact('orders','message'));
		}
		else{
			$orders = DB::table('orders')->where($input['option'],'LIKE','%'.$input['search'].'%')->paginate(20);
			if(!count($orders)==0){
				$message="";
				return view('orders.all',compact('orders','message'));
			}
			else{
				$orders = Order::orderBy('id','DESC')->paginate(20);
				$message = "Không có kết quả tìm kiếm phù hợp";
				return view('orders.all',compact('orders','message'));
			}
		}
	}


}
