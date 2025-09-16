<?php
session_start();
$con = mysqli_connect("localhost","root","","Applications"); 

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $am = $_POST['am'];
    $percent = $_POST['percent'];
    $avgGrade = $_POST['avg'];
    $englishCert = $_POST['english_cert'];
    $foreignLanguage = $_POST['foreign_language'];
    $uni1 = $_POST['University_of_Peloponnese'] ?? '';
    $uni2 = $_POST['University_of_Piraeus'] ?? '';
    $uni3 = $_POST['University_Abroad'] ?? '';
    
    function uploadFile($fileInputName, $uploadDir) {
        if (!isset($_FILES[$fileInputName]) || $_FILES[$fileInputName]['error'] != 0) {
            return null;
        }
        
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $filename = time() . "_" . basename($_FILES[$fileInputName]['name']);
        $targetFile = $uploadDir . "/" . $filename;

        if (move_uploaded_file($_FILES[$fileInputName]['tmp_name'], $targetFile)) {
            return $targetFile;
        } else {
            return null;
        }
    }
    
    $degreeFile        = uploadFile("degree_file", "uploads/degrees");
    $englishFile       = uploadFile("english_file", "uploads/english");
    $otherLanguagesFile= uploadFile("other_files", "uploads/other_langs");

    mysqli_query($con, "INSERT INTO applications (Name, LastName, AM, Percent, Average, EnglishCert, ForeignLanguage, Uni1, Uni2, Uni3, DegreeFile, EnglishFile, OtherLanguagesFile)
                        VALUES('$fname','$lname','$am', '$percent', '$avgGrade', '$englishCert', '$foreignLanguage','$uni1','$uni2','$uni3', '$degreeFile', '$englishFile', '$otherLanguagesFile')");

    echo "<script>
            alert('Application submitted successfully!');
            window.location.href='index.html';
        </script>";
    exit();
}
mysqli_close($con);
?>



