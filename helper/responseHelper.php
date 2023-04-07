<?php 


function sendResponse($status, $code, $message, array $data, $type){
    $results = array();

    $results['status'] = $status;
    $results['code'] = $code;
    $results['message'] = $message;
    $results['data'] = $data;

    $json = json_encode($results);


    storeLogResponse($type, json_encode($results));
    print_r($json);


}

?>