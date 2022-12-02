<?php
error_reporting(E_ERROR | E_PARSE);
//name array
$names = array(
    "Joshua",
    "Andre",
    "Desiree",
    "Joel",
    "Storm",
    "Christina",
    "William",
    "Marco",
    "Ethan",
    "Erin",
    "Jaco",
    "Frans",
    "Tian",
    "Le Roux",
    "Braam",
    "Brandon",
    "Trent",
    "Darron",
    "Tristan",
    "John"
);
//surname array
$surnames = array(
    "Du Plooy",
    "Du Tooit",
    "De Swaardt",
    "Smith",
    "Eachels",
    "Fischer",
    "Johnson",
    "Brazier",
    "Sykes",
    "Josef",
    "Wessels",
    "Errasmus",
    "Louw",
    "Tanjour",
    "Pilz",
    "Rogers",
    "Domingo",
    "Jones",
    "Cogil",
    "Sparrow"
);
function generateCSVfile($numOfVar)
{
    global $names, $surnames;
    

    $data = array();
    for ($i = 0; $i < $numOfVar; $i++) {

        array_push($data, generateRow());
    }
    $data = array_unique($data);
    $duplicates = false;
    if (count($data) < $numOfVar)
        $duplicates = true;
    while ($duplicates) {
        $test = false;
        for ($i = 0; $i < $numOfVar; $i++) {

            if ($data[$i] == "") {
                $data[$i] = generateRow();

                $test = true;
            }
        }
        $data = array_unique($data);
        if (!$test)
            $duplicates = false;
    }

    $outputFile = fopen("output/output.csv", "w") or die("Unable to open file!");
    fwrite($outputFile, "id,Name,Surname,Initials,Age,DateOfBirth\n");
    for ($i = 0; $i < $numOfVar; $i++) {
        fwrite($outputFile, $i+1 .",". $data[$i]);
    }
    fclose($outputFile);

}
function generateRow()
{
    global $names, $surnames;
    $randNum1 = rand(0, 19);
    $randNum2 = rand(0, 19);
    $age = rand(0, 120);
    $day = rand(1, 364);
    $time = strtotime("-" . $age . "Years -" . $day . "Days");
    return $names[$randNum1] . "," . $surnames[$randNum2] . "," . substr($names[$randNum1], 0, 1) . "," . $age . "," . date("d/m/Y", $time) . "\n";
}

generateCSVfile($_GET['numOfVar']);
echo '<script>window.location="index.php"</script>'; 
?>