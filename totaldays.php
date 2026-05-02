<?php
include "test.php";

$sql = "UPDATE mess_db m
        JOIN (
            SELECT student_usn,
                   DAY(LAST_DAY(MAX(absent_date))) AS days_in_month
            FROM absentees
            GROUP BY student_usn
        ) a
        ON m.student_usn = a.student_usn
        SET m.total_days = a.days_in_month - m.reduced_no_of_days";

if ($conn->query($sql) === TRUE) {
    echo "Total days updated successfully";
} else {
    echo "Error: " . $conn->error;
}
?>