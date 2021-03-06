<?php include 'core/init.php';
protect_page();
include 'includes/masterLayout/header.php';
date_default_timezone_set("Europe/London");
?>

<div class="wrapper">
    <div class="content-main">
        <?php include 'includes/aside.php'; ?>


        <!--Main Content-->
        <div id="page-wrapper" class="dashbard-1">
            <div class="content-main">
                <button class="btn btn-primary btn-lg pull-right" type="button" name="add" id="add">Add</button>
                <h1 class="page-header">To-Do
                    <small>List</small>
                </h1>

                <br/>

                <!--Render contacts list-->
                <div class="col-md-8 col-md-offset-2">
                    <div id="task_data" class="table-responsive">
                    </div>
                    <br/>
                </div>

                <!--Form-->
                <div id="form_dialog" title="Task Details">
                    <form method="post" id="task_form">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="title" id="title" maxlength="255" required="required"
                                   class="form-control" placeholder="Enter title (REQUIRED)"/>
                            <span id="error_title" class="text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label>Task</label>
                            <textarea class="form-control" name="message" id="message" maxlength="1024"
                                      placeholder="Task..."></textarea>
                        </div>
                        <div class="form-group">
                            <label>Complete by:</label>
                            <input type="datetime" value="<?php echo date('Y-m-d H:i:s'); ?>" name="complete_by"
                                   id="complete_by" class="form-control" placeholder="Enter date and time to complete"/>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="action" id="action" value="insert"/>
                            <input type="hidden" name="hidden_id" id="hidden_id"/>
                            <input type="submit" name="form_action" id="form_action" class="btn btn-info"
                                   value="Insert"/>
                        </div>
                    </form>

                </div>

                <!-- Success alert popup-->
                <div id="action_alert" title="Action">

                </div>
                <!-- Delete alert popup-->
                <div id="delete_alert" title="Are you sure?">
                    <p>Delete this task?</p>
                </div>
            </div>
        </div>

    </div>
</div>


<?php include 'includes/masterLayout/footer.php'; ?>

<script>
    $(document).ready(function () {


        loadTasks()

        function loadTasks() {
            $.ajax({
                url: "core/functions/task_fetch.php",
                method: "POST",
                success: function (data) {
                    $('#task_data').html(data);
                }
            })

        }


        //initialize memo form dialog and set to hidden
        $("#form_dialog").dialog({
            autoOpen: false,
            width: 400
        });

        //add click event to add contact button
        $('#add').click(function () {
            $('#form_dialog').attr('title', 'Add Task'); //set dialog box title
            $('#action').val('insert'); //set value to insert action
            $('#form_action').val('Insert'); //
            $('#task_form')[0].reset();
            $('#form_action').attr('disabled', false);
            $("#form_dialog").dialog('open'); //open dialog box
        });

        //Form validation -> submit if no error
        $('#task_form').on('submit', function (event) {
            event.preventDefault();
            var error_title = '';
            if ($('#title').val() == '') {
                error_title = 'Title is required';
                $('#error_title').text(error_title); //Display message below text box
                $('#title').css('border-color', '#cc0000'); //change border colour to red if error
            }
            else {
                //If no error change nothing
                error_title = '';
                $('#error_title').text(error_title);
                $('#title').css('border-color', '');
            }


            if (error_title != '') {
                return false; //Form data will not be submit
            }
            else {
                $('#form_action').attr('disabled', 'disabled'); //prevent double click (multiple submissions)
                var form_data = $(this).serialize(); //Convert form data to url encoded string
                $.ajax({
                    url: "core/functions/task_action.php",
                    method: "POST",
                    //get current date and time
                    data: form_data,
                    success: function (data) {
                        $('#form_dialog').dialog('close'); //Close form dialog
                        $('#action_alert').html(data); //
                        $('#action_alert').dialog('open'); //open success dialog
                        loadTasks() //reload page data
                        $('#form_action').attr('disabled', false);
                    }
                });
            }

        });

        //initialize alert dialog and set hidden
        $('#action_alert').dialog({
            autoOpen: false
        });

        //add click event to edit contact button
        $(document).on('click', '.view', function () {
            console.log("View clicked")
            var id = $(this).attr('id'); //fetch contact id
            var action = 'fetch_single';
            $.ajax({
                url: "core/functions/task_action.php",
                method: "POST",
                data: {id: id, action: action},
                dataType: "json",
                success: function (data) {
                    $('#title').val(data.rTitle);
                    $('#message').val(data.rMessage);
                    //$('#complete_by').val(data.rDue);
                    $('#hidden_id').val(id);
                    $('#form_dialog').attr('title', 'Task Information');
                    $('#form_action').val('Update'); //Change form button label
                    $('#action').val('update');
                    $("#form_dialog").dialog('open'); //open dialog box
                }
            });
        });

        $('#delete_alert').dialog({
            autoOpen: false,
            modal: true,
            buttons: {
                Yes: function () {
                    var id = $(this).data('id');
                    var action = 'delete';
                    $.ajax({
                        url: "core/functions/task_action.php",
                        method: "POST",
                        data: {id: id, action: action},
                        success: function (data) {
                            $('#delete_alert').dialog('close');
                            $('#action_alert').html(data);
                            $('#action_alert').dialog('open');
                            loadTasks() //reload page data
                        }
                    });
                },
                Cancel: function () {
                    $(this).dialog('close');
                }
            }
        });

        $(document).on('click', '.delete', function () {
            var id = $(this).attr("id");
            $('#delete_alert').data('id', id).dialog('open');
        });


    });
</script>
