<?php include 'core/init.php';
include 'includes/masterLayout/header.php'; ?>

<?php
if (isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])) {
    // Verify data
    $email = sanitize($_GET['email']);
    $hash = sanitize($_GET['hash']);

    $query = "SELECT email, hash, active FROM users WHERE email='" . $_GET['email'] . "' AND hash='" . $_GET['hash'] . "' AND activated='0'";
    $search = mysqli_query($GLOBALS['conn'], $query) or die ('connection failed: ' . mysqli_connect_error());;
    $match = mysqli_num_rows($search);

    echo $match;
} else {
    // Invalid approach
}


?>

<?php include 'includes/masterLayout/footer.php'; ?>