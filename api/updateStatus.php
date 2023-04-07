<?php
date_default_timezone_set("asia/jakarta");

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

    //store log
    storeLogRequest($ip_client, 'cek-status', json_encode($payload));


    if($method != "POST"){
        $data = array();
        sendResponse('false', '004', 'invalid method', $data, 'update-status');

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
        sendResponse('false', '002', 'invalid token', $data, 'update-status');

        return exit;
    }

    //initialization data
    $event = $payload['event_id'];
    $ticket = $payload['ticket_code'];
    $status = $payload['status'];

    //cek data
    $sql = 'SELECT updated_at FROM ticketing  WHERE event_id='.$event.' AND ticket_code = "'.$ticket.'"';
    $result = $conn->query($sql);
    if (!($result)){
        $message = "Error query: " . $conn->error;
        storeLog('cek_status', $message);

        print_r("internal server error");
        
        return exit;
    }
    
    //if not exist
    if($result->num_rows == 0){
        $data = array();
        $message = "data not found: ticket_code " . $ticket;
        storeLog('cek_status', $message);

        sendResponse('false', '006', $message, $data, 'update-status');
        
        return exit;
    }

    $time_update = $result->fetch_object()?->updated_at;

    //update status    
    $sql = 'UPDATE ticketing SET status="'.$status.'" WHERE event_id='.$event.' AND ticket_code = "'.$ticket.'"';
    $result = $conn->query($sql);
    $time = date("Y-m-d h:i:s");
    if (!($result)){
        $message = "Error query: " . $conn->error;
        storeLog('cek_status', $message);

        print_r("internal server error");
        
        return exit;
    }

    //if alredy updated
    if($conn->affected_rows == 0){
        $data = array();
        $message = "data already updated :  status " . $status . ", updated at " . $time_update ;
        storeLog('cek_status', $message);

        sendResponse('false', '007', $message, $data, 'update-status');
        
        return exit;

    }

    $data = array();
    $data['ticket_code'] = $ticket;
    $data['status'] = $status;
    $data['updated_at'] = $time;

    sendResponse('true', '000', 'data updated', $data, 'update-status');
    

    return exit;

} catch (\Throwable $th) {
    storeLog('cek_status', $th);
    print_r("internal server error");
    return exit;
}

?>