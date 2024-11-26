<?php
include('dbcon.php');

$department_id = $_POST['department_id'];
$department_name = $_POST['department_name'];
$hod_id = $_POST['hod'];

// Update department and HOD
mysqli_query($conn, "UPDATE department SET department_name = '$department_name', hod_id = '$hod_id' WHERE department_id = '$department_id'") or die(mysqli_error($conn));

header('location: department.php'); // Redirect after updating
?>
