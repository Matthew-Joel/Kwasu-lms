<?php
include('header_dashboard.php');
include('session.php');

// Check if the logged-in user is an HOD
$teacher_id = $_SESSION['id'];
$hod_query = mysqli_query($conn, "SELECT * FROM department WHERE hod_id = '$teacher_id'") or die(mysqli_error($conn));
if (mysqli_num_rows($hod_query) == 0) {
    // Redirect if the user is not an HOD
    header("Location: dashboard_teacher.php");
    exit;
}

// Handle course assignment form submission
if (isset($_POST['assign'])) {
    $subject_id = $_POST['subject_id'];
    $teacher_id = $_POST['teacher_id'];
    $school_year = $_POST['school_year']; // Get school year

    // Check if the subject is already assigned to the teacher
    $check_query = mysqli_query($conn, "SELECT * FROM course_assignments WHERE subject_id = '$subject_id' AND lecturer_id = '$teacher_id' AND school_year = '$school_year'") or die(mysqli_error($conn));
    if (mysqli_num_rows($check_query) > 0) {
        $message = "The teacher is already assigned to this subject for the selected school year.";
    } else {
        // Assign the subject to the teacher in the course_assignments table
        $assign_query = mysqli_query($conn, "INSERT INTO course_assignments (lecturer_id, subject_id, school_year) VALUES ('$teacher_id', '$subject_id', '$school_year')") or die(mysqli_error($conn));
        if ($assign_query) {
            $message = "Subject assigned successfully!";
        } else {
            $message = "Failed to assign the subject. Please try again.";
        }
    }
}

// Fetch all subjects (courses)
$subjects_query = mysqli_query($conn, "SELECT * FROM subject") or die(mysqli_error($conn));

// Fetch all teachers
$teachers_query = mysqli_query($conn, "SELECT * FROM teacher") or die(mysqli_error($conn));
?>

<!DOCTYPE html>
<html lang="en">
    <body>
        <?php include('navbar_teacher.php'); ?>
        <div class="container-fluid">
            <div class="row-fluid">
                <?php include('teacher_sidebar.php'); ?>
                <div class="span9">
                    <h3>Assign Subject to Lecturer</h3>
                    <?php if (isset($message)) { ?>
                        <div class="alert alert-info"><?php echo $message; ?></div>
                    <?php } ?>

                    <form method="POST" action="">
                        <div class="form-group">
                            <label for="subject_id">Select Subject:</label>
                            <select name="subject_id" id="subject_id" class="form-control" required>
                                <option value="">-- Select a Subject --</option>
                                <?php while ($subject = mysqli_fetch_assoc($subjects_query)) { ?>
                                    <option value="<?php echo $subject['subject_id']; ?>"><?php echo $subject['subject_title']; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="teacher_id">Select Lecturer:</label>
                            <select name="teacher_id" id="teacher_id" class="form-control" required>
                                <option value="">-- Select a Lecturer --</option>
                                <?php while ($teacher = mysqli_fetch_assoc($teachers_query)) { ?>
                                    <option value="<?php echo $teacher['teacher_id']; ?>">
                                        <?php echo $teacher['firstname'] . ' ' . $teacher['lastname']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="school_year">School Year:</label>
                            <input type="text" name="school_year" id="school_year" class="form-control" required placeholder="Enter School Year (e.g., 2024/2025)">
                        </div>

                        <button type="submit" name="assign" class="btn btn-primary">Assign Subject</button>
                    </form>
                </div>
            </div>
        </div>
        <?php include('footer.php'); ?>
        <?php include('script.php'); ?>
    </body>
</html>
