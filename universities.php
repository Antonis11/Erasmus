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

        $con = mysqli_connect("localhost", "root", "", "Universities");

        if ($con) {
                $query = "SELECT * FROM universities";
                $result = mysqli_query($con, $query); 
                
                echo "<center>";
                echo "<u><b>Universities</b></u>";
                echo "<table border='1'>";
                echo "<tr><th>ID</th><th>Name</th><th>City</th><th>Country</th></tr>";

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                            <td>{$row['university_id']}</td>
                            <td>{$row['university_name']}</td>
                            <td>{$row['city']}</td>
                            <td>{$row['country']}</td>
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
        <li><a href="new_university.html">ADD NEW UNIVERSITY</a></li>	
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