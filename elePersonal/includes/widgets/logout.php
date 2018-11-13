<li><p class="navbar-text">Welcome!</p></li>
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <b>
            <?php echo $user_data['name'] ?>
        </b> <span class="caret"></span>
    </a>
    <ul class="dropdown-menu">
        <li><a href="Profile.php">Profile</a></li>
        <li><a href="changePassword.php">Change password</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="includes/logoutRedirect.php">Log off</a></li>
    </ul>
</li>

<li class="nav-item"><a href="Dashboard.php">Dashboard</a></li>