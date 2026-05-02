<?php
include "test.php";

$sql = "UPDATE mess_db
        SET water_bill = 
            CASE 
                WHEN reduced_no_of_days > 0 THEN 51
                ELSE 50
            END";

if ($conn->query($sql) === TRUE) {
    echo "Water bill updated successfully";
} else {
    echo "Error: " . $conn->error;
}
?>