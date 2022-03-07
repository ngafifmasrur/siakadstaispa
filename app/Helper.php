<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Models\m_konfigurasi;
use Illuminate\Support\Facades\Redis;

function set_active($path, $active = 'show') {

    return call_user_func_array('Request::is', (array)$path) ? $active : '';

}

if (! function_exists('upload_in_local')) {
    /**
     *
     * @param string $directory
     * @param mixed $file
     * @param string|null $filename
     */
    function upload_in_local($directory, $file, $filename = "")
    {
        $extensi  = $file->getClientOriginalExtension();
        $filename = "{$filename}_" . date('Ymdhis') . ".{$extensi}";

        Storage::disk('public')->putFileAs($directory, $file, $filename);

        return "/{$directory}/{$filename}";
    }
}

if (! function_exists('load_from_local')) {
    /**
     *
     * @param string $filepath
     * @return string|null
     */
    function load_from_local($filepath)
    {
        if (Storage::disk('public')->exists($filepath)) {
            return Storage::disk('public')->url($filepath);
        }

        return null;
    }
}

if (! function_exists('remove_in_local')) {
    /**
     *
     * @param string $filepath
     * @return bool
     */
    function remove_in_local($filepath)
    {
        if (Storage::disk('public')->exists($filepath)) {
            return Storage::disk('public')->delete($filepath);
        }

        return false;
    }
}

if (! function_exists('format_tanggal')) {
    /**
     *
     * @param string $date
     * @param boolean $day
     *
     * @return string
     */
    function format_tanggal($date, $day = false)
    {
        if ($date == null or $date == "") {
            return '';
        }

        $days   = array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum\'at', 'Sabtu');
        $months = array(1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');

        $year  = substr($date, 0, 4);
        $month = $months[(int) substr($date, 5, 2)];
        $date2 = substr($date, 8, 2);
        $text  = '';

        if ($day) {
            $day   = date('w', mktime(0, 0, 0, substr($date, 5, 2), $date2, $year));
            $day   = $days[$day];
            $text .= "{$day}, {$date2} {$month} {$year}";

            return $text;
        }

        $text .= "{$date2} {$month} {$year}";
        return $text;
    }
}

if (! function_exists('format_bulan')) {
    /**
     *
     * @param integer $month
     *
     * @return string
     */
    function format_bulan($month)
    {

        $months = array(1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
        $month = $months[(int) $month];

        return $month;
    }
}

if (! function_exists('format_uang')) {
    /**
     *
     * @param integer $number
     *
     * @return string
     */
    function format_uang($number)
    {
        if (!$number) {
            return 0;
        }

        return number_format($number, 0, ',', '.');
    }
}

if (! function_exists('GetTokenFeeder')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function GetTokenFeeder()
    {
        $endpoint = \config('app.url_feeder');
        $endpoint_fromdb = m_konfigurasi::where('variable','url_feeder_pd_dikti')->first()->value;
        $username_fromdb = m_konfigurasi::where('variable','username_feeder_pd_dikti')->first()->value;
        $password_fromdb = m_konfigurasi::where('variable','password_feeder_pd_dikti')->first()->value;

        $response = Http::post($endpoint_fromdb, [
            'act' => 'GetToken',
            'username' => $username_fromdb,
            'password' => $password_fromdb,
        ]);
        
        $result = $response->getBody()->getContents();
        $token = json_decode($result)->data->token;

        return $token;
    }
}

if (! function_exists('dataFeeder')) {

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
        $endpoint_fromdb = m_konfigurasi::where('variable','url_feeder_pd_dikti')->first()->value;

        $res = Http::post($endpoint_fromdb, [
            'act' => $act,
            'token' => $token,
            'limit' => 500
        ]);

        $response_data = json_decode($res->getBody()->getContents(), true);
        $result = $response_data['data'];

        return $result;
    }
}

if (! function_exists('GetDataFeeder')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function GetDataFeeder($act, $filter = [])
    {
        // $keyword = "id_prodi='7bd9f485-a884-4a93-a42c-0b7a34d7ee3c'";
        // if($filter){
        //     foreach ($filter['filter'] as $key => $item) {
        //         $keyword .= $key."="."'".$item."'".' AND ';
        //     }
        // }

        // if(Redis::exists($act)) {
        //     $result = json_decode(Redis::get($act), true);
        //     return $result;
        // }

        $token = GetTokenFeeder();
        $endpoint = \config('app.url_feeder');
        $endpoint_fromdb = m_konfigurasi::where('variable','url_feeder_pd_dikti')->first()->value;

        $res = Http::post($endpoint_fromdb, [
            'act' => $act,
            'token' => $token,
            'filter' => $filter['filter'] ?? null,
            'order' => $filter['order'] ?? null,
            'limit' => $filter['limit'] ?? null,
            'offset' => $filter['offset'] ?? null
        ]);

        $response_data = json_decode($res->getBody()->getContents(), true);
        $result = $response_data['data'];

        Redis::set($act, json_encode($result));

        return $result;
    }
}

if (! function_exists('InsertDataFeeder')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function InsertDataFeeder($act, $records, $redis)
    {
            
        $token = GetTokenFeeder();
        $endpoint = \config('app.url_feeder');
        $endpoint_fromdb = m_konfigurasi::where('variable','url_feeder_pd_dikti')->first()->value;

        $res = Http::post($endpoint_fromdb, [
            'act' => $act,
            'token' => $token,
            'record' => $records
        ]);

        $result = json_decode($res->getBody()->getContents(), true);

        if($result['error_code'] == 0) {
            //clear Redis 
            Redis::del($redis);
        }

        
        if($result['error_code'] !== 0) {
            return [
                'error_code' => $result['error_code'],
                'error_desc' => $result['error_desc'],
                'data' => $result['data'],
            ] ;
        } elseif($result['error_code'] == 0) {
            return [
                'error_code' => '0',
                'error_desc' => $result['error_desc'],
                'data' => $result['data'],
            ] ;
        }
    }
}

if (! function_exists('UpdateDataFeeder')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function UpdateDataFeeder($act, $key, $records, $redis)
    {
        
        $token = GetTokenFeeder();
        $endpoint = \config('app.url_feeder');
        $endpoint_fromdb = m_konfigurasi::where('variable','url_feeder_pd_dikti')->first()->value;

        $res = Http::post($endpoint_fromdb, [
            'act' => $act,
            'token' => $token,
            'key' => $key,
            'record' => $records
        ]);

        $result = json_decode($res->getBody()->getContents(), true);

        if($result['error_code'] == 0) {
            //clear Redis 
            Redis::del($redis);
        }

        if($result['error_code'] !== 0) {
            return [
                'error_code' => $result['error_code'],
                'error_desc' => $result['error_desc'],
                'data' => $result['data'],
            ] ;
        } elseif($result['error_code'] == 0) {
            return [
                'error_code' => '0',
                'error_desc' => $result['error_desc'],
                'data' => $result['data'],
            ] ;
        }
    }
}

if (! function_exists('DeleteDataFeeder')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function DeleteDataFeeder($act, $key, $redis)
    {
        $token = GetTokenFeeder();
        $endpoint = \config('app.url_feeder');
        $endpoint_fromdb = m_konfigurasi::where('variable','url_feeder_pd_dikti')->first()->value;


        $res = Http::post($endpoint_fromdb, [
            'act' => $act,
            'token' => $token,
            'key' => $key
        ]);

        $result = json_decode($res->getBody()->getContents(), true);

        if($result['error_code'] == 0) {
            //clear Redis 
            Redis::del($redis);
        }

        if($result['error_code'] !== 0) {
            return [
                'error_code' => $result['error_code'],
                'error_desc' => $result['error_desc'],
                'data' => $result['data'],
            ] ;
        } elseif($result['error_code'] == 0) {
            return [
                'error_code' => '0',
                'error_desc' => $result['error_desc'],
                'data' => $result['data'],
            ] ;
        }
    }
}