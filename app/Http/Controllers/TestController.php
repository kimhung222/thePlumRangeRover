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
        $guzzleClient = new \GuzzleHttp\Client(array( 'curl' => array( CURLOPT_SSL_VERIFYPEER => false, ), )); 
        $client->setClient($guzzleClient);
        $crawler = $client->request('GET', 'https://steamdb.info/app/203140/');
        dd($crawler);
    }
}
