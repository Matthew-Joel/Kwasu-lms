<?php
include('dbcon.php');

// Check if the form is submitted
if (isset($_POST['save'])) {
    // Sanitize inputs to prevent SQL injection
    $department_name = mysqli_real_escape_string($conn, $_POST['department_name']);
    $person_in_charge = mysqli_real_escape_string($conn, $_POST['person_in_charge']);
    $hod = mysqli_real_escape_string($conn, $_POST['hod']);

    // Debug: print the form values to ensure they are correct
    // echo "Department: $department_name, Person In Charge: $person_in_charge, HOD ID: $hod<br>";

    // Check if the department already exists
    $query = mysqli_query($conn, "SELECT * FROM department WHERE department_name = '$department_name'") or die("Query failed: " . mysqli_error($conn));
    $count = mysqli_num_rows($query);

    if ($count > 0) {
        // Department already exists
        echo "<script>alert('Department already exists.'); window.location = 'department.php';</script>";
    } else {
        // Insert the new department with HOD and dean
        $insert_query = "INSERT INTO department (department_name, dean, hod_id) VALUES ('$department_name', '$person_in_charge', '$hod')";
        
        if (mysqli_query($conn, $insert_query)) {
            // Redirect to the department page
            echo "<script>window.location = 'department.php';</script>";
        } else {
            // Error in query execution
            echo "<script>alert('Error adding department'); window.location = 'department.php';</script>";
        }
    }
}
?>


