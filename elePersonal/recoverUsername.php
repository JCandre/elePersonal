<?php
include 'core/init.php';
logged_in_redirect();
include 'includes/masterLayout/header.php';

?>

<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h1>Recover Username</h1>

            <?php
            if (isset($_GET['success']) && empty($_GET['success'])) {
                echo 'You have successfully changed passwords';
            } else {
                if (empty($_POST) === false && empty($errors) === true) {
                    //posted the form and no errors
                    change_password($session_user_id, $_POST['password1']);
                    header('Location: changePassword.php?success');
                } else if (empty($errors) === false) {
                    //output
                    echo outputErrors($errors);
                }
            }

            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            <p class="text-center">Use the form below to recover your username.</p>
            <form action="" method="post" id="recoverForm">
                <input type="password" required="required" class="input-lg form-control" name="current_password"
                       id="current_password" placeholder="Current Password" autocomplete="off">
                <br>
                <input type="password" required="required" class="input-lg form-control" name="password1" id="password1"
                       placeholder="New Password" autocomplete="off">
                <div class="row">
                    <div class="col-sm-6">
                        <span id="8char" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> 8 Characters
                        Long<br>
                        <span id="ucase" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> One Uppercase
                        Letter
                    </div>
                    <div class="col-sm-6">
                        <span id="lcase" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> One Lowercase
                        Letter<br>
                        <span id="num" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> One Number
                    </div>
                </div>
                <input type="password" required="required" class="input-lg form-control" name="password2" id="password2"
                       placeholder="Repeat Password" autocomplete="off">
                <div class="row">
                    <div class="col-sm-12">
                        <span id="pwmatch" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> Passwords
                        Match
                    </div>
                </div>
                <!--change button later -->
                <input type="submit" class="col-xs-12 btn btn-primary btn-load btn-lg"
                       data-loading-text="Changing Password..." value="Change Password">
            </form>
        </div><!--/col-sm-6-->
    </div><!--/row-->
</div>

<?php include 'includes/masterLayout/footer.php'; ?>
