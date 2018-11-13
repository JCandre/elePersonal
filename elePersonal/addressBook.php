<?php include 'core/init.php';
protect_page();
include 'includes/masterLayout/header.php'; ?>

<div class="wrapper">
    <div class="content-main">
        <?php include 'includes/aside.php'; ?>


        <!--Main Content-->
        <div id="page-wrapper" class="dashbard-1">
            <div class="content-main">
                <button class="btn btn-primary btn-lg pull-right" type="button" name="add" id="add">Add</button>
                <h1 class="page-header">Contacts
                    <small>Details</small>
                </h1>

                <br/>
                <!--Render contacts list-->
                <div>
                    <div id="addressBook_data" class="table-responsive">
                    </div>
                    <br/>
                </div>

                <!--Form-->
                <div id="form_dialog" title="Add Contact">
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

                <!-- Success alert popup-->
                <div id="action_alert" title="Action">

                </div>
                <!-- Delete alert popup-->
                <div id="delete_alert" title="Are you sure?">
                    <p>Delete this contact?</p>
                </div>


            </div>
        </div>

    </div>
</div>


<?php include 'includes/masterLayout/footer.php'; ?>

<script>
    $(document).ready(function () {

        loadAddressBook()

        function loadAddressBook() {
            $.ajax({
                url: "core/functions/addressBook_fetch.php",
                method: "POST",
                success: function (data) {
                    $('#addressBook_data').html(data);
                }
            })

        }

        //initialize contact form dialog and set to hidden
        $("#form_dialog").dialog({
            autoOpen: false,
            width: 400
        });

        //add click event to add contact button
        $('#add').click(function () {
            $('#form_dialog').attr('title', 'Add Contact'); //set dialog box title
            $('#action').val('insert'); //set value to insert action
            $('#form_action').val('Insert'); //
            $('#contact_form')[0].reset();
            $('#form_action').attr('disabled', false);
            $("#form_dialog").dialog('open'); //open dialog box
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
                        $('#form_dialog').dialog('close'); //Close form dialog
                        $('#action_alert').html(data); //
                        $('#action_alert').dialog('open'); //open success dialog
                        loadAddressBook() //reload page data
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
            var id = $(this).attr('id'); //fetch contact id
            console.log(id);
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
                    $('#form_dialog').attr('title', 'Contact Information');
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
                        url: "core/functions/addressBook_action.php",
                        method: "POST",
                        data: {id: id, action: action},
                        success: function (data) {
                            $('#delete_alert').dialog('close');
                            $('#action_alert').html(data);
                            $('#action_alert').dialog('open');
                            loadAddressBook() //reload page data
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

