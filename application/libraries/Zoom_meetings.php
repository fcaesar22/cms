<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Firebase\JWT\JWT;
use \GuzzleHttp\Client;
use \GuzzleHttp\Exception\RequestException;

class Zoom_meetings {
    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->config('secure_config');
        // define & set the value into class property
        $this->API_KEY    = $this->CI->config->item('ZOOM_API_KEY');
        $this->API_SECRET = $this->CI->config->item('ZOOM_API_SECRET');
        $this->ACCOUNT_ID = $this->CI->config->item('ZOOM_ACCOUNT_ID');
        $this->API_URL    = "https://api.zoom.us/v2/";
    }

    /**
     * Use this method to generate a JWT
     *
     * @return string [generate string token]
     */
    public function generate_token()
    {
        $key = $this->API_SECRET; // set the token (your zoom API secret)
        $payload = [
            "iss" => $this->API_KEY, // set the issuer (your zoom API KEY)
            "exp" => time() + 3600 // expire in 1 hour
        ];
        // use the secret to sign the payload with a specific
        // hashing algorithim required by zoom API HMAC SHA256 (HS256)
        return JWT::encode($payload, $key, 'HS256');
    }

    /**
     * Use this method to base encode token
     *
     * @return string [generate string token]
     */
    public function encode_token()
    {
        $key = $this->API_KEY;
        $secret = $this->API_SECRET;
        return base64_encode("{$key}:{$secret}");
    }

    public function getAccessToken()
    {
        // generate token
        $token = $this->encode_token();
        $host = "https://zoom.us/";
        // use try catch block to get error thrown from guzzle http response
        try {
            // start access zoom API
            $client = new Client(["base_uri" => $host]);
            // set zoom API method, endpoint, headers, & query parameters
            $response = $client->request("POST", "oauth/token", [
                "headers" => [
                    "Authorization" => "Basic " . $token
                ],
                "query" => [
                    "grant_type" => "account_credentials",
                    "account_id" => $this->ACCOUNT_ID
                ]
            ]);
            return (string) $response->getBody();
        } catch (RequestException $e) {
            // To catch exactly error HTTP status code 400 or 404 use
            $code = array(400, 404);
            if ($e->hasResponse()) {
                if (in_array($e->getResponse()->getStatusCode(), $code)) {
                    return (string) $e->getResponse()->getBody();
                }
            }
        }
    }

    /**
     * Use this API to view information of a specific user on a Zoom account.
     *
     * @param  string $user_id (required)    [The user ID or email address of the user. For user-level apps, pass `me` as the value for userId.]
     * @param  enum   $login_type            ["0"=facebook, "1"=google, "99"=API, "100"=zoom, "101"=SSO]
     * @return string
     */
    public function users($user_id = "me", $login_type = "")
    {
        // generate token
        $token = $this->generate_token();
        // use try catch block to get error thrown from guzzle http response
        try {
            // start access zoom API
            $client = new Client(["base_uri" => $this->API_URL]);
            // set zoom API method, endpoint, headers, & query parameters
            $response = $client->request("GET", "users/$user_id", [
                "headers" => [
                    "Authorization" => "Bearer " . $token
                ],
                "query" => [
                    "login_type" => $login_type
                ]
            ]);
            return (string) $response->getBody();
        } catch (RequestException $e) {
            // To catch exactly error HTTP status code 400 or 404 use
            $code = array(400, 404);
            if ($e->hasResponse()) {
                if (in_array($e->getResponse()->getStatusCode(), $code)) {
                    return (string) $e->getResponse()->getBody();
                }
            }
        }
    }

    /**
     * Webinar allows a host to broadcast a Zoom meeting to up to 10,000 attendees.
     * Use this API to get details of a scheduled webinar.
     *
     * @param  integer (int64)  $webinar_id (required)     [The webinar ID in "long" format(represented as int64 data type in JSON). ]
     * @param  string           $occurrence_id             [Unique Identifier that identifies an occurrence of a recurring webinar. [Recurring webinars](https://support.zoom.us/hc/en-us/articles/216354763-How-to-Schedule-A-Recurring-Webinar) can have a maximum of 50 occurrences. When you create a recurring Webinar using [Create a Webinar API](https://marketplace.zoom.us/docs/api-reference/zoom-api/webinars/webinarcreate), you can retrieve the Occurrence ID from the response of the API call.]
     * @param  boolean          $show_previous_occurrences [Set the value of this field to `true` if you would like to view Webinar details of all previous occurrences of a recurring Webinar.]
     * @return string
     */
    public function webinar($webinar_id, $accessToken, $occurrence_id = "", $show_previous_occurrences = "")
    {
        // generate token
        // $token = $this->generate_token();

        // use try catch block to get error thrown from guzzle http response
        try {
            // start access zoom API
            $client = new Client(["base_uri" => $this->API_URL]);
            // set zoom API method, endpoint, headers, & query parameters
            $response = $client->request("GET", "webinars/$webinar_id", [
                "headers" => [
                    "authorization" => "Bearer " . $accessToken
                ],
                "query" => [
                    "occurrence_id"             => $occurrence_id,
                    "show_previous_occurrences" => $show_previous_occurrences
                ]
            ]);
            return (string) $response->getBody();
        } catch (RequestException $e) {
            // To catch exactly error HTTP status code 300, 400, 404 use
            $code = array(300, 400, 404);
            if ($e->hasResponse()) {
                if (in_array($e->getResponse()->getStatusCode(), $code)) {
                    return (string) $e->getResponse()->getBody();
                }
            }
        }
    }

    /**
     *  Webinar with registration requires your registrants to complete a brief form
     *  before receiving the link to join the Webinar.
     *  Use this API to list all the users that have registered for a webinar.
     *
     * @param  integer (int64)  $webinar_id (required)  [The webinar ID in "long" format(represented as int64 data type in JSON). ]
     * @param  string           $occurrence_id          [The meeting occurrence ID.]
     * @param  enum             $status                 [The registrant status: `pending` - Registrant's status is pending. `approved` - Registrant's status is approved. `denied` - Registrant's status is denied.]
     * @param  integer          $page_size              [The number of records returned within a single API call.]
     * @param  integer          $page_number            [This field has been deprecated and we will stop supporting it completely in a future release. Please use \"next_page_token\" for pagination instead of this field.\n\nThe page number of the current page in the returned records.]
     * @param  string           $next_page_token        [The next page token is used to paginate through large result sets. A next page token will be returned whenever the set of available results exceeds the current page size. The expiration period for this token is 15 minutes.]
     * @return string
     */
    public function webinar_registrants($webinar_id, $accessToken, $occurrence_id = "", $status = "", $page_size = "30", $page_number = "1", $next_page_token = "")
    {
        // generate token
        // $token = $this->generate_token();

        // use try catch block to get error thrown from guzzle http response
        try {
            // start access zoom API
            $client = new Client(["base_uri" => $this->API_URL]);
            // set zoom API method, endpoint, headers, & query parameters
            $response = $client->request("GET", "webinars/$webinar_id/registrants", [
                "headers" => [
                    "authorization" => "Bearer " . $accessToken
                ],
                "query" => [
                    "occurrence_id"   => $occurrence_id,
                    "status"          => $status,
                    "page_size"       => $page_size,
                    "page_number"     => $page_number,
                    "next_page_token" => $next_page_token
                ]
            ]);
            return (string) $response->getBody();
        } catch (RequestException $e) {
            // To catch exactly error HTTP status code 300, 400, 404 use
            $code = array(300, 400, 404);
            if ($e->hasResponse()) {
                if (in_array($e->getResponse()->getStatusCode(), $code)) {
                    return (string) $e->getResponse()->getBody();
                }
            }
        }
    }
}
