<div class="row-fluid">
    <div class="block">
        <div class="navbar navbar-inner block-header">
            <div class="muted pull-left">Add Student</div>
        </div>
        <div class="block-content collapse in">
            <div class="span12">
                <!-- Standard single student addition -->
                <form id="add_student" method="post">
                    <div class="control-group">
                        <div class="controls">
                            <select name="class_id" class="" required>
                                <option></option>
                                <?php
                                $cys_query = mysqli_query($conn, "select * from class order by class_name");
                                while ($cys_row = mysqli_fetch_array($cys_query)) {
                                ?>
                                    <option value="<?php echo $cys_row['class_id']; ?>"><?php echo $cys_row['class_name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="control-group">
                        <div class="controls">
                            <input name="un" class="input focused" id="focusedInput" type="text" placeholder="ID Number" required>
                        </div>
                    </div>

                    <div class="control-group">
                        <div class="controls">
                            <input name="fn" class="input focused" id="focusedInput" type="text" placeholder="Firstname" required>
                        </div>
                    </div>

                    <div class="control-group">
                        <div class="controls">
                            <input name="ln" class="input focused" id="focusedInput" type="text" placeholder="Lastname" required>
                        </div>
                    </div>

                    <div class="control-group">
                        <div class="controls">
                            <button name="save" class="btn btn-info"><i class="icon-plus-sign icon-large"></i> Add Student</button>
                        </div>
                    </div>
                </form>

                <!-- Bulk upload form -->
                <form id="bulk_upload_form" method="post" enctype="multipart/form-data">
                    <div class="control-group">
                        <div class="controls">
                            <label for="bulk_file">Bulk Upload (CSV):</label>
                            <input type="file" name="bulk_file" id="bulk_file" accept=".csv" required>
                            <button type="submit" class="btn btn-success"><i class="icon-upload icon-large"></i> Upload CSV</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
jQuery(document).ready(function($){
    // Handle single student addition
    $("#add_student").submit(function(e){
        e.preventDefault();
        var _this = $(e.target);
        var formData = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "save_student.php",
            data: formData,
            success: function(html){
                $.jGrowl("Student Successfully Added", { header: 'Student Added' });
                $('#studentTableDiv').load('student_table.php', function(response){
                    $("#studentTableDiv").html(response);
                    $('#example').dataTable({
                        "sDom": "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>",
                        "sPaginationType": "bootstrap",
                        "oLanguage": { "sLengthMenu": "_MENU_ records per page" }
                    });
                    _this.find(":input").val('');
                    _this.find('select option').prop('selected', false);
                    _this.find('select option:first').prop('selected', true);
                });
            }
        });
    });

    // Handle bulk CSV upload
    $("#bulk_upload_form").submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type: "POST",
            url: "bulk_student_upload.php",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response){
                $.jGrowl(response, { header: 'Bulk Upload' });
                $('#studentTableDiv').load('student_table.php', function(response){
                    $("#studentTableDiv").html(response);
                });
            }
        });
    });
});
</script>
	
