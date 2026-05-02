<?php
header("Content-Type: application/json");
include "db.php";

$result = $conn->query(
    "SELECT Sl_no, Student_Name, student_usn, Student_Year, Student_Dept,
            Opening_balance, Total_mess_Rate, Mess_service_charge, GST_18,
            Total_service_charge, Total_mess_Rate_Service,
            reduced_no_of_days, total_days, total_mess_bill,
            closing_mess_amount, water_bill
     FROM mess_db
     ORDER BY Sl_no"
);

if (!$result) {
    echo json_encode(["success" => false, "message" => $conn->error]);
    exit;
}

$students = [];
while ($row = $result->fetch_assoc()) {
    $students[] = $row;
}

echo json_encode(["success" => true, "students" => $students]);
