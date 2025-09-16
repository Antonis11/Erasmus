<?php
session_start();

$_SESSION = array();
session_destroy();

if (isset($_COOKIE['username'])) {
    setcookie("username", "", time() - 3600, "/");

    setcookie("fname", "", time() - 3600, "/");
    setcookie("lname", "", time() - 3600, "/");
    setcookie("am", "", time() - 3600, "/");
}

header("Location: index.html");
exit();
?>
