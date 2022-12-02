# Devprox Proficiency Test 

Thank you for taking the time to attempt this test. As a business we encourage
innovative thinking and initiative. In these tests before you we are looking for those
elements but we are strongly urging that you consider what has been asked for.
Anything above what is asked is a bonus but due to time constraints may hinder your
progress. The test should be conducted in any language you are familiar and
proficient with. On completion submit to Github repository. Make sure you have
given us the necessary instructions to deploy your solution, if you use a specific
database ensure that we will be able to get it running.

## Test 1

Create an HTML form with the following input fields to allow for the capturing of
data into a database:
Name, Surname, Id No, Date of Birth, POST button, CANCEL button
Create a database with a relevant schema to store the input fields in.




## Test 2

This task is to test your skills in manipulating arrays and file handling.
In this test you will be making a CSV file of variable length, a form will ask for the
amount of data to generate. Check the requirements on how to generate the file.
The file will have the following header fields
Id, Name, Surname, Initials, Age, DateOfBirth
The data will look like this
"1","Andre","van Zuydam", "A", "33","13/02/1979"
"2","Tyron James", "Hall", "TJ", "32", "03/06/1980";
After this you will import the file into a database and output a count of all the
records imported.

## Repository Breakdown

- DevProxTest1 is a directory containing 2 files.
  - index.php the file that solves Test 1.
  - devproxtest1.sql the database file.
- DevProxTest2 is a directory containing 3 files and 2 directories
- - output is a directory where files output by the test 2 web application
- - uploads is a directory where files are saved to when uploaded to the web application by the user
- - devProxTest2.php is the page that is called to generate a new file
- - index.php is the main page of the test 2 application contianing forms for both funcitons required and calls other pages when needed
- - upload.php is the page that handles file uploads to make sure that the file uploaded by the user is valid.

# Installation instructions

1. Download and install XAMPP at *https://www.apachefriends.org/download.html*
2. Download and unzip the *devProxProficiencyTest* repository and repository folder inside the *xampp/htdox* directory at the location you installed xampp.
3. Open the xampp control pannel.
4. Click on the config button for Apache and open the PHP (php.ini) file.
5. Search for *max_execution_time* and change its value to 0.
6. Search for *mysqlnd.net_read_buffer_size* and change its value to 526288000
7. Save the file and exit.
8. Go back to the Xampp control pannel and start the Apache and MySQL Modules.
9. Click on the Mysql admin button, your browser should open and the phpmyadmin window should show up. 
10. Navigate to *New* in the tree structure on the left and copy the following into the field that says "Database name": *devproxtest1*
11. click create button
12. The devproxtest1 database should apear in the tree structure on the left part of the window. Navigate to it then click the *import tab* at the top middle of your window.
13. Click choose file and choose the *devproxtest1.sql* inside the DevProxTest1 folder inside the repository.
14. Click import button at the bottom of the window.
15. You are now free to use the test 1 and test 2 applications.
16. Open test 1 at *http://localhost/DevProxProficiencyTest/DevProxTest1/index.php*
17. Open Test 2 at *http://localhost/DevProxProficiencyTest/DevProxTest2/index.php*
18. Note: if you already uploaded a file in test 2 and wish to upload a second, please drop the csv_import table from the devprox1 database, as it was a requirement to name the table *csv_import* and could not dynamically generate new tables for additional uploads.
