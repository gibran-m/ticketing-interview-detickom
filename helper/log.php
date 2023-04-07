<?php
date_default_timezone_set("asia/jakarta");

function storeLog($type, $message){
    $date = date("Y-m-d h:i:sa");
    $log_file=  dirname(__DIR__, 1) . "/log/general.log";

    error_log("\n----------------------------------", 3, $log_file);
    error_log("\ndate : ". $date, 3, $log_file);
    error_log("\ntype : ". $type, 3, $log_file);
    error_log("\nmessage : ". $message, 3, $log_file);
    error_log("\n----------------------------------", 3, $log_file);   
}

function storeLogRequest($ip, $type, $message){
    $date = date("Y-m-d h:i:sa");
    $log_file=  dirname(__DIR__, 1) . "/log/request.log";

    error_log("\n----------------------------------", 3, $log_file);
    error_log("\ndate : ". $date, 3, $log_file);
    error_log("\nip_client : ". $ip, 3, $log_file);
    error_log("\ntype : ". $type, 3, $log_file);
    error_log("\nmessage : ". $message, 3, $log_file);
    error_log("\n----------------------------------", 3, $log_file);   
}

function storeLogResponse($type, $message){
    $date = date("Y-m-d h:i:sa");
    $log_file=  dirname(__DIR__, 1) . "/log/response.log";

    error_log("\n----------------------------------", 3, $log_file);
    error_log("\ndate : ". $date, 3, $log_file);
    error_log("\ntype : ". $type, 3, $log_file);
    error_log("\nmessage : ". $message, 3, $log_file);
    error_log("\n----------------------------------", 3, $log_file);   
}



?>
