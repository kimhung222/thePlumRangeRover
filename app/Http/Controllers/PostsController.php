<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Post;
use App\Screenshot;
use App\Requirement;
use App\Genre;
use App\Category;
use DB;

class PostsController extends Controller
{
    //
    public function __construct(){
        $this->middleware('auth');
    }
    public function index(){
        $message = "";
        $posts = Post::orderBy('id', 'DESC')->paginate(20);
        return view('dashboard.posts',compact('posts','message'));
    }

    public function create_by_steam(){
    	return view('posts.create_by_steam');
    }

    public function edit($post_id){
        $post = Post::find($post_id);
        return view('dashboard.post_edit',compact('post'));
    }

    public function update($post_id ,Request $request){
        $post = Post::find($post_id);
        $old = $post->carousel_img;
        $post->update($request->all());
        $new = $post->carousel_img;
        if(strcmp($old,$new)!=0){
            return redirect('index_management');
        }
        return redirect('posts');
    }

    public function destroy($post_id){
        $post = Post::find($post_id);
        $post->delete();
        return redirect('posts');
    }
    /* Index Management */
    public function indexmanagement(Request $request){
        $message = "";
        $query = $request->get('search');
        if($query == "") {
            $posts =Post::where('is_new','=','1')
                            ->orWhere('is_popular','=','1')
                            ->orWhere('is_on_discount','=','1')
                            ->orderBy('updated_at', 'desc')
                            ->paginate(20);
            return view('index_management',compact('posts', "message"));
        } else {
            $posts = Post::where(function($q) use($query) {
                $q->where('name', 'like', '%'.$query.'%');
                $q->where(function($qr) {
                    $qr->where('is_new', '=', '1')
                       ->orWhere('is_popular','=','1')
                       ->orWhere('is_on_discount','=','1');
                });
            })->orderBy('updated_at', 'desc')->paginate(20);
            if(count($posts) == 0) {
                $posts =Post::where('is_new','=','1')
                                ->orWhere('is_popular','=','1')
                                ->orWhere('is_on_discount','=','1')
                                ->orderBy('updated_at', 'desc')
                                ->paginate(20);
                $is_found = false;
            } else {
                $is_found = true;
            }
            return view('index_management', compact('posts', 'is_found', 'query', 'message'));
        }
    }


