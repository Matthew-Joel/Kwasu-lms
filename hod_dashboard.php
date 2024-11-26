<?php
    include('dbcon.php');
    session_start();
    if ($_SESSION['role'] != 'hod') {
        header("Location: login.php");  // Redirect if not HOD
        exit();
    }

    // Fetch courses and lecturers for assignment
    $courses = mysqli_query($conn, "SELECT * FROM courses") or die(mysqli_error($conn));
    $lecturers = mysqli_query($conn, "SELECT * FROM users WHERE role = 'teacher'") or die(mysqli_error($conn));

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Assign course to lecturer
        $course_id = $_POST['course_id'];
        $lecturer_id = $_POST['lecturer_id'];

        $query = "INSERT INTO course_assignments (lecturer_id, course_id, assigned_by) 
                  VALUES ('$lecturer_id', '$course_id', '" . $_SESSION['id'] . "')";
        if (mysqli_query($conn, $query)) {
            echo "Course assigned successfully!";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>HOD Dashboard - Assign Courses</title>
</head>
<body>
    <h2>HOD Dashboard</h2>
    <form method="POST">
        <label for="course">Select Course:</label>
        <select name="course_id" id="course">
            <?php while ($course = mysqli_fetch_assoc($courses)) { ?>
                <option value="<?php echo $course['course_id']; ?>"><?php echo $course['course_name']; ?></option>
            <?php } ?>
        </select><br><br>

        <label for="lecturer">Select Lecturer:</label>
        <select name="lecturer_id" id="lecturer">
            <?php while ($lecturer = mysqli_fetch_assoc($lecturers)) { ?>
                <option value="<?php echo $lecturer['user_id']; ?>"><?php echo $lecturer['firstname'] . ' ' . $lecturer['lastname']; ?></option>
            <?php } ?>
        </select><br><br>

        <input type="submit" value="Assign Course">
    </form>
</body>
</html>
