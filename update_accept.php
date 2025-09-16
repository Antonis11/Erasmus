<?php
$con = mysqli_connect("localhost", "root", "", "Applications");

if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}

$accepted = isset($_POST['accepted_applications']) ? $_POST['accepted_applications'] : [];

mysqli_query($con, "UPDATE applications SET AcceptApplication = 0");

foreach ($accepted as $id => $val) {
    $id = (int)$id; 
    mysqli_query($con, "UPDATE applications SET AcceptApplication = 1 WHERE id = $id");
}

mysqli_close($con);

header("Location: admin_menu.html");
exit;
?>
