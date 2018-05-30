<?php
/**
 * Yelp Fusion API code sample.
 *
 * This program demonstrates the capability of the Yelp Fusion API
 * by using the Business Search API to query for businesses by a
 * search term and location, and the Business API to query additional
 * information about the top result from the search query.
 *
 * Please refer to http://www.yelp.com/developers/v3/documentation
 * for the API documentation.
 *
 * Sample usage of the program:
 * `php sample.php --term="dinner" --location="San Francisco, CA"`
 */
// OAuth credential placeholders that must be filled in by users.
// You can find them on
// https://www.yelp.com/developers/v3/manage_app
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$CLIENT_ID = "LHAyrs08FlFvkhFQtecO2g";
$CLIENT_SECRET = "gCqsycHepxgEQnalqRrfOiK0MOJTPzB5XGkoslzeHRtWTwo9BE1UnQRbgbJ2wZ63";
$bearer_token ="KX8L8DUz2cSmES8zj7VM7EqVoarIBipRrOPL37GHPZMKeJZobsgp9fHWrzIMt1u3-YK8UP1mqqJuovcL761vxiofb3w7dFlmE_Q7rEg2SfNc4uUlRHWAuBfp7dohWnYx";
// Complain if credentials haven't been filled out.
//assert($CLIENT_ID, "Please supply your client_id.");
//assert($CLIENT_SECRET, "Please supply your client_secret.");
// API constants, you shouldn't have to change these.
$API_HOST = "https://api.yelp.com";
$SEARCH_PATH = "/v3/businesses/search";
$BUSINESS_PATH = "/v3/businesses/";  // Business ID will come after slash.
$TOKEN_PATH = "/oauth2/token";
$GRANT_TYPE = "client_credentials";
// Defaults for our simple example.
$DEFAULT_TERM = "";
$DEFAULT_LOCATION = "San Francisco, CA";
$SEARCH_LIMIT = 50;




/**
 * Query the Search API by a search term and location
 *
 * @param    $bearer_token   API bearer token from obtain_bearer_token
 * @param    $term        The search term passed to the API
 * @param    $location    The search location passed to the API
 * @return   The JSON response from the request
 */
function search($bearer_token, $term, $location, $longitude, $latitude,$radius) {
    $url_params = array();

    if ($longitude != null && $latitude != null) {
      $url_params['latitude'] = $latitude;
      $url_params['longitude'] = $longitude;
    }elseif ($location) {
          $url_params['location'] = $location;
    }else {
      //return "Error: No location attributes were set!"
    }
    $url_params['radius'] = $radius;
    $url_params['open_now'] = true;
    $url_params['categories'] = "Bars";
    $url_params['sort_by'] = "rating";
    $url_params['term'] = "bars";

    $url_params['limit'] = $GLOBALS['SEARCH_LIMIT'];

    return json_decode(request($bearer_token, $GLOBALS['API_HOST'], $GLOBALS['SEARCH_PATH'], $url_params));
}







function request($bearer_token, $host, $path, $url_params = array()) {
    // Send Yelp API Call
    try {
        $curl = curl_init();
        if (FALSE === $curl)
            throw new Exception('Failed to initialize');
        $url = $host . $path . "?" . http_build_query($url_params);
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,  // Capture response.
            CURLOPT_ENCODING => "",  // Accept gzip/deflate/whatever.
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer " . $bearer_token,
                "cache-control: no-cache",
            ),
        ));
        $response = curl_exec($curl);
        if (FALSE === $response)
            throw new Exception(curl_error($curl), curl_errno($curl));
        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if (200 != $http_status)
            throw new Exception($response, $http_status);
        curl_close($curl);
    } catch(Exception $e) {
        trigger_error(sprintf(
            'Curl failed with error #%d: %s',
            $e->getCode(), $e->getMessage()),
            E_USER_ERROR);
    }
    return $response;
}






/**
 * User input is handled here
 */
$longopts  = array(
    "term::",
    "location::",
);

$options = getopt("", $longopts);
$term = $options['term'] ?: $GLOBALS['DEFAULT_TERM'];
$location = $options['location'] ?: $GLOBALS['DEFAULT_LOCATION'];

?>
