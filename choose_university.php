<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="styles/index/index1.css">
</head>
<body>
    
<div class="row">
    <?php

    $con = mysqli_connect("localhost", "root", "", "Applications");
    
    $choose_university = $_POST['Choose_University'];

    $query = "SELECT * FROM applications WHERE uni1='$choose_university' OR uni2='$choose_university' OR uni3='$choose_university' ORDER BY Average DESC";
    $result = mysqli_query($con, $query); 
                
    echo "<center>";
    echo "<u><b>Applications</b></u>";
    echo "<form method='post' action='update_accept.php'>"; 
    echo "<table border='1'>";
    echo "<tr>
            <th>Id</th>
            <th>Name</th>
            <th>LastName</th>
            <th>AM</th>
            <th>Percent</th>
            <th>Average</th>
            <th>EnglishCert</th>
            <th>ForeignLanguage</th>
            <th>Uni1</th>
            <th>Uni2</th>
            <th>Uni3</th>
            <th>DegreeFile</th>
            <th>EnglishFile</th>
            <th>OtherLanguagesFile</th>
            <th>AcceptApplication</th></tr>";

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";      
                        echo "<td>".htmlspecialchars($row['id'])."</td>";          
                        echo "<td>".htmlspecialchars($row['Name'])."</td>";
                        echo "<td>".htmlspecialchars($row['LastName'])."</td>";
                        echo "<td>".htmlspecialchars($row['AM'])."</td>";
                        echo "<td>".htmlspecialchars($row['Percent'])."</td>";
                        echo "<td>".htmlspecialchars($row['Average'])."</td>";
                        echo "<td>".htmlspecialchars($row['EnglishCert'])."</td>";
                        echo "<td>".htmlspecialchars($row['ForeignLanguage'])."</td>";
                        echo "<td>".htmlspecialchars($row['Uni1'])."</td>";
                        echo "<td>".htmlspecialchars($row['Uni2'])."</td>";
                        echo "<td>".htmlspecialchars($row['Uni3'])."</td>";
                        echo "<td>";
                            if($row['DegreeFile']) echo "<a href='".$row['DegreeFile']."' target='_blank'>View</a>";
                        echo "</td>";
                        echo "<td>";
                            if($row['EnglishFile']) echo "<a href='".$row['EnglishFile']."' target='_blank'>View</a>";
                        echo "</td>";
                        echo "<td>";
                            if($row['OtherLanguagesFile']) echo "<a href='".$row['OtherLanguagesFile']."' target='_blank'>View</a>";
                        echo "</td>";
                        echo "<td>";
                                echo "<input type='checkbox' name='accepted_applications[" . $row["id"] . "]' value='1' " . 
                                    ($row["AcceptApplication"] == 1 ? "checked" : "") . ">";
                        echo "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                echo "<br><button type='submit'>Accept Applications</button>"; 
                echo "</form>";
                echo "</center>";
            } 
    mysqli_close($con);
    ?>
</div>

</body>
</html>


