<?php
session_start();
$con = mysqli_connect("localhost","root","","Users");
$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE Usr = '$username' ";
    $usr = mysqli_query($con, $query);

    $query = "SELECT * FROM users WHERE Psw = '$password' ";
    $psw = mysqli_query($con, $query);

    if( (mysqli_num_rows($usr) <= 0) || (mysqli_num_rows($psw) <= 0) ) {
        $error = "Wrong Username or Password!";
    }
    else {
        $user_data = mysqli_fetch_assoc($usr);
        
        $_SESSION['username'] = $username;

        setcookie("username", $username, time()+ 60*60);

        setcookie("fname", $user_data['Name'], time()+ 60*60);
        setcookie("lname", $user_data['LastName'], time()+ 60*60);
        setcookie("am", $user_data['AM'], time()+ 60*60);

        if($user_data['AM'] == '2022999999999'){
            $Type = 'Admin';
        }
        else{
            $Type = 'User';
        }

        if($Type == 'Admin'){
            header("Location: admin_menu.html");
            exit();
        }
        else if($Type == 'User') {
            header("Location: index.html");
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

    <?php if ($error): ?>
        <div style="color:red;">
                <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div style="color:green;">
            <?php echo $success; ?>
        </div>
    <?php endif; ?>

	<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
		<u><h1>Login: </h1></u> <br> 
			Username: <br>
			<input type="text" name="username"> <br>
			Password: <br> 
			<input type="password" name="password"> <br><br>
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

