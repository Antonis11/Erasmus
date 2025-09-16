<?php
session_start();
$con = mysqli_connect("localhost","root","","Universities"); 
$errors = [];
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $city = $_POST['city'];
    $country = $_POST['country'];

    if(!ctype_alpha($name)) {
        $errors[] = "The Name of the University must contain only characters.";
    }
    if(!ctype_alpha($city)) {
        $errors[] = "The City must contain only characters.";
    }
    if(!ctype_alpha($country)) {
        $errors[] = "The Country must contain only characters.";
    }

    if(empty($errors)) {
        mysqli_query($con, "INSERT INTO universities (university_id,university_name,city,country) 
                    VALUES('$id','$name','$city','$country')");

        $success = "New University added successfully!";

        header("Location: universities.php");
        exit();
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
		<u><h1>New University: </h1></u> <br><br>
			ID: <br>
			<input type="number" name="id" value="<?php echo isset($id) ? htmlspecialchars($id) : ''; ?>"> <br>
			Name: <br> 
			<input type="text" name="name" value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>"> <br>
			City: <br>
			<input type="text" name="city" value="<?php echo isset($city) ? htmlspecialchars($city) : ''; ?>"> <br> 
			Country: <br>
			<input type="text" name="country" value="<?php echo isset($country) ? htmlspecialchars($country) : ''; ?>"> <br><br> 
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

    let html = ``;
    
    html += `
        <li class="profile"><a href="changes.php">👤 ${username}</a></li>
    `;

    menu.innerHTML = html;
</script>

</body>
</html>