    public function crawl(Request $request){
        $input = $request->all();
        $link = trim($input['link']);
        $link = str_replace("http://store.steampowered.com/app/","",$link);
        $link = str_replace("/","",$link);
        $api_link = 'http://store.steampowered.com/api/appdetails?appids='.$link.'&cc=my';
        $game_id = intval($link);
        $result = file_get_contents($api_link);
        $data =  json_decode($result,true);
        if(!$data[$game_id]['success']){

            return " Không tồn tại game trong hệ thống steam";
        }
        if($data[$game_id]['data']['is_free']){
            return " Game này Free mà ";
        }
        // $check = DB::table('posts')->where('appid','=',$data[$game_id]['data']['steam_appid'])->get();
        // if($check->count()){
        //     return 'Game đã được Add vào trong shop, vui lòng xóa đi rồi add lại';
        // }
        $post = new Post();
        $post->name = $data[$game_id]['data']['name'];
        $post->slug = str_replace(" ","-",$post->name);
        $post->type = $data[$game_id]['data']['type'];
        $post->appid = $data[$game_id]['data']['steam_appid'];
        $post->required_age = $data[$game_id]['data']['required_age'];
        $post->detailed_description = $data[$game_id]['data']['detailed_description'];
        $post->about_the_game = $data[$game_id]['data']['about_the_game'];
        $post->short_description = $data[$game_id]['data']['short_description'];
        if(array_key_exists('reviews',$data[$game_id]['data']['pc_requirements'])){
            $post->reviews = $data[$game_id]['data']['reviews'];
        }
        else{
            $post->reviews = "";
        }
        $post->header_image = $data[$game_id]['data']['header_image'];
        $post->developer = "";
        $post->publisher = "";
        foreach ($data[$game_id]['data']['developers'] as $value ){
            $post->developer = $post->developer." ".$value;
        }
        foreach ($data[$game_id]['data']['publishers'] as $value ){
            $post->publisher = $post->publisher." ".$value;
        }
        // $post->recommendations = $data[$game_id]['data']['recommendations'][0];
        $post->support = $data[$game_id]['data']['support_info']['url'];
        $post->background = $data[$game_id]['data']['background'];

        if($data[$game_id]['data']['release_date']['coming_soon']){
            $post->is_released = 1;
        }
        else{
            $post->is_released = 0;
        }

        if($data[$game_id]['data']['is_free']){
            $post->is_free = 1;
        }
        else{
            $post->is_free = 0;
        }

        $post->current_price = round($data[$game_id]['data']['price_overview']['final']/100*47/9.5);
        $post->current_price = $post->current_price  + (5 - $post->current_price%5);
        $post->origin_price =  round($data[$game_id]['data']['price_overview']['initial']/100*47/9.5);
        $post->origin_price -  $post->origin_price + (5 -  $post->origin_price%5);
        $post->card_price = $post->current_price*1.25 + (10-$post->current_price*1.25%10);
        if($data[$game_id]['data']['price_overview']['discount_percent'] > 0){
            $post->is_on_discount = 1;
        }
        foreach($data[$game_id]['data']['genres'] as $gerne){
            $post->show_tag = $post->show_tag . ' ' . $gerne['description'];    
        }

        $post->save();
        //* Requirement
        $req = new Requirement();
        $req->platform = "Window";
        if(array_key_exists('minimum',$data[$game_id]['data']['pc_requirements'])){
            $req->minimum = $data[$game_id]['data']['pc_requirements']['minimum'];
            
        }
        else{
            $req->minimum = ""; 
        } 
        if(array_key_exists('recommended',$data[$game_id]['data']['pc_requirements'])){
            $req->recommended = $data[$game_id]['data']['pc_requirements']['recommended'];
            
        }
        else{
            $req->recommended = ""; 
        } 
        $req->post_id = $post->id;
        $req->save();
        //* Screenshots

        foreach($data[$game_id]['data']['screenshots'] as $ss){
            $scrshot = new Screenshot();
            $scrshot->path_full = $ss['path_full'];
            $scrshot->path_thumbnail = $ss['path_thumbnail'];
            $scrshot->post_id = $post->id;
            $scrshot->save();
        }
        /* Gerne */
        // foreach($data[$game_id]['data']['genres'] as $gerne){
        //     /* Categories */
        //     if(array_search($gerne, $data[$game_id]['data']['genres'])==0){
        //         $g = DB::table('categories')->where('name', '=', $gerne['description'])->get();
        //         if($g->count()){
        //             DB::table('post_has_categories')->insert([
        //                 'post_id' => $post->id,
        //                 'category_id' => $g[0]->id
        //                 ]);
        //         }else{

        //             $cate = new Category();
        //             $cate->name = $data[$game_id]['data']['genres'];
        //             $cate->description = $data[$game_id]['data']['genres'];
        //             $cate->save();
        //             DB::table('post_has_categories')->insert([
        //                 'post_id' => $post->id,
        //                 'category_id' => $cate->id
        //                 ]);

        //         }

        //     }
        //     $g = DB::table('genres')->where('name', '=', $gerne['description'])->get();
        //     if(!$g->count()){
        //         $genre = new Genre();
        //         $genre->name = $gerne['description'];
        //         $genre->description = $gerne['description'];
        //         $genre->save();
        //         //
        //         DB::table('post_has_genres')->insert([
        //             'post_id' => $post->id,
        //             'genres_id' => $genre->id
        //             ]);
        //     }
        //     else{
        //         DB::table('post_has_genres')->insert([
        //             'post_id' => $post->id,
        //             'genres_id' => $g[0]->id
        //             ]);
        //     }
        // }
        return redirect('/posts/'.$post->id) ;
    }

