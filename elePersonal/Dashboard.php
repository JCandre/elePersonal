<?php include 'core/init.php';
protect_page();
include 'includes/masterLayout/header.php';
//define variable for fucntions
$i = $session_user_id;

function getEventsCount()
{

    $db = new mysqli('localhost', 'root', '', 'elePersonal');
    $result = mysqli_fetch_assoc($db->query("SELECT COUNT(id) as count FROM events WHERE user_fk= '" . $GLOBALS['i'] . "'"));
    return $result['count'];

}

function getContactsCount()
{
    $db = new mysqli('localhost', 'root', '', 'elePersonal');
    $result = mysqli_fetch_assoc($db->query("SELECT COUNT(contact_id) as count FROM contacts WHERE user_fk= '" . $GLOBALS['i'] . "'"));
    return $result['count'];

}

function getMemosCount()
{
    $db = new mysqli('localhost', 'root', '', 'elePersonal');
    $result = mysqli_fetch_assoc($db->query("SELECT COUNT(note_id) as count FROM notes WHERE user_fk= '" . $GLOBALS['i'] . "'"));
    return $result['count'];

}

function getUnCompleteTasksCount()
{
    $db = new mysqli('localhost', 'root', '', 'elePersonal');
    $result = mysqli_fetch_assoc($db->query("SELECT COUNT(task_id) as count FROM tasks WHERE user_fk= '" . $GLOBALS['i'] . "'"));
    return $result['count'];

}

?>

