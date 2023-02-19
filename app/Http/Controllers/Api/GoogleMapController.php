<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class GoogleMapController extends Controller
{

    public function getSearchPlaceLocation(Request $request)
    {

        // Find location latitude longitude with google map findplace.
        $location = $request->input('location');
        $response = Http::get('https://maps.googleapis.com/maps/api/place/findplacefromtext/json', [
            'fields' => 'formatted_address,name,geometry',
            'input' => $location,
            'inputtype' => 'textquery',
            'key' => env('GOOGLE_MAPS_API_KEY')
        ]);

        // Transform response json data to variable
        $rawdata = json_decode($response, true);
        // $lat = $rawdata['candidates'][0]['geometry']['location']['lat'];
        // $lng = $rawdata['candidates'][0]['geometry']['location']['lng'];
        $lat = isset($rawdata['candidates']) && isset($rawdata['candidates'][0]) && isset($rawdata['candidates'][0]['geometry']['location']['lat'])
        ? $rawdata['candidates'][0]['geometry']['location']['lat']
        : " ";
        $lng = isset($rawdata['candidates']) && isset($rawdata['candidates'][0]) && isset($rawdata['candidates'][0]['geometry']['location']['lng'])
        ? $rawdata['candidates'][0]['geometry']['location']['lng']
        : " ";
        $formatToArray = array("lat" => $lat, "lng" => $lng);
        $newData = json_encode($formatToArray);
        return $newData;
    }

    public function getNearbyRestarants(Request $request)
    {   
        // $latandlng
        $lat = $request->input('lat');
        $lng = $request->input('lng');
        
        $response = Http::get('https://maps.googleapis.com/maps/api/place/nearbysearch/json', [
            'keyword' => 'restaurant',
            'location' => $lat.','.$lng,
            'radius' => '3000',
            'type' => 'restaurants',
            'language' => 'en,th',
            'pageToken' => '',
            'key' => env('GOOGLE_MAPS_API_KEY')
        ]);
        
        return $response;
    }
    
    public function getPhotoPlace(Request $request)
    {
        $reference = $request->input('reference');
        $key = env('GOOGLE_MAPS_API_KEY');
        $url = "https://maps.googleapis.com/maps/api/place/photo?maxwidth=300&photoreference={$reference}&key={$key}";
        // Return response to base64
        $contents = file_get_contents($url);
        return response()->json(['photo_data' => base64_encode($contents)]);
    }

    public function getNextPage(Request $request)
    {
        $pageToken = $request->input('pagetoken');
        $response = Http::get('https://maps.googleapis.com/maps/api/place/nearbysearch/json', [
            'pagetoken' => $pageToken,
            'key' => env('GOOGLE_MAPS_API_KEY')
        ]);
        return $response;
    }

}
