<?php

require 'config.php';
require dirname(__DIR__, 1) . '/helper/log.php';


// Create connection
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
  $message = "Connection failed: " . $conn->connect_error;
  storeLog('DB Connection', $message);
  die($message);
}

?>