<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class GoogleMapController extends Controller
{

    public function getSearchPlaceLocation(Request $request)
    {
        // $location
        // Transform input params data to variable.
        // $location = '';
        // if ($request->input('location')) {
        //     $location = $request->input('location');
        // }else{
        //     $location = "bang sue";
        // }
        // $location = $request->input('location') ?? 'bang sue';

        // Find location latitude longitude with google map findplace.
        $location = $request->input('location');
        $response = Http::get('https://maps.googleapis.com/maps/api/place/findplacefromtext/json', [
            'fields' => 'formatted_address,name,geometry',
            'input' => $location,
            'inputtype' => 'textquery',
            'key' => env('GOOGLE_MAPS_API_KEY')
        ]);

        // Transform response json data to variable
        // $rawdata = json_decode($response, true);
        // $lat = $rawdata['candidates'][0]['geometry']['location']['lat'];
        // $lng = $rawdata['candidates'][0]['geometry']['location']['lng'];
        // return [$lat,$lng];
        return $response;
    }

    public function getNearbyRestarants(Request $request)
    {   
        // $latandlng
        $lat = $request->input('lat');
        $lng = $request->input('lng');
        $response = Http::get('https://maps.googleapis.com/maps/api/place/nearbysearch/json', [
            'keyword' => 'restaurant',
            'location' => $lat.' '.$lng,
            'radius' => '30000',
            'type' => 'restaurants',
            'key' => env('GOOGLE_MAPS_API_KEY')
        ]);
        // 'location' => $latandlng[0].' '.$latandlng[1],
        // echo ('$latandlng =>'.$latandlng[0]);
        // check input
        // echo ("this getSearchPlaceLocation => ".$location);
        // return response()->json($response->json());
        return $response;
    }

    public function getPhotoPlace(Request $request)
    {
        // $reference
        $reference = $request->input('reference');
        $response = Http::get('https://maps.googleapis.com/maps/api/place/photo/', [
            'maxwidth' => 400,
            'photo_reference' => '',
            'key' => env('GOOGLE_MAPS_API_KEY')
        ]);

        return $response;
    }

}
