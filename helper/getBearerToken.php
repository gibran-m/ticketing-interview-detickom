<?php


function getBearerToken(){
    $auth = '';
    if (isset($_SERVER['Authorization'])) {
        $auth = trim($_SERVER["Authorization"]);
    }else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { 
        $auth = trim($_SERVER["HTTP_AUTHORIZATION"]);
    }else if (function_exists('apache_request_headers')) {
        $requestHeaders = apache_request_headers();
        $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
        if (isset($requestHeaders['Authorization'])) {
            $auth = trim($requestHeaders['Authorization']);
        }
    }
    return trim( $auth, 'Bearer ');
}

?>