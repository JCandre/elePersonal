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
            $mode_allowed = array('username', 'password');

            if (isset($_GET['mode']) === true && in_array($_GET['mode'], $mode_allowed) === true) {
                if (isset($_POST['email']) === true && empty($_POST['email']) === false) {
                    if (email_exists($_POST['email']) === true) {
                        recover($_GET['mode'], $_POST['email']);
                        echo "<script type='text/javascript'> alert('Email sent for recovery'); window.location ='Index.php'; </script>";
                        exit();
                    } else {
                        echo '<p>Unfortunately that email could not be found</p>';
                    }
                }
                ?>
                <div class="row">
                    <div class="col-sm-6 col-sm-offset-3">
                        <p class="text-center">Use the form below to recover your details.</p>
                        <form action="" method="post">
                            <ul>
                                <li>
                                    Please enter your email address:<br>
                                    <input type="text" name="email">
                                </li>
                                <li><input type="submit" value="Recover"></li>
                            </ul>
                        </form>

                    </div><!--/col-sm-6-->
                </div><!--/row-->
            <?php
            } else {
            ?>
                <script>window.location.replace("Index.php");</script>
                <?php
            }

            ?>
        </div>
    </div>
</div>

<?php include 'includes/masterLayout/footer.php'; ?>
