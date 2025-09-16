<?php
header('Content-Type: application/json');

$con = mysqli_connect("localhost", "root", "", "universities");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$university_id = isset($_GET['university_id']) ? intval($_GET['university_id']) : 0;

if($university_id > 0){
    $stmt = $con->prepare("SELECT university_name, city, country FROM universities WHERE university_id = ?");
    $stmt->bind_param("i", $university_id); // i for integer
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $con->query("SELECT university_id, university_name, city, country FROM universities");
}

$universities = [];
while($row = $result->fetch_assoc()){
    $universities[] = $row;
}

echo json_encode($universities);

$con->close();
?>

