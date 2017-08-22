<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function HttpRequest(
    $url,
    $cookie)
{
    $ch = curl_init($url);
    curl_setopt_array(
        $ch, 
        array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_COOKIE => $cookie,
            CURLOPT_HTTPHEADER => 
                array(
                    'Content-type: application/x-www-form-urlencoded',
                    'User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36'
                ),
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_HEADER => true,
            CURLOPT_VERBOSE => true
    ));

    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    $body = substr($response, $header_size);

    if($response === FALSE){
        return array('code' => 500, 'body' => '');
    }

    return array('code' => $httpcode, 'body' => $body);
}