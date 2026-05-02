<?php
include "test.php";


$students = $conn->query("SELECT DISTINCT student_usn FROM absentees");

if (!$students) {
    die("Student query failed: " . $conn->error);
}

while ($student = $students->fetch_assoc()) {

    $usn = $student['student_usn'];

   
    $sql = "SELECT absent_date 
            FROM absentees 
            WHERE student_usn = '$usn'
            ORDER BY absent_date";

    $result = $conn->query($sql);

    if (!$result) {
        die("Date query failed for $usn: " . $conn->error);
    }

    $dates = [];

    while ($row = $result->fetch_assoc()) {
        $dates[] = $row['absent_date'];
    }

    if (count($dates) == 0) continue;

    
    $totalReduced = 0;
    $streak = 1;

    for ($i = 1; $i < count($dates); $i++) {

        $prev = strtotime($dates[$i - 1]);
        $curr = strtotime($dates[$i]);

        if (($curr - $prev) == 86400) {
            $streak++;
        } else {
            if ($streak >= 4) {
                $totalReduced += ($streak - 3);
            }
            $streak = 1;
        }
    }

  
    if ($streak >= 4) {
        $totalReduced += ($streak - 3);
    }

   
    $update = "UPDATE mess_db
               SET reduced_no_of_days = $totalReduced 
               WHERE student_usn = '$usn'";

    if (!$conn->query($update)) {
        echo "Update error for $usn: " . $conn->error . "<br>";
    } else {
        echo "$usn → Reduced Days: $totalReduced <br>";
    }
}
?>


