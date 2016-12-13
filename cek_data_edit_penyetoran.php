<?php 
include 'db.php';

$dariakun = $_POST['dariakun'];

$select = $db->query("SELECT * FROM tbs_penyetoran WHERE dari_akun = '$dariakun'");
$jumlah = mysqli_num_rows($select);

if ($jumlah > 0) {
	echo "ya";
}
else{

}

 ?>