<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;
use GuzzleHttp\Client as GuzzleClient;
use App\Http\Requests;

class TestController extends Controller
{
    //
    public function Test(){
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
        $crawler = $client->request('GET', 'https://steamdb.info/app/203140/');
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
        $percent_price[0]['price'] = "$".$percent_price[0]['price'];
        $chosen_region = array_search($percent_price[0],$region_prices);
        $final_price = floatval(str_replace("$","",$price['price'])) *22000;
        
    }

    public function removeHtmlTag(String $s){
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

    public function filterTableRow(String $s){
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
}
