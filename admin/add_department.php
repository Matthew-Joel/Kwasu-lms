<div class="row-fluid">
    <!-- block -->
    <div class="block">
        <div class="navbar navbar-inner block-header">
            <div class="muted pull-left">Add Department</div>
        </div>
        <div class="block-content collapse in">
            <div class="span12">
                <!-- Form submission -->
                <form method="post" action="add_department_action.php">
                    <div class="control-group">
                        <div class="controls">
                            <input class="input focused" id="focusedInput" name="department_name" type="text" placeholder="Department" required>
                        </div>
                    </div>

                    <div class="control-group">
                        <div class="controls">
                            <input class="input focused" id="focusedInput" name="person_in_charge" type="text" placeholder="Person In-charge" required>
                        </div>
                    </div>

                    <label for="hod">Assign HOD:</label>
                    <select name="hod" required>
                        <option value="">Select Teacher</option>
                        <?php
                        // Fetch teachers from the database
                        $teacher_query = mysqli_query($conn, "SELECT * FROM teacher") or die(mysqli_error($conn));
                        while ($teacher_row = mysqli_fetch_array($teacher_query)) {
                            echo "<option value='" . $teacher_row['teacher_id'] . "'>" . $teacher_row['firstname'] . " " . $teacher_row['lastname'] . "</option>";
                        }
                        ?>
                    </select>

                    <div class="control-group">
                        <div class="controls">
                            <button name="save" class="btn btn-info"><i class="icon-plus-sign icon-large"></i> Add Department</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /block -->
</div>
