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
            <ul id="menu"></ul>
        </ul>
	</div>	 
    <div class="col-s-12 col-m-9 col-l-9">  
    <?php

        $con = mysqli_connect("localhost", "root", "", "Users");

        if ($con) {
                $query = "SELECT * FROM users WHERE Type = 'Admin'";
                $result = mysqli_query($con, $query);
                
                echo "<center>";
                echo "<u><b>Admins</b></u>";
                echo "<table border='1'>";
                echo "<tr><th>Name</th><th>LastName</th><th>Email</th></tr>";

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                            <td>{$row['Name']}</td>
                            <td>{$row['LastName']}</td>
                            <td>{$row['Email']}</td>
                        </tr>";
                    }
                    echo "</table>";
                    echo "</center>";
                } 
        } 
        else {
                echo "Unable to connect to Database.";
            }

        $con->close();
    ?>
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
        <li><a href="new_admin.html">ADD NEW ADMIN</a></li>	
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