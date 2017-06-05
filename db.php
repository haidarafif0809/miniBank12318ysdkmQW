<?php date_default_timezone_set("Asia/Jakarta");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_smk4";

$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());

// perintah untuk mengkoneksikan php ke database mysql
 /* $db = new mysqli('localhost','demoo','asdakgnadjfbdfnkb34r3cff3','db_smk4_smk4bl');*/

 $db = new mysqli('localhost','root','','db_smk4');  

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}


?>