<?php include 'core/init.php';
//Call general function to protect page access
protect_page();
include 'includes/masterLayout/header.php'; ?>

<div class="wrapper">
    <div class="content-main">
        <?php include 'includes/aside.php'; ?>


        <!--Main Content-->
        <div id="page-wrapper" class="dashbard-1">
            <div class="content-main">
                <button class="btn btn-primary btn-lg pull-right" type="button" name="add" id="add">Send</button>
                <h1 class="page-header">Mail
                    <small>Inbox</small>
                </h1>

                <br/>


            </div>
        </div>

    </div>
</div>


<?php include 'includes/masterLayout/footer.php'; ?>

<script>
    $(document).ready(function () {


    });
</script>
