<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8">
    <title>DevProx Proficiency Test 1</title>
    <meta name="description" content="Create an HTML form with the following input fields to allow for the capturing of
        data into a database:
        Name, Surname, Id No, Date of Birth, POST button, CANCEL button
        Create a database with a relevant schema to store the input fields in. ">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
</head>

<body>

    <?php

    //Database Variables:
    
    $serverName = "localhost";
    $username = "root";
    $password = "";
    $dbName = "devproxtest1";
    // define variables and set to empty values
    $nameErr = $surnameErr = $idNumberErr = $dateOfBirthErr = $databaseErr = "";
    $name = $surname = $idNumber = $dateOfBirth = "";
    $isError=FALSE;
    //cancel button resets form to blank
    if (array_key_exists("cancel", $_POST)) {
        $nameErr = $surnameErr = $idNumberErr = $dateOfBirthErr = $databaseErr = "";
        $name = $surname = $idNumber = $dateOfBirth = "";
    }
    if (array_key_exists("post", $_POST)) {
        post();
    }
    function post()
    {
        global $nameErr, $surnameErr, $idNumberErr, $dateOfBirthErr,
        $name, $surname, $idNumber, $dateOfBirth, $databaseErr, $isError;
        
        $name = $_POST["name"];
        list($isError, $nameErr) = textValidate($name);
        $surname = $_POST["surname"];
        list($isError, $surnameErr) = textValidate($surname);
        $idNumber = $_POST["idNumber"];
        list($isError, $idNumberErr) = idNumberValidate($idNumber);
        $dateOfBirth = $_POST["dateOfBirth"];
        list($isError, $dateOfBirthErr) = dateOfBirthErrValidate($dateOfBirth, $idNumber);
        if(!$isError)insertData();
         
        
    }
    function textValidate($name)
    {
        global $isError;
        if (strlen($name) > 50)
            return array(TRUE, "Please use less than 50 characters.");
        return array(FALSE||$isError, "");
    }
    function idNumberValidate($idNumber)
    {
        global $isError;
        //ID No. must be 13 digits long
        if (strlen($idNumber) !== 13)
            return array(TRUE, "ID No. requires 13 digits");
        //ID No. citizenship digit must be 0 or 1
        if (str_split($idNumber)[10] !== "0" && str_split($idNumber)[10] !== "1")
            return array(TRUE, "ID No. is invalid due to out of bounds citizenship digit");
        //Luhn algorithm Check
        if (luhnAlgorithmCheck($idNumber))
            return array(TRUE, "ID No. is invalid due to Luhn Algorithm Check");
        if (duplicateIDCheck($idNumber))
            return array(TRUE, "Duplicate ID No. found in Database");
        return array(FALSE||$isError, "");
    }
    function dateOfBirthErrValidate($dateOfBirth, $idNumber)
    {
        global $isError;
        //split date of birth into year month day array
        $dateOfBirthArray = explode('-', $dateOfBirth);
        //split ID number into array of 2 digits each
        $idArray = str_split($idNumber, 2);
        //if id does not match DOB return true
        if (substr($dateOfBirthArray[0], 2) != $idArray[0] || $dateOfBirthArray[1] != $idArray[1] || $dateOfBirthArray[2] != $idArray[2])
            return array(TRUE, "Date of birth and ID No. does not match.");
        //check passed return false
        return array(FALSE||$isError, "");
    }
    function insertData()
    {
        //declare the use of global variables
        global $serverName, $username, $password, $dbName, $idNumber, $name, $surname, $dateOfBirth;
        //create mysqli object and connect to database
        $conn = new mysqli($serverName, $username, $password, $dbName) or die("Connect failed: %s\n" . $conn->error);
        // create sql statement
        $sql = "INSERT INTO `userdetails`(`IDNumber`, `FirstName`, `Surname`, `DateOfBirth`) VALUES ('$idNumber','$name','$surname','$dateOfBirth')";
        //if query fails close database connection and return true 
        if ($conn->query($sql) === FALSE) {
            $conn->close();
            return TRUE;
        }
        //query is successful. close database and return  
        $conn->close();
        return FALSE;

    }
    function luhnAlgorithmCheck($idNumber)
    {
        //split digits in number
        $idArray = str_split($idNumber);
        $luhnSum = 0;
        for ($i = 0; $i < 13; $i++) {
            //sum every second number
            if ($i % 2 === 0)
                $luhnSum += $idArray[$i];
            // sum the sum of the every second number doubled
            else
                $luhnSum += (array_sum(str_split(2 * $idArray[$i])));
        }
        //return false if sum is multiple of 10
        if ($luhnSum % 10 !== 0)
            return TRUE;
        return FALSE;
    }
    function duplicateIDCheck($idNumber)
    {
        //declare the use of global variables
        global $serverName, $username, $password, $dbName;
        //create mysqli object and connect to database
        $conn = new mysqli($serverName, $username, $password, $dbName) or die("Connect failed: %s\n" . $conn->error);
        // create sql statement
        $sql = "SELECT `IDNumber` FROM `userdetails`";
        //querry sql statement on database
        $idList = $conn->query($sql);
        // check number of entries in database table. if zero close connection and return
        if ($idList->num_rows < 1) {
            $conn->close();
            return FALSE;
        }
        // check if id number entered in form is in database table. if true close connection return true
        while ($id = $idList->fetch_assoc()) {
            if ($id["IDNumber"] === $idNumber) {
                $conn->close();
                return TRUE;
            }
        }
        //no matches were found. close database and return
        $conn->close();
        return FALSE;
    }
    ?>

    <h2>DevProx Test 1</h2>
    <p>Create an HTML form with the following input fields to allow for the capturing of
        data into a database:<br />
        Name, Surname, Id No, Date of Birth, POST button, CANCEL button
        Create a database with a relevant schema to store the input fields in.</p>
    <form method="post">
        Name: <input type="text" name="name" value="<?php echo $name; ?>" required
            onkeydown="return /[a-z, ]/i.test(event.key)" onblur="if (this.value == '') {this.value = '';}"
            onfocus="if (this.value == '') {this.value = '';}">
        <span class="error">
            <?php echo $nameErr; ?>
        </span>
        <br><br>
        Surname: <input type="text" name="surname" value="<?php echo $surname; ?>" required
            onkeydown="return /[a-z, ]/i.test(event.key)" onblur="if (this.value == '') {this.value = '';}"
            onfocus="if (this.value == '') {this.value = '';}">
        <span class="error">
            <?php echo $surnameErr; ?>
        </span>
        <br><br>
        ID No.: <input type="number" name="idNumber" value="<?php echo $idNumber; ?>" required>
        <span class="error">
            <?php echo $idNumberErr; ?>
        </span>
        <br><br>
        Date of Birth: <input type="date" name="dateOfBirth" max="9999-12-31" value="<?php echo $dateOfBirth; ?>"
            required>
        <span class="error">
            <?php echo $dateOfBirthErr; ?>
        </span>
        <br><br>
        <input type="submit" name="post" value="POST">
        <input type="submit" name="cancel" value="CANCEL">
        
    </form>
</body>

</html>