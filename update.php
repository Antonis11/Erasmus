<?php
session_start();
$errors = [];
$success = "";

$username = $_POST['username'];
$fname    = $_POST['fname'];
$lname    = $_POST['lname'];
$am       = $_POST['am'];
$phone    = $_POST['phone'];
$email    = $_POST['email'];
$password = $_POST['password'];

$con = mysqli_connect("localhost", "root", "", "Users");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

if(!ctype_alpha($fname)) {
    $errors[] = "The first name must contain only characters.";
}
if(!ctype_alpha($lname)) {
    $errors[] = "The last name must contain only characters.";
}
if(strlen($am) != 13) {
    $errors[] = "Arithmos Mitroou must consist of 13 digits";
}
else if( (substr($am, 0, 4) != '2022') && (substr($am, 0, 4) != '2024') && (substr($am, 0, 4) != '2025') ) {
    $errors[] = "The first 4 digits of Arithmos Mitroou must be either 2022 or 2024 or 2025";
}
if(strlen($phone) != 10) {
    $errors[] = "Phone Number must consist of 10 digits";
}
if(strlen($password) < 5) {
    $errors[] = "The password must be at least 5 characters long";
}  
if(!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
    $errors[] = "The password must consist of at least one symbol character";
}
if(empty($errors)) {
    $stmt = $con->prepare("UPDATE users SET Name=?, LastName=?, AM=?, Phone=?, Email=?, Psw=? WHERE Usr=?");
    $stmt->bind_param("ssissss", $fname, $lname, $am, $phone, $email, $password, $username); // 's' for string, 'i' for integer

    if ($stmt->execute()) {
        $success = "User updated successfully!";
    } else {
        $errors[] = "Error: " . $stmt->error;
    }

    $stmt->close();
}

$con->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="styles/index/index1.css">
</head>
<body>
    
<div class="row">
	<div class="col-s-12 col-m-3 col-l-3 menu">
        <ul>
            <li><a href="index.html">INDEX</a></li>	
            <li><a href="logout.php">LOGOUT</a></li>
        </ul>
	</div>	 
	<div class="col-s-12 col-m-9 col-l-9" align="center">
        
    <?php if (!empty($errors)): ?>
        <div style="color:red;">
                <?php foreach ($errors as $error): ?>
                    <?php echo htmlspecialchars($error); ?> <br>
                <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div style="color:green;">
            <?php echo $success; ?>
        </div>
    <?php endif; ?>

	<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
		<u><h1>Profile Information</h1></u> <br><br>
            Username: <br>
			<input type="text" name="username" value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>"> <br>
			Name: <br>
			<input type="text" name="fname" value="<?php echo isset($fname) ? htmlspecialchars($fname) : ''; ?>"> <br>
			Epitheto: <br> 
			<input type="text" name="lname" value="<?php echo isset($lname) ? htmlspecialchars($lname) : ''; ?>"> <br>
			Arithmos Mitroou: <br>
			<input type="number" name="am" value="<?php echo isset($am) ? htmlspecialchars($am) : ''; ?>"> <br> 
			Phone Number: <br>
			<input type="number" name="phone" value="<?php echo isset($phone) ? htmlspecialchars($phone) : ''; ?>"> <br> 
			E-mail: <br>
			<input type="email" name="email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>"> <br> 
			Password: <br> 
			<input type="password" name="password"> <br><br>
            <input type="submit" value="Save Changes"> <br>
	</form>
	</div>
</div>  

</body>
</html>
