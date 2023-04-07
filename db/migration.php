<?php

require 'config.php';
require dirname(__DIR__, 1) . '/helper/log.php';

try{

    // Create connection
    $conn = new mysqli($servername, $username, $password);
    if ($conn->connect_error) {
        $message = "Connection failed: " . $conn->connect_error;
        storeLog('DB migration', $message);
        die($message);
    }

    // Create database
    $sql = "CREATE DATABASE ".$database;
    if ($conn->query($sql) !== TRUE) {
        $message = "Error creating database: " . $conn->error;
        storeLog('DB migration', $message);
        die($message);
    }

    //create table
    $sql = "CREATE TABLE ".$database.".`ticketing`  (
        `id` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
        `event_id` int NOT NULL,
        `ticket_code` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
        `status` tinyint NOT NULL DEFAULT 1,
        `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`) USING BTREE
      );";

    if ($conn->query($sql) !== TRUE) {
        $message = "Error creating table: " . $conn->error;
        storeLog('DB migration', $message);
        die($message);
    }


    $message = "migration success : Database " .$database. " created" ;
    storeLog('DB migration', $message);
    echo $message;
    $conn->close();
    
}catch(Exception $e){
    storeLog('DB migration', $message);
    return exit;

}

?>