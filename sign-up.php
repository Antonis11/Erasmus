<?php
session_start();
$con = mysqli_connect("localhost","root","","Users"); 
$errors = [];
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $am = $_POST['am'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];
    
    $query = "SELECT * FROM users WHERE Usr = '$username' "; 
    $result = mysqli_query($con, $query);

    if(!ctype_alpha($fname)) {
        $errors[] = "The first name must contain only characters.";
    }
    if(!ctype_alpha($lname)) {
        $errors[] = "The last name must contain only characters.";
    }
    if(strlen($am) != 13) {
        $errors[] = "Arithmos Mitroou must consist of 13 digits";
    }
    elseif( (substr($am, 0, 4) != '2022') && (substr($am, 0, 4) != '2024') && (substr($am, 0, 4) != '2025') ) {
        $errors[] = "The first 4 digits of Arithmos Mitroou must be either 2022 or 2024 or 2025";
    }
    if(strlen($phone) != 10) {
        $errors[] = "Phone Number must consist of 10 digits";
    }
    if(mysqli_num_rows($result) > 0) {
        $errors[] = "There is a User with the same Username";
    }
    if(strlen($password) < 5) {
        $errors[] = "The password must be at least 5 characters long";
    }  
    if(!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
        $errors[] = "The password must consist of at least one symbol character";
    }
    if($password != $confirm_password) {
        $errors[] = "The confirmation password does not match";
    }

    if(empty($errors)) {
        if($am == '2022999999999'){
            $Type = 'Admin';
        }
        else{
            $Type = 'User';
        }
        mysqli_query($con, "INSERT INTO users (Name,LastName,AM,Phone,Email,Usr,Psw,Type) 
                            VALUES('$fname','$lname','$am','$phone','$email','$username','$password','$Type')");
        $_SESSION['username'] = $username;

        setcookie("username", $username,  time()+ 60*60);
        
        setcookie("fname", $fname, time()+ 60*60);
        setcookie("lname", $lname, time()+ 60*60);
        setcookie("am", $am, time()+ 60*60);

        $success = "You have successfully registered!";

        $fname = $lname = $am = $phone = $email = $username = "";

        if($Type == 'Admin'){
            header("Location: admin_menu.html");
            exit();
        }
    }
}

mysqli_close($con);
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
        <ul id="menu"></ul>
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
		<u><h1>Registration form: </h1></u> <br><br>
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
			Username: <br>
			<input type="text" name="username" value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>"> <br>
            Password: <br> 
			<input type="password" name="password"> <br>
			Confirm-Password: <br>
			<input type="password" name="confirm-password"> <br> <br>
			<input type="submit" value="Submit"> <br>
	</form>
	</div>
</div>  

<script>
    function getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(';').shift();
    }

    const menu = document.getElementById("menu");

    const username = getCookie("username");

    let html = `
        <li><a href="index.html">INDEX</a></li>
        <li><a href="more.html">MORE</a></li>
        <li><a href="reqs.html">REQS</a></li>
        <li><a href="application.html">APPLICATION</a></li>
    `;

    if (username) {
        html += `
        <li class="profile"><a href="changes.php">👤 ${username}</a></li>
    `;
    } 
    else {
        html += `
        <li><a href="sign-up.php">SIGN-UP</a></li>
        <li><a href="login.php">LOGIN</a></li>
    `;
    }

    menu.innerHTML = html;
</script>

</body>
</html>

