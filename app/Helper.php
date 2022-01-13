<?php
    use Illuminate\Support\Facades\Http;

function set_active($path, $active = 'show') {

    return call_user_func_array('Request::is', (array)$path) ? $active : '';

}

if (!function_exists('GetTokenFeeder')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function GetTokenFeeder()
    {
        $endpoint = \config('app.url_feeder');

        $response = Http::post($endpoint, [
            'act' => 'GetToken',
            'username' => '',
            'password' => '',
        ]);
        
        $result = $response->getBody()->getContents();
        $token = json_decode($result)->data->token;

        return $token;
    }
}

if (!function_exists('dataFeeder')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function dataFeeder($act = '')
    {
        $token = GetTokenFeeder();
            
        $endpoint = \config('app.url_feeder');

        $response = Http::post($endpoint, [
            'act' => $act,
            'token' => $token,
        ]);

        $result = $response->getBody()->getContents();
        $data = json_decode($result)->data;
        
        return $data;
    }
}

if (!function_exists('GetDataFeeder')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function GetDataFeeder($act = '')
    {
        // $token = GetTokenFeeder();
            
        $endpoint = 'http://localhost:8000/api/test';

        $res = Http::post($endpoint);

        $response_data = json_decode($res->getBody()->getContents(), true);
        $result = $response_data['data'];

        return $result;
    }
}