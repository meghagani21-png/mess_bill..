<?php
header("Content-Type: application/json");
include "db.php";

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || empty($data['name']) || empty($data['usn'])) {
    echo json_encode(["success" => false, "message" => "Name and USN are required"]);
    exit;
}

$name = $data['name'];
$usn  = $data['usn'];
$dept = $data['dept'] ?? '';
$year = $data['year'] ?? '';

// Get next Sl_no
$slResult = $conn->query("SELECT COALESCE(MAX(Sl_no), 0) + 1 AS next_sl FROM mess_db");
$slRow = $slResult->fetch_assoc();
$slNo = (int) $slRow['next_sl'];

$stmt = $conn->prepare(
    "INSERT INTO mess_db
        (Sl_no, Student_Name, student_usn, Student_Year, Student_Dept,
         Opening_balance, Total_mess_Rate, Total_mess_Rate_Service,
         total_mess_bill, closing_mess_amount)
     VALUES (?, ?, ?, ?, ?, 45000.00, 112.00, 117, 3677, 45000)"
);

if (!$stmt) {
    echo json_encode(["success" => false, "message" => "Prepare failed: " . $conn->error]);
    exit;
}

$stmt->bind_param("issss", $slNo, $name, $usn, $year, $dept);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Student added successfully"]);
} else {
    echo json_encode(["success" => false, "message" => $stmt->error]);
}

$stmt->close();
