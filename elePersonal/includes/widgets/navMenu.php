<ul class="nav navbar-nav">
    <li class="nav-item"><a href="Index.php">Home</a></li>
    <li class="nav-item"><a href="Documentation.php">Documentation</a></li>
    <li class="nav-item"><a href="Help.php">Help</a></li>
    <li class="nav-item"><a href="Contact.php">Contact</a></li>
</ul>
<ul class="nav navbar-nav navbar-right">
    <!--
    <li class="nav-item"><a href="#">Register</a></li>
    <li class="nav-item"><a href="#">Log in</a></li>
    -->

    <?php
    if (logged_in() === true) {
        include('includes/widgets/logout.php');
    } else {
        include('includes/widgets/login.php');
    }

    ?>
</ul>