    public function manual(){
        return view('dashboard.posts_new');
    }

    public function manual_create(Request $request){
        $post = new Post();
        $req  = new Requirement();

        $input = $request->all();
        /* */
        $post->name = $input['name'];
        $post->slug = str_replace(" ","-",$post->name);
        $post->is_released = 1;
        $post->current_price = $input['current_price'];
        $post->origin_price = $input['origin_price'];
        $post->status = 1;
        $post->header_image = $input['header_image'];
        $post->background = $input['background'];
        $post->required_age = 18;
        $post->is_free = 0;
        $post->short_description = $input['short_description'];
        $post->developer = $input['publisher'];
        $post->show_tag = $input['show_tag'];
        $post->card_price = $input['card_price'];
        $post->is_popular = 0;
        $post->is_new = 0;
        $post->is_on_discount = 0;
        $post->save();


        $pic1 = new Screenshot();
        $pic1->post_id = $post->id;
        $pic1->path_thumbnail = $input['pic1'];
        $pic1->path_full = $input['pic1'];
        $pic1->save();

        
        $pic2 = new Screenshot();
        $pic2->post_id = $post->id;
        $pic2->path_thumbnail = $input['pic2'];
        $pic2->path_full = $input['pic2'];
        $pic2->save();

        
        $pic3 = new Screenshot();
        $pic3->post_id = $post->id;
        $pic3->path_thumbnail = $input['pic3'];
        $pic3->path_full = $input['pic3'];
        $pic3->save();

        
        $pic4 = new Screenshot();
        $pic4->post_id = $post->id;
        $pic4->path_thumbnail = $input['pic4'];
        $pic4->path_full = $input['pic4'];
        $pic4->save();

        
        $pic5 = new Screenshot();
        $pic5->post_id = $post->id;
        $pic5->path_thumbnail = $input['pic5'];
        $pic5->path_full = $input['pic5'];
        $pic5->save();
        /* */
        $req->platform = "PC";
        $req->minimum = $input['minimum'];
        $req->recommended = $input['recommended'];
        $req->post_id = $post->id;

        $req->save();

        return redirect('/posts/'.$post->id) ;
    }
    public function updatePostStatus(Request $request) {
        $post_id = $request->get('post_id');
        $field = $request->get('name');
        $post = Post::find($post_id);
        if($field == "popular") {
            $post->is_popular = 1 - $post->is_popular;
            $post->save();
            return response()->json([
                'status' => 'OK',
                'content' => $post->is_popular
            ]);
        } elseif($field == "new") {
            $post->is_new = 1 - $post->is_new;
            $post->save();
            return response()->json([
                'status' => 'OK',
                'content' => $post->is_new
            ]);
        } elseif($field == "discount") {
            $post->is_on_discount = 1 - $post->is_on_discount;
            $post->save();
            return response()->json([
                'status' => 'OK',
                'content' => $post->is_on_discount
            ]);
        } else {
            return response()->json([
                'status' => 'error' 
            ]);
        }
    }

    public function updateNeu(Request $request) {
        $post_id = $request->get('post_id');
        $field = $request->get('name');
        $post = Post::find($post_id);
            $post->is_popular = 0;
            $post->is_on_discount = 0;
            $post->is_new = 0;
            $post->save();
            return response()->json([
                'status' => 'OK',
                'content' => 'Done'
            ]);
    }
    // Neutralize
    public function getListGameByStatus($status) {
        if($status == "new") {
            $posts = Post::where('is_new', '=', '1')->paginate(20);
        } elseif($status == "popular") {
            $posts = Post::where('is_popular', '=', '1')->paginate(20);
        } elseif($status == "discount") {
            $posts = Post::where('is_on_discount', '=', '1')->paginate(20);
        } else {
            $posts =Post::where('is_new','=','1')
                        ->orWhere('is_popular','=','1')
                        ->orWhere('is_on_discount','=','1')
                        ->paginate(20);
        }
        return view('index_management', compact('posts', 'status'));
    }

}

