<?php include('header.php'); ?>
<?php include('session.php'); ?>
    <body>
        <?php include('navbar.php'); ?>
        <div class="container-fluid">
            <div class="row-fluid">
                <?php include('department_sidebar.php'); ?>
                <div class="span3" id="adduser">
                <?php include('add_department.php'); ?>                   
                </div>
                <div class="span6" id="">
                     <div class="row-fluid">
                        <!-- block -->
                        <div id="block_bg" class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Department List</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
                                    <form action="delete_department.php" method="post">
                                    <table cellpadding="0" cellspacing="0" border="0" class="table" id="example">
                                    <a data-toggle="modal" href="#department_delete" id="delete" class="btn btn-danger" name=""><i class="icon-trash icon-large"></i></a>
                                    <?php include('modal_delete.php'); ?>
                                        <thead>
                                          <tr>
                                                <th></th>
                                                <th>Department</th>
                                                <th>HOD</th>
                                                <th></th>
                                           </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $user_query = mysqli_query($conn, "SELECT * FROM department") or die(mysqli_error($conn));
                                            while ($row = mysqli_fetch_array($user_query)) {
                                                $id = $row['department_id'];
                                                ?>
                                                <tr>
                                                    <td width="30">
                                                        <input id="optionsCheckbox" class="uniform_on" name="selector[]" type="checkbox" value="<?php echo $id; ?>">
                                                    </td>
                                                    <td><?php echo $row['department_name']; ?></td>
                                                    <?php
                                                    // Check if 'hod_id' exists and is valid
                                                    $hod_name = 'Not Assigned';
                                                    if (!empty($row['hod_id'])) {
                                                        $hod_query = mysqli_query($conn, "SELECT * FROM teacher WHERE teacher_id = " . intval($row['hod_id'])) or die(mysqli_error($conn));
                                                        if ($hod_row = mysqli_fetch_array($hod_query)) {
                                                            $hod_name = $hod_row['firstname'] . " " . $hod_row['lastname'];
                                                        }
                                                    }
                                                    ?>
                                                    <td><?php echo $hod_name; ?></td>
                                                    <td width="30">
                                                        <a href="edit_department.php<?php echo '?id=' . $id; ?>" class="btn btn-success"><i class="icon-pencil icon-large"></i></a>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- /block -->
                    </div>
                </div>
            </div>
        <?php include('footer.php'); ?>
        </div>
        <?php include('script.php'); ?>
    </body>
</html>

