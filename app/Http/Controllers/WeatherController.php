<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class WeatherController extends Controller
{
     /**
     * Performs an API request and returns the response.
     * Returns string.
     *
     * @param string $location 
     * @return string
     */
    public function index($location)
    {
    	$weather = $this->getCurrentWeather($location); // Call weather API by Curl
    	
    	if($weather->cod == 200){
    		echo "<pre>";
			print_r($weather);
			Cache::put('weather', $weather); //Cache the fetched weather data	
		} else { //The case where the weather’s information for a given city can’t be found
			echo $weather->message;
		}
  
    }


    public function getCurrentWeather($location)
    {
	  	$apiKey = env('OPEN_WEATHER_MAP_API_KEY');    	      

        $url = "http://api.openweathermap.org/data/2.5/weather?appid=".$apiKey."&q=".$location;

    	$curl = curl_init();

		curl_setopt_array($curl, array(
		    CURLOPT_URL => $url,
		    CURLOPT_RETURNTRANSFER => true,
		    CURLOPT_ENCODING => "",
		    CURLOPT_TIMEOUT => 30000,
		    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		    CURLOPT_CUSTOMREQUEST => "GET",
		    CURLOPT_HTTPHEADER => array(
		    	// Set Here Your Requesred Headers
		        'Content-Type: application/json',
		    ),
		));
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);

		if ($err) {
		    return "cURL Error #:" . $err;
		} else {					
			return json_decode($response);	    
		}

    }
}
