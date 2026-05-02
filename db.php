<?php
$conn = new mysqli("localhost", "root", "root123", "mess_management", 3308);

if ($conn->connect_error) {
    http_response_code(500);
    die(json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]));
}
