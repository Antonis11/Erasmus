<?php
session_start();

$username = $_SESSION['username'];

$con = mysqli_connect("localhost", "root", "", "Users");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$stmt = $con->prepare("SELECT Name, LastName, AM, Phone, Email, Usr, Psw, Type FROM users WHERE Usr = ?");
$stmt->bind_param("s", $username); // 's' for string
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
}

mysqli_close($con);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles/index/index1.css">
    <title>Profile</title>
</head>
<body>
<div class="row">
    <div class="col-s-12 col-m-3 col-l-3 menu">
        <ul>
            <?php 
                $Type = $user['Type']; 
                if($Type == 'Admin') { 
                    echo '<li><a href="admin_menu.html">INDEX</a></li>';
                    echo '<li><a href="logout.php">LOGOUT</a></li>';
                } 
                else if($Type == 'User') { 
                    echo '<li><a href="index.html">INDEX</a></li>';
                    echo '<li><a href="logout.php">LOGOUT</a></li>';
                }   
            ?>
        </ul>
    </div>
    <div class="col-s-12 col-m-9 col-l-9" align="center">
        <form action="update.php" method="POST">
            <u><h1>Profile Information</h1></u> <br><br>
            Username: <br>
            <input type="text" name="username" value=<?php echo htmlspecialchars($user['Usr']); ?> readonly> <br>
            Name: <br>
            <input type="text" name="fname" value=<?php echo htmlspecialchars($user['Name']); ?> > <br>
            Epitheto: <br> 
            <input type="text" name="lname" value=<?php echo htmlspecialchars($user['LastName']); ?>> <br>
            Arithmos Mitroou: <br>
            <input type="number" name="am" value=<?php echo htmlspecialchars($user['AM']); ?>> <br> 
            Phone Number: <br>
            <input type="number" name="phone" value=<?php echo htmlspecialchars($user['Phone']); ?>> <br> 
            E-mail: <br>
            <input pattern="[a-z0-9._%+-]+@[a-z0-9._]+\.[a-z]{2-63}$" type="email" name="email" value= <?php echo htmlspecialchars($user['Email']); ?>> <br> 
            Password: <br> 
            <input type="text" name="password" value=<?php echo htmlspecialchars($user['Psw']); ?>> <br><br>
            <input type="submit" value="Save Changes"> <br>
        </form>
    </div>
</div>

</body>
</html>

