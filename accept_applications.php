<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles/index/index1.css">
    <title>Accept Applications</title>
</head>
<body>

<div class="row"> 
    <?php

    $con = mysqli_connect("localhost", "root", "", "Applications");

    if (!$con) {
        die("Unable to connect to Database.");
    }

    $today = new DateTime();
    $endDate = new DateTime(get_cookie('endDate'));

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if ($today > $endDate) { 
            $query = "SELECT * FROM applications WHERE AcceptApplication = 1 ORDER BY Average DESC";
            $result = mysqli_query($con, $query);
            
            $result_file = fopen("results.html", "w");
            if (!$result_file) die("Cannot create results.html");

        $html = '<!DOCTYPE html>
        <html>
        <head>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" type="text/css" href="styles/index/index1.css">
            <title>Results</title>
            
        </head>
        <body>
            <center><u><h2>Successful Applicants</h2></u></center>
            <table bgcolor="grey" border="1">
                <tr bgcolor="yellow">
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
                </tr>';

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $html .= "<tr bgcolor=lightyellow>
                        <td>".htmlspecialchars($row['id'])."</td>
                        <td>".htmlspecialchars($row['Name'])."</td>
                        <td>".htmlspecialchars($row['LastName'])."</td>
                        <td>".htmlspecialchars($row['AM'])."</td>
                        <td>".htmlspecialchars($row['Percent'])."</td>
                        <td>".htmlspecialchars($row['Average'])."</td>
                        <td>".htmlspecialchars($row['EnglishCert'])."</td>
                        <td>".htmlspecialchars($row['ForeignLanguage'])."</td>
                        <td>".htmlspecialchars($row['Uni1'])."</td>
                        <td>".htmlspecialchars($row['Uni2'])."</td>
                        <td>".htmlspecialchars($row['Uni3'])."</td>
                        <td>";
                            if($row['DegreeFile']) $html .= "<a href='".$row['DegreeFile']."' target='_blank'>View</a>";
                            $html .= "</td>
                        <td>";
                            if($row['EnglishFile']) $html .= "<a href='".$row['EnglishFile']."' target='_blank'>View</a>";
                            $html .= "</td>
                        <td>";
                            if($row['OtherLanguagesFile']) $html .= "<a href='".$row['OtherLanguagesFile']."' target='_blank'>View</a>";
                            $html .= "</td>
                    </tr>";
                }
            }

            $html .= '</table></body></html>';

            fwrite($result_file, $html);
            fclose($result_file);

            echo "<center><b>Results announced!</b> <a href='results.html'>View Results</a></center><br><br>";
        } else {
            echo "<center><b>The application period is not over yet!</b></center><br><br>";
        }
    }

    $query = "SELECT * FROM applications WHERE AcceptApplication = 1 ORDER BY Average DESC";
    $result = mysqli_query($con, $query);

    echo "<center>";
    echo "<u><b>Applications</b></u>";
    echo "<form method='post'>"; 
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
            <th>AcceptApplication</th>
        </tr>";

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
        echo "<br><button type='submit'>Announce Results</button>"; 
        echo "</form>";
        echo "</center>";
    }

    $con->close();

    function get_cookie($name) {
        return isset($_COOKIE[$name]) ? $_COOKIE[$name] : null;
    }
    ?>
</div>

</body>
</html>
