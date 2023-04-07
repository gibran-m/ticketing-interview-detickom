<?php
date_default_timezone_set("asia/jakarta");

require "db/conn.php";
require "helper/randomString.php";

try {
    // get param
    $_GET = array_slice($argv,1);
    $event_id = $_GET[0];
    $total_ticket = (int)$_GET[1];

    //insert to db
    $sql = "INSERT INTO ticketing (id, event_id, ticket_code) VALUES (?,?,?)";
    $insert = $conn->prepare($sql);
    
    for ($i=0; $i < $total_ticket ; $i++) { 
        $id = date("Ymd").getRandomString(7);
        $ticket = 'DTK'.getRandomString(7);
        
        $insert->bind_param('sss', $id, $event_id, $ticket);
        // $insert->execute();

        if(!$insert->execute()){
            $message = "error generate ticket :".$conn->error;
            storeLog('generate-ticket', $message);
            die($message);
        }        
    }


    $message = "generate ticket success : " . $total_ticket . " tickets for event_id " . $event_id ;
    storeLog('generate-ticket', $message);
    echo $message;
    $conn->close();

} catch (\Throwable $th) {
    storeLog('generate-ticket', $th);
    die($th);
}






?>