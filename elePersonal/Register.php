<?php
include 'core/init.php';
logged_in_redirect();
include 'includes/masterLayout/header.php';


//check that the form has been submitted and validate form data
if (empty($_POST) === false) {
    $required_fields = array('name', 'surname', 'username', 'email', 'password', 'rpassword');

    foreach ($_POST as $key => $value) {
        //if a value that has been set to required is empty
        if (empty($value) && in_array($key, $required_fields) === true) {
            $errors[] = 'Highlighted fields are required';
            //exit loop if 1 error is found
            break 1;
        }
    }

    if (empty($errors) === true) {
        //stop existing user account being made again
        if (user_exists($_POST['username']) === true) {
            $errors[] = 'Username already taken!';
        }

        //check for spaces within username
        if (preg_match("/\\s/", $_POST['username'])) {
            $errors[] = 'Username cannot contain spaces';
        }

        //make sure pass if more than 6 chars
        if (strlen($_POST['password']) < 8 && strlen($_POST['password']) > 32) {
            $errors[] = 'Password must be between 8 and 32 characters long';
        }

        //check pass match
        if ($_POST['password'] !== $_POST['rpassword']) {
            $errors[] = 'Passwords do not match';
        }

        //check email is valid
        if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
            $errors[] = 'Valid email address required';
        }

        //check if email already stored in database
        if (email_exists($_POST['email']) === true) {
            $errors[] = 'Email already in use, try resetting your password';
        }
    }

}
?>

    <div class="container">
        <?php
        //if url contains success, echo message to user
        if (isset($_GET['success']) && empty($_GET['success'])) {
            echo 'You have been successfully registered';
        } else {
            if (empty($_POST) === false && empty($errors) === true) {
                $hash = md5(rand(0, 1000)); // Generate random 32 character hash and assign it to a local variable.
                //create array data object from form
                $register_data = array(
                    'username' => $_POST['username'],
                    'name' => $_POST['name'],
                    'surname' => $_POST['surname'],
                    'email' => $_POST['email'],
                    'phone_number' => $_POST['phone_number'],
                    'hash' => $hash,
                    'password' => $_POST['password']
                );
                register_user($register_data);

                verify($_POST['email'], $_POST['surname'], $hash); //send verification email
                //header('Location: Register.php?success');
                echo "<script type='text/javascript'> alert('You have been successfully registered'); window.location ='Index.php'; </script>";
                exit();
            } else if (empty($errors) === false) {
                // show the array as javascript object and redirect to index
                echo outputErrors($errors);
            }
        }
        ?>
        <div class="stepwizard">
            <div class="stepwizard-row setup-panel">
                <div class="stepwizard-step">
                    <a href="#step-1" type="button" class="btn btn-primary btn-circle">1</a>
                    <p>Step 1</p>
                </div>
                <div class="stepwizard-step">
                    <a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
                    <p>Step 2</p>
                </div>
                <div class="stepwizard-step">
                    <a href="#step-3" type="button" class="btn btn-default btn-circle" disabled="disabled">3</a>
                    <p>Step 3</p>
                </div>
            </div>
        </div>
        <p class="text-center">Use the form below to register for an account with us. All fields marked with an (<span
                    class="red">*</span>) are required.</p>
        <form action="Register.php" method="post">
            <div class="row setup-content" id="step-1">
                <div class="col-xs-12">
                    <div class="col-md-12">
                        <h3> Step 1</h3>
                        <div class="form-group">
                            <label class="control-label">First Name<span class="red">*</span></label>
                            <input name="name" maxlength="32" type="text" required="required" class="form-control"
                                   placeholder="Enter your First Name (required)"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Last Name<span class="red">*</span></label>
                            <input name="surname" maxlength="32" type="text" required="required" class="form-control"
                                   placeholder="Enter your Last Name (required)"/>
                        </div>
                        <a href="Index.php" class="btn btn-danger cancelBtn btn-lg" role="button">Cancel</a>
                        <button class="btn btn-primary nextBtn btn-lg pull-right" type="button">Next</button>
                    </div>
                </div>
            </div>
            <div class="row setup-content" id="step-2">
                <div class="col-xs-12">
                    <div class="col-md-12">
                        <h3> Step 2</h3>
                        <div class="form-group">
                            <label class="control-label">User Name<span class="red">*</span></label>
                            <input name="username" maxlength="32" type="text" required="required" class="form-control"
                                   placeholder="Enter desired username (required)"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Email Address<span class="red">*</span></label>
                            <input name="email" maxlength="200" type="text" required="required" class="form-control"
                                   placeholder="Enter your email address (required)"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Phone Number</label>
                            <input name="phone_number" maxlength="11" type="text" class="form-control"
                                   placeholder="Enter your phone number (not required)"/>
                        </div>
                        <a href="Index.php" class="btn btn-danger cancelBtn btn-lg" role="button">Cancel</a>
                        <button class="btn btn-primary nextBtn btn-lg pull-right" type="button">Next</button>
                    </div>
                </div>
            </div>
            <div class="row setup-content" id="step-3">
                <div class="col-xs-12">
                    <div class="col-md-12">
                        <h3> Step 3</h3>
                        <div class="form-group">
                            <label class="control-label">Password<span class="red">*</span></label>
                            <input name="password" id="password1" maxlength="32" type="password" required="required"
                                   class="form-control" placeholder="Enter password (required)" autocomplete="off"/>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <span id="8char" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> 8
                                Characters Long<br>
                                <span id="ucase" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> One
                                Uppercase Letter
                            </div>
                            <div class="col-sm-6">
                                <span id="lcase" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> One
                                Lowercase Letter<br>
                                <span id="num" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> One
                                Number
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <label class="control-label">Repeat Password<span class="red">*</span></label>
                            <input name="rpassword" id="password2" maxlength="32" type="password" required="required"
                                   class="form-control" placeholder="Repeat password (required)" autocomplete="off"/>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <span id="pwmatch" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span>
                                Passwords Match
                            </div>
                        </div>
                        <br>
                        <a href="Index.php" class="btn btn-danger cancelBtn btn-lg" role="button">Cancel</a>
                        <button class="btn btn-success btn-lg pull-right" type="submit">Register Me!</button>
                    </div>
                </div>
            </div>
        </form>
        <br>
    </div>

<?php include 'includes/masterLayout/footer.php'; ?>