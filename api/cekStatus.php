<?php


header("Content-Type:application/json");
require dirname(__DIR__, 1) . '/db/conn.php';
require dirname(__DIR__, 1) . '/helper/getIpClient.php';
require dirname(__DIR__, 1) . '/helper/responseHelper.php';
require dirname(__DIR__, 1) . '/helper/getBearerToken.php';

try {
    
    //get request
    $method = $_SERVER['REQUEST_METHOD'];
    $get_token = getBearerToken();
    $payload = json_decode(file_get_contents('php://input'), true);
    $ip_client = getIpClient();

    //store log request
    storeLogRequest($ip_client, 'cek-status', json_encode($payload));


    if($method != "GET"){
        $data = array();
        sendResponse('false', '004', 'invalid method', $data, 'cek-status');

        return exit;
    }


    //cek token
    $sql = 'SELECT param_value FROM master_parameter where param_name = "BEARER_TOKEN"';
    $result = $conn->query($sql);
    if (!($result)){
        $message = "Error query: " . $conn->error;
        storeLog('cek_status', $message);

        print_r("internal server error");
        return exit;
    }

    $token = $result->fetch_object()->param_value;

    if($token != $get_token){
        $data = array();
        sendResponse('false', '002', 'invalid token', $data, 'cek-status');

        return exit;
    }


    //cek status
    $event = $payload['event_id'];
    $ticket = $payload['ticket_code'];
    
    $sql = 'SELECT status FROM ticketing WHERE event_id = '.$event.' AND  ticket_code = "'.$ticket.'"';
    $result = $conn->query($sql);
    if (!($result)){
        $message = "Error query: " . $conn->error;
        storeLog('cek_status', $message);

        print_r("internal server error");
        return exit;
    }

    $status = $result->fetch_object()?->status;

    if($status == null){
        $data = array();

        sendResponse('false', '003', 'Data not found', $data, 'cek-status');

        return exit;
    }

    $data = array();
    $data['ticket_code'] = $ticket;
    $data['status'] = $status;

    sendResponse('true', '000', 'sukses', $data, 'cek-status');

    return exit;

} catch (\Throwable $th) {
    storeLog('cek_status', $th);
    return exit;
}

?>