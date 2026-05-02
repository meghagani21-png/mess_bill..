<?php
header("Content-Type: application/json");
include "db.php";

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || empty($data['usn'])) {
    echo json_encode(["success" => false, "message" => "USN is required"]);
    exit;
}

$usn = $data['usn'];

$stmt = $conn->prepare("DELETE FROM mess_db WHERE student_usn = ?");

if (!$stmt) {
    echo json_encode(["success" => false, "message" => "Prepare failed: " . $conn->error]);
    exit;
}

$stmt->bind_param("s", $usn);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(["success" => true, "message" => "Student deleted successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Student not found"]);
    }
} else {
    echo json_encode(["success" => false, "message" => $stmt->error]);
}

$stmt->close();
