<?php include('header_dashboard.php'); ?>
<?php include('session.php'); ?>

<body id="class_div">
    <?php include('navbar_teacher.php'); ?>
    <div class="container-fluid">
        <div class="row-fluid">
            <?php include('teacher_sidebar.php'); ?>
            <div class="span6" id="content">
                <div class="row-fluid">
                    <!-- Breadcrumb -->
                    <ul class="breadcrumb">
                        <?php
                        // Fetch the current school year
                        $school_year_query = mysqli_query($conn, "SELECT * FROM school_year ORDER BY school_year DESC LIMIT 1") or die(mysqli_error($conn));
                        if (mysqli_num_rows($school_year_query) > 0) {
                            $school_year_row = mysqli_fetch_array($school_year_query);
                            $school_year = $school_year_row['school_year'];
                        } else {
                            $school_year = "N/A"; // Fallback if no school year is found
                        }
                        ?>
                        <li><a href="#"><b>My Class</b></a><span class="divider">/</span></li>
                        <li><a href="#">School Year: <?php echo $school_year; ?></a></li>
                    </ul>
                    <!-- End Breadcrumb -->
                    
                    <!-- Block -->
                    <div class="block">
                        <div class="navbar navbar-inner block-header">
                            <div id="count_class" class="muted pull-right"></div>
                        </div>
                        <div class="block-content collapse in">
                            <div class="span12">
                                <?php
                                // Fetch assigned courses for the logged-in teacher
                                $teacher_id = $_SESSION['id']; // Ensure the session is valid
                                $assigned_courses_query = mysqli_query($conn, "
                                    SELECT subject.subject_code, subject.subject_title, department.department_name
                                    FROM course_assignments
                                    JOIN subject ON course_assignments.subject_id = subject.subject_id
                                    JOIN teacher ON course_assignments.lecturer_id = teacher.teacher_id
                                    JOIN department ON teacher.department_id = department.department_id
                                    WHERE course_assignments.lecturer_id = '$teacher_id'
                                    AND course_assignments.school_year = '$school_year'
                                ") or die(mysqli_error($conn));

                                if (mysqli_num_rows($assigned_courses_query) > 0) {
                                    echo "<h4>Your Assigned Courses</h4>";
                                    echo "<table class='table table-bordered'>";
                                    echo "<thead><tr><th>Course Code</th><th>Course Title</th><th>Department</th></tr></thead><tbody>";

                                    while ($row = mysqli_fetch_assoc($assigned_courses_query)) {
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($row['subject_code']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['subject_title']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['department_name']) . "</td>";
                                        echo "</tr>";
                                    }

                                    echo "</tbody></table>";
                                } else {
                                    echo "<p>You have not been assigned any courses yet.</p>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <!-- /Block -->

                    <!-- Additional Options for HOD -->
                    <?php
                    // Check if the teacher is an HOD
                    $hod_query = mysqli_query($conn, "SELECT * FROM department WHERE hod_id = '$teacher_id'") or die(mysqli_error($conn));
                    if (mysqli_num_rows($hod_query) > 0) {
                        // Display additional options for HOD
                        ?>
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <h4>HOD Options</h4>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
                                    <ul>
                                        <li><a href="assign_course.php">Assign Courses to Lecturers</a></li>
                                      <!--  <li><a href="manage_department.php">Manage Department</a></li>
                                        <li><a href="view_reports.php">View Departmental Reports</a></li> -->
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
         
        </div>
        <?php include('footer.php'); ?>
    </div>
    <?php include('script.php'); ?>
</body>
</html>


