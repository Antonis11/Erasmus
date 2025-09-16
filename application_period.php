<?php
$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $startDate = $_POST["startDate"];
    $endDate   = $_POST["endDate"];

    if ($startDate >= $endDate) {
        $error = "The start date must be earlier than the end date.";
    } else 
    {
        setcookie("startDate", $startDate, time() + (7 * 24 * 60 * 60), "/");
        setcookie("endDate", $endDate, time() + (7 * 24 * 60 * 60), "/"); 

        $success = "The application period has been saved!";
    }
}
?>

<!DOCTYPE html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="styles/index/index1.css">
</head>
<body>
    <div class="col-s-12 col-m-3 col-l-3 menu">
		<ul id="menu"></ul>
	</div>	 
    <div class="col-s-12 col-m-9 col-l-9" align="center"> 
    
    <?php if(isset($error)) echo "<p style='color:red'>$error</p>"; ?>
    <?php if(isset($success)) echo "<p style='color:green'>$success</p>"; ?>
    <?php if ($startDate && $endDate) echo "<p style='color:blue'>Current application period: from $startDate to $endDate</p>"; ?>
    
    <u><h1>Application Period: </h1></u> <br><br>
    <form method="POST" action="application_period.php">
        From: <input type="date" name="startDate" required><br><br>
        To: <input type="date" name="endDate" required><br><br>
        <button type="submit">Save</button>
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
		<li><a href="application_period.html">APPLICATION PERIOD</a></li>
        <li><a href="unis.php">UNIVERSITIES</a></li>
		<li><a href="admins.php">ADMINS</a></li>
	`;

	if (username) {
    html += `
		<li class="profile"><a href="changes.php">👤 ${username}</a></li>
		
    `;
	} 

	menu.innerHTML = html;
</script>

</body>
</html>

