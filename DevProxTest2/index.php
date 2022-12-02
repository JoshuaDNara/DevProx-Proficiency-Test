<?php
session_start();
$serverName = "localhost";
$username = "root";
$password = "";
$dbName = "devproxtest1";
$uploadFilePath='D:/xampp/htdocs/DevProxProficiencyTest/DevProxTest2/uploads/uploaded.csv'
?>
<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8">
    <title>DevProx Proficiency Test 2</title>

</head>

<body>

    <h2>DevProx Test 1</h2>
    <p>This task is to test your skills in manipulating arrays and file handling.
        In this test you will be making a CSV file of variable length, a form will ask for the
        amount of data to generate. Check the requirements on how to generate the file.
        The file will have the following header fields:<br>
        Id, Name, Surname, Initials, Age, DateOfBirth<br>
        The data will look like this:<br>
        "1","Andre","van Zuydam", "A", "33","13/02/1979"<br>
        "2","Tyron James", "Hall", "TJ", "32", "03/06/1980";<br>
        After this you will import the file into a database and output a count of all the
        records imported. </p>
    <h2>Generate File</h2>
    <form method="get" action="devProxTest2.php">
        Amount of data to Generate: <input type="number" name="numOfVar" value="0" min="0">
        <input type="submit" name="submitNumOfVar" value="Submit No. of rows">
    </form>
    <br><br>
    <h2>Upload File</h2>
    <form method="POST" action="upload.php" enctype="multipart/form-data">
        <div>

            Browse: <input type="file" name="uploadedFile">
        </div>
        <br>
        <input type="submit" name="uploadBtn" value="Upload" />
    </form>
    <?php
    error_reporting(E_ERROR | E_PARSE);
    if (isset($_SESSION['message']) && $_SESSION['message']) {
        printf('<b>%s</b>', $_SESSION['message']);
        unset($_SESSION['message']);

    }
    if (isset($_SESSION['outputTable']) && $_SESSION['outputTable']) {
        unset($_SESSION['outputTable']);
       
        $conn = new mysqli($serverName, $username, $password, $dbName) or die("Connect failed: %s\n" . $conn->error);
        $sql = $sql = "CREATE TABLE `csv_import`(`Id` INT NOT NULL, `Name` VARCHAR(50) NOT NULL, `Surname` VARCHAR(50) NOT NULL, `Initial` VARCHAR(3) NOT NULL, `Age` INT NOT NULL, `DateOfBirth` VARCHAR(10) NOT NULL)";
        if ($conn->query($sql) === TRUE)
            echo "table csv_import created<br>";
        $sql = "ALTER TABLE `csv_import` DISABLE KEYS;";
        if ($conn->query($sql) === TRUE)
        echo "table csv_import DISABLE KEYS<br>";
        $sql = "LOAD DATA  INFILE '$uploadFilePath' 
        INTO TABLE 
        `csv_import` 
        CHARACTER SET UTF8 
        FIELDS TERMINATED BY ','  
        LINES TERMINATED BY '\n';";
        if ($conn->query($sql) === TRUE)
        echo "table csv_import data loaded<br>";
        $sql = "ALTER TABLE `csv_import` ENABLE KEYS;";
        if ($conn->query($sql) === TRUE)
        echo "table csv_import ENABLE KEYS<br>";
    }
    ?>
</body>

</html>