<div class="wrapper">
    <div class="content-main">
        <?php include 'includes/aside.php'; ?>

        <!--Main Content-->
        <div id="page-wrapper" class="dashbard-1">
            <div class="content-main">
                <h1 class="page-header">Dashboard
                    <small>Overview</small>
                </h1>

                <!-- Left col -->
                <section class="col-lg-7 connectedSortable">
                    <!--Calendar widget-->
                    <div class="" style="width: 350pt;">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <button class="btn btn-primary btn-xs pull-right" type="button" name="addEvent"
                                        id="addEvent">Add
                                </button>
                                <h3 class="panel-title"><a href="Calendar.php">Your Agenda</a></h3>
                            </div>
                            <div class="panel-body">
                                <!-- Display Calendar  -->
                                <div id="renderCalendar"></div>
                            </div>
                            <div class="panel-footer">
                                <a>
                                    Number of agendas in calender:
                                    <strong><?php echo getEventsCount(); ?></strong>

                                </a>


                            </div>
                        </div>
                    </div>
                    <!--End Calendar-->

                    <!-- Tasks List -->
                    <div class="" style="width: 350pt;">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <button class="btn btn-primary btn-xs pull-right" type="button" name="addTask"
                                        id="addTask">Add
                                </button>
                                <h3 class="panel-title"><a href="Memos.php">To-Do List</a></h3>

                            </div>
                            <div class="panel-body">
                                <!--Render contacts list-->
                                <div id="task_data" class="table-responsive" style="height: 30%;"></div>
                            </div>
                            <div class="panel-footer">
                                <a>
                                    Number of tasks:
                                    <strong><span
                                                id="tasksCount"><?php echo getUnCompleteTasksCount() ?></span></strong>
                                </a>

                            </div>
                        </div>
                    </div>
                    <!-- End memos List -->
                </section>

                <!-- Right col -->
                <section class="col-lg-5 connectedSortable">
                    <!-- Contacts List -->
                    <div class="" style="width: 350pt;">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <button class="btn btn-primary btn-xs pull-right" type="button" name="addContact"
                                        id="addContact">Add
                                </button>
                                <h3 class="panel-title"><a href="addressBook.php">Stored Contacts</a></h3>

                            </div>
                            <div class="panel-body">
                                <!--Render contacts list-->
                                <div id="addressBook_data" class="table-responsive" style="height: 30%;"></div>
                            </div>
                            <div class="panel-footer">
                                <a>
                                    Number of contacts:
                                    <strong><span id="contactsCount"><?php echo getContactsCount(); ?></span></strong>
                                </a>

                            </div>
                        </div>
                    </div>
                    <!-- End Contacts List -->

                    <!-- Memos List -->
                    <div class="" style="width: 350pt;">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <button class="btn btn-primary btn-xs pull-right" type="button" name="addMemo"
                                        id="addMemo">Add
                                </button>
                                <h3 class="panel-title"><a href="Memos.php">Personal Memos</a></h3>

                            </div>
                            <div class="panel-body">
                                <!--Render contacts list-->
                                <div id="memo_data" class="table-responsive" style="height: 30%;"></div>
                            </div>
                            <div class="panel-footer">
                                <a>
                                    Number of memos saved:
                                    <strong><span id="memosCount"><?php echo getMemosCount(); ?></span></strong>
                                </a>

                            </div>
                        </div>
                    </div>
                    <!-- End memos List -->


                </section>


                <!--Add contacts form-->
                <div id="contact_form_dialog" title="Contact Information">
                    <form method="post" id="contact_form">
                        <div class="form-group">
                            <label>Contact Name</label>
                            <input type="text" name="name" id="name" maxlength="32" required="required"
                                   class="form-control" placeholder="Enter name (REQUIRED)"/>
                            <span id="error_name" class="text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label>Birthday</label>
                            <input type="date" name="birthday" id="birthday" maxlength="32" class="form-control"
                                   placeholder="Enter birthday"/>
                        </div>
                        <div class="form-group">
                            <label>Occupation</label>
                            <input type="text" name="work" id="work" maxlength="32" class="form-control"
                                   placeholder="Enter position"/>
                        </div>
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="text" name="phone" id="phone" maxlength="11" class="form-control"
                                   placeholder="Enter phone number"/>
                        </div>
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="text" name="email" id="email" maxlength="1024" required="required"
                                   class="form-control" placeholder="Enter email address"/>
                            <span id="error_email" class="text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label>Home Address</label>
                            <input type="text" name="address" id="address" maxlength="1024" class="form-control"
                                   placeholder="Enter home address"/>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="action" id="action" value="insert"/>
                            <input type="hidden" name="hidden_id" id="hidden_id"/>
                            <input type="submit" name="form_action" id="form_action" class="btn btn-info"
                                   value="Insert"/>
                        </div>
                    </form>

                </div>

                <!--Memo form-->
                <div id="memo_form_dialog" title="Memo Details">
                    <form method="post" id="memo_form">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="title" id="title" maxlength="255" required="required"
                                   class="form-control" placeholder="Enter title (REQUIRED)"/>
                            <span id="error_title" class="text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label>Memo</label>
                            <textarea class="form-control" name="message" id="message" maxlength="1024"
                                      placeholder="Memo..."></textarea>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="action" id="memo_action" value="insert"/>
                            <input type="hidden" name="hidden_id" id="memo_hidden_id"/>
                            <input type="submit" name="memo_form_action" id="memo_form_action" class="btn btn-info"
                                   value="Insert"/>
                        </div>
                    </form>

                </div>

                <!--Task form-->
                <div id="task_form_dialog" title="Task Details">
                    <form method="post" id="task_form">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="title" id="task_title" maxlength="255" required="required"
                                   class="form-control" placeholder="Enter title (REQUIRED)"/>
                            <span id="task_error_title" class="text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label>Task</label>
                            <textarea class="form-control" name="message" id="task_message" maxlength="1024"
                                      placeholder="Task..."></textarea>
                        </div>
                        <div class="form-group">
                            <label>Complete by:</label>
                            <input type="datetime" value="<?php echo date('Y-m-d H:i:s'); ?>" name="complete_by"
                                   id="complete_by" class="form-control" placeholder="Enter date and time to complete"/>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="action" id="task_action" value="insert"/>
                            <input type="hidden" name="hidden_id" id="task_hidden_id"/>
                            <input type="submit" name="task_form_action" id="task_form_action" class="btn btn-info"
                                   value="Insert"/>
                        </div>
                    </form>

                </div>

                <!-- Success alert popup-->
                <div id="action_alert" title="Action">

                </div>
            </div>


        </div>
    </div>


    <?php include 'includes/masterLayout/footer.php'; ?>

    <script>
        $(document).ready(function () {
            loadTasks()
            loadAddressBook()
            loadMemos()

            //Configure and display the calender///////////////////////////////////////////////////
            var calendar = $('#renderCalendar').fullCalendar({
                editable: true,
                //set buttons
                header: {
                    left: '',
                    center: 'title',
                    right: ''
                },

                //customise button name
                views: {
                    listWeek: {buttonText: 'Agenda'}
                },

                defaultView: 'listWeek',
                eventLimit: true,
                //load data
                events: 'core/functions/calendar_load.php',


                eventClick: function (event) {
                    if (confirm("Are you sure you want to remove it?")) {
                        var id = event.id;
                        $.ajax({
                            url: "core/functions/calendar_delete.php",
                            type: "POST",
                            data: {id: id},
                            success: function () {
                                calendar.fullCalendar('refetchEvents');
                                alert("Event Removed");
                            }
                        })
                    }
                },


            });

            //add click event to add contact button
            $('#addEvent').click(function () {
                window.location.href = "calendar.php";
            });

            //End calender///////////////////////////////////////////////////////////////////////

            //Configure and load contacts///////////////////////////////////////////////////////

            function loadAddressBook() {
                $.ajax({
                    url: "core/functions/dash_contacts_fetch.php",
                    method: "POST",
                    success: function (data) {
                        $('#addressBook_data').html(data);
                    }
                })

            }

            //initialize contact form dialog and set to hidden
            $("#contact_form_dialog").dialog({
                autoOpen: false,
                width: 400
            });


            //add click event to add contact button
            $('#addContact').click(function () {
                $('#contact_form_dialog').attr('title', 'Add Contact'); //set dialog box title
                $('#action').val('insert'); //set value to insert action
                $('#form_action').val('Insert'); //
                $('#contact_form')[0].reset();
                $('#form_action').attr('disabled', false);
                $("#contact_form_dialog").dialog('open'); //open dialog box
            });

            //Form validation -> submit if no error
            $('#contact_form').on('submit', function (event) {
                event.preventDefault();
                var error_name = '';
                var error_email = '';
                if ($('#name').val() == '') {
                    error_name = 'Name is required';
                    $('#error_name').text(error_name); //Display message below text box
                    $('#name').css('border-color', '#cc0000'); //change border colour to red if error
                }
                else {
                    //If no error change nothing
                    error_name = '';
                    $('#error_name').text(error_name);
                    $('#name').css('border-color', '');
                }
                if ($('#email').val() == '') {
                    error_email = 'Last Name is required';
                    $('#error_email').text(error_email); //Display message below text box
                    $('#email').css('border-color', '#cc0000'); //change border colour to red if error
                }
                else {
                    //If no error change nothing
                    error_email = '';
                    $('#error_email').text(error_email);
                    $('#name').css('border-color', '');
                }


                if (error_name != '' || error_email != '') {
                    return false; //Form data will not be submit
                }
                else {
                    $('#form_action').attr('disabled', 'disabled'); //prevent double click (multiple submissions)
                    var form_data = $(this).serialize(); //Convert form data to url encoded string
                    $.ajax({
                        url: "core/functions/addressBook_action.php",
                        method: "POST",
                        data: form_data,
                        success: function (data) {
                            $('#contact_form_dialog').dialog('close'); //Close form dialog
                            loadAddressBook() //reload page data
                            $('#action_alert').html(data); //
                            $('#action_alert').dialog('open'); //open success dialog
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
            $(document).on('click', '.viewContact', function () {
                console.log("View clicked")
                var id = $(this).attr('id'); //fetch contact id
                var action = 'fetch_single';
                $.ajax({
                    url: "core/functions/addressBook_action.php",
                    method: "POST",
                    data: {id: id, action: action},
                    dataType: "json",
                    success: function (data) {
                        $('#name').val(data.rName);
                        $('#work').val(data.rWork);
                        $('#phone').val(data.rPhone);
                        $('#email').val(data.rEmail);
                        $('#address').val(data.rAddress);
                        $('#birthday').val(data.rBirthday);
                        $('#hidden_id').val(id);
                        $('#contact_form_dialog').attr('title', 'Contact Information');
                        $('#form_action').val('Update'); //Change form button label
                        $('#action').val('update');
                        $("#contact_form_dialog").dialog('open'); //open dialog box
                    }
                });
            });

            //End Contacts//////////////////////////////////////////////////////////////////////

            //Configure and load memos/////////////////////////////////////////////////////////

            function loadMemos() {
                $.ajax({
                    url: "core/functions/dash_memo_fetch.php",
                    method: "POST",
                    success: function (data) {
                        $('#memo_data').html(data);
                    }
                })
            }

            //initialize memo form dialog and set to hidden
            $("#memo_form_dialog").dialog({
                autoOpen: false,
                width: 400
            });

            //add click event to add contact button
            $('#addMemo').click(function () {
                $('#memo_form_dialog').attr('title', 'Add Memo'); //set dialog box title
                $('#memo_action').val('insert'); //set value to insert action
                $('#memo_form_action').val('Insert'); //
                $('#memo_form')[0].reset();
                $('#memo_form_action').attr('disabled', false);
                $("#memo_form_dialog").dialog('open'); //open dialog box
            });


            //Form validation -> submit if no error
            $('#memo_form').on('submit', function (event) {
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
                    $('#memo_form_action').attr('disabled', 'disabled'); //prevent double click (multiple submissions)
                    var form_data = $(this).serialize(); //Convert form data to url encoded string
                    $.ajax({
                        url: "core/functions/memo_action.php",
                        method: "POST",
                        data: form_data,
                        success: function (data) {
                            $('#memo_form_dialog').dialog('close'); //Close form dialog
                            $('#action_alert').html(data); //
                            $('#action_alert').dialog('open'); //open success dialog
                            loadMemos() //reload page data
                            $('#memo_form_action').attr('disabled', false);
                        }
                    });
                }

            });

            //add click event to edit memo button
            $(document).on('click', '.viewMemo', function () {

                var id = $(this).attr('id'); //fetch contact id
                console.log(id)
                var action = 'fetch_single';
                $.ajax({
                    url: "core/functions/memo_action.php",
                    method: "POST",
                    data: {id: id, action: action},
                    dataType: "json",
                    success: function (data) {
                        $('#title').val(data.rTitle);
                        $('#message').val(data.rMessage);
                        $('#memo_hidden_id').val(id);
                        $('#memo_form_dialog').attr('title', 'Memo Information');
                        $('#memo_form_action').val('Update'); //Change form button label
                        $('#memo_action').val('update');
                        $("#memo_form_dialog").dialog('open'); //open dialog box
                    }
                });
            });

            //End memo config/////////////////////////////////////////////////

            //Configure and load to-do list///////////////////////////////////


            function loadTasks() {
                $.ajax({
                    url: "core/functions/dash_task_fetch.php",
                    method: "POST",
                    success: function (data) {
                        $('#task_data').html(data);
                    }
                })
            }

            //initialize task form dialog and set to hidden
            $("#task_form_dialog").dialog({
                autoOpen: false,
                width: 400
            });

            //add click event to add contact button
            $('#addTask').click(function () {
                $('#task_form_dialog').attr('title', 'Add Task'); //set dialog box title
                $('#task_action').val('insert'); //set value to insert action
                $('#task_form_action').val('Insert'); //
                $('#task_form')[0].reset();
                $('#task_form_action').attr('disabled', false);
                $("#task_form_dialog").dialog('open'); //open dialog box
            });

            //Form validation -> submit if no error
            $('#task_form').on('submit', function (event) {
                event.preventDefault();
                var error_title = '';
                if ($('#task_title').val() == '') {
                    error_title = 'Title is required';
                    $('#task_error_title').text(error_title); //Display message below text box
                    $('#task_title').css('border-color', '#cc0000'); //change border colour to red if error
                }
                else {
                    //If no error change nothing
                    error_title = '';
                    $('#task_error_title').text(error_title);
                    $('#task_title').css('border-color', '');
                }


                if (error_title != '') {
                    return false; //Form data will not be submit
                }
                else {
                    $('#task_form_action').attr('disabled', 'disabled'); //prevent double click (multiple submissions)
                    var form_data = $(this).serialize(); //Convert form data to url encoded string
                    $.ajax({
                        url: "core/functions/task_action.php",
                        method: "POST",
                        //get current date and time
                        data: form_data,
                        success: function (data) {
                            $('#task_form_dialog').dialog('close'); //Close form dialog
                            loadTasks() //reload page data
                            $('#action_alert').html(data); //
                            $('#action_alert').dialog('open'); //open success dialog
                            $('#task_form_action').attr('disabled', false);
                        }
                    });
                }

            });

            //add click event to edit contact button
            $(document).on('click', '.viewTask', function () {
                var id = $(this).attr('id'); //fetch contact id
                console.log(id);
                var action = 'fetch_single';
                $.ajax({
                    url: "core/functions/task_action.php",
                    method: "POST",
                    data: {id: id, action: action},
                    dataType: "json",
                    success: function (data) {
                        $('#task_title').val(data.rTitle);
                        $('#task_message').val(data.rMessage);
                        $('#task_hidden_id').val(id);
                        $('#task_form_dialog').attr('title', 'Task Information');
                        $('#task_form_action').val('Update'); //Change form button label
                        $('#task_action').val('update');
                        $("#task_form_dialog").dialog('open'); //open dialog box
                    }
                });
            });

            //End task list/////////////////////////////////////////////////


        });
    </script>

