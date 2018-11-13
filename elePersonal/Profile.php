<?php include 'core/init.php';
//Call general function to protect page access
protect_page();
include 'includes/masterLayout/header.php';

//update profile image
if (isset($_FILES['profile_img']) === true) {
    global $session_user_id;
    //echo message if button is clicked with no image selected
    if (empty($_FILES['profile_img']['name']) === true) {
        echo "<script type='text/javascript'> alert('No file selected');</script>";
    } else {
        //valid file type
        $allowed = array('jpg', 'jpeg', 'gif', 'png');

        $file_name = $_FILES['profile_img']['name'];
        $file_extn = strtolower(end(explode('.', $file_name)));
        $file_temp_location = $_FILES['profile_img']['tmp_name'];

        if (in_array($file_extn, $allowed) === true) {
            update_profile_img($session_user_id, $file_temp_location, $file_extn);
            echo "<script type='text/javascript'> alert('okay'); </script>";
        } else {
            //incorect file type
            $errors = 'Only jpg, jpeg, gif, png';
            echo "<script type='text/javascript'> alert(" . json_encode($errors) . "); </script>";

        }

    }
}
?>

<!-- right side main content -->
<div class="wrapper">
    <div class="content-main">

        <!--Left side column for navigation bar -->
        <aside class="sidebar">

            <ul class="nav nav-sidebar nav-menu" role="tablist">
                <li class="active">
                    <a href="#profile" role="tab" data-toggle="tab">
                        <i class="fa fa-male"></i> View Profile
                    </a>
                </li>
                <li><a href="#change" role="tab" data-toggle="tab">
                        <i class="fa fa-key"></i> Edit Profile
                    </a>
                </li>
            </ul>

        </aside>


        <h1 class="page-header">Profile</h1>

        <div class="profile-head">
            <div class="col-md- col-sm-4 col-xs-12">
                <?php
                if (empty($user_data['profile_img']) === false) {
                    echo '<img src="', $user_data['profile_img'], '" alt="', $user_data['name'], '\'s Profile Image" class="img-responsive" />';
                } else {
                    echo '<img src="res/img/default-user.png" class="img-responsive" />';
                }
                ?>

                <h6><?php echo $user_data['username']; ?></h6>
            </div><!--col-md-4 col-sm-4 col-xs-12 close-->


            <div class="col-md-5 col-sm-5 col-xs-12">
                <h5><?php echo $user_data['name']; ?> <span><?php echo $user_data['surname']; ?></span></h5>
                <p>Account Details </p>
                <ul>
                    <li><span class="glyphicon glyphicon-user"></span>User ID:
                        <span><?php echo $session_user_id; ?></span></li>
                    <li><span class="glyphicon glyphicon-map-marker"></span><span><?php
                            if (empty($user_data['country']) === false) {
                                echo $user_data['country'];
                            } else {
                                echo 'No country saved';
                            }
                            ?></span></li>
                    <li><span class="glyphicon glyphicon-home"></span><span><?php
                            if (empty($user_data['home_address']) === false) {
                                echo $user_data['home_address'];
                            } else {
                                echo 'No address saved';
                            }
                            ?></span></li>
                    <li><span class="glyphicon glyphicon-phone"></span> <a href="#" title="call"><span><?php
                                if (empty($user_data['phone_number']) === false) {
                                    echo $user_data['phone_number'];
                                } else {
                                    echo 'No number saved';
                                }
                                ?></span></a></li>
                    <li><span class="glyphicon glyphicon-envelope"></span><a href="#"
                                                                             title="mail"><span><?php echo $user_data['email']; ?></span></a>
                    </li>

                </ul>

            </div><!--col-md-8 col-sm-8 col-xs-12 close-->
        </div><!--profile-head close-->

        <br>
        <br>

        <!-- Tab panes -->
        <div class="tab-content">
            <!-- first panes -->
            <div class="tab-pane active in" id="profile">
                <div class="container">
                    <br clear="all"/>
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="pro-title">Bio Graph</h4>
                        </div><!--col-md-12 close-->


                        <div class="col-md-6">

                            <div class="table-responsive responsiv-table">
                                <table class="table bio-table">
                                    <tbody>
                                    <tr>
                                        <td>Firstname</td>
                                        <td>: </td>
                                    </tr>
                                    <tr>
                                        <td>Lastname</td>
                                        <td>: </td>
                                    </tr>
                                    <tr>
                                        <td>Birthday</td>
                                        <td>: </td>
                                    </tr>
                                    <tr>
                                        <td>Contury</td>
                                        <td>: </td>
                                    </tr>
                                    <tr>
                                        <td>Occupation</td>
                                        <td>: </td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div><!--table-responsive close-->
                        </div><!--col-md-6 close-->

                        <div class="col-md-6">

                            <div class="table-responsive responsiv-table">
                                <table class="table bio-table">
                                    <tbody>
                                    <tr>
                                        <td>Email Addres</td>
                                        <td>: </td>
                                    </tr>
                                    <tr>
                                        <td>Mobile</td>
                                        <td>: </td>
                                    </tr>
                                    <tr>
                                        <td>Phone</td>
                                        <td>: </td>
                                    </tr>
                                    <tr>
                                        <td>Experience</td>
                                        <td>: </td>
                                    </tr>
                                    <tr>
                                        <td>Signed up</td>
                                        <td>:</td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div><!--table-responsive close-->
                        </div><!--col-md-6 close-->

                    </div><!--row close-->


                </div><!--container close-->
            </div><!--first tab-pane close-->


            <div class="tab-pane" id="change">
                <div class="container fom-main">
                    <div class="row">
                        <div>
                            <h2>Edit profile details</h2>
                        </div><!--col-sm-12 close-->
                    </div><!--row close-->
                    <br/>

                    <div class="row">
                        <form class="form-horizontal main_form text-left" action="core/functions/updateProc.php"
                              method="post" id="contact_form">
                            <fieldset>

                                <div class="form-group col-md-12">
                                    <label class="col-md-10">First Name</label>
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <input name="name" value="<?php echo $user_data['name']; ?>"
                                                   class="form-control"
                                                   type="text"/>
                                        </div>
                                    </div>
                                </div>

                                <!-- Text input-->

                                <div class="form-group col-md-12">
                                    <label class="col-md-10">Last Name</label>
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <input name="surname" value="<?php echo $user_data['surname']; ?>"
                                                   class="form-control"
                                                   type="text"/>
                                        </div>
                                    </div>
                                </div>

                                <!-- Text input-->
                                <div class="form-group col-md-12">
                                    <label class="col-md-10">E-Mail</label>
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <input name="email" value="<?php echo $user_data['email']; ?>"
                                                   class="form-control"
                                                   type="text"/>
                                        </div>
                                    </div>
                                </div>

                                <!-- Text input-->
                                <div class="form-group col-md-12">
                                    <label class="col-md-10">Home Address</label>
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <input name="home_address" value="<?php echo $user_data['home_address']; ?>"
                                                   class="form-control"
                                                   type="text"/>
                                        </div>
                                    </div>
                                </div>

                                <!-- Text input-->
                                <div class="form-group col-md-12">
                                    <label class="col-md-10">Home Country</label>
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <input name="country" value="<?php echo $user_data['country']; ?>"
                                                   class="form-control"
                                                   type="text"/>
                                        </div>
                                    </div>
                                </div>


                                <!-- Text input-->

                                <div class="form-group col-md-12">
                                    <label class="col-md-10">Phone number</label>
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <input name="phone_number" value="<?php echo $user_data['phone_number']; ?>"
                                                   class="form-control"
                                                   type="text"/>
                                        </div>
                                    </div>
                                </div>

                                <!-- Button -->
                                <div class="form-group col-md-10">
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-primary btn-load btn-lg">Save</button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                        <form class="form-horizontal main_form text-left" action="" method="post"
                              enctype="multipart/form-data" id="contact_form">
                            <!-- upload profile picture -->

                            <div class="col-md-12 text-left">
                                <div class="uplod-picture">
                                <span class="btn btn-default uplod-file">
                                    Upload Photo <input type="file" name="profile_img"/>
                                </span>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div> <!--col-md-12 close-->
                        </form>
                    </div><!--row close-->
                </div><!--container close -->
            </div><!--tab-pane close-->
        </div><!--tab-content close-->

    </div>
</div>

<?php include 'includes/masterLayout/footer.php'; ?>
