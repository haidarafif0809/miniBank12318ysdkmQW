<?php 
include 'sanitasi.php';
include 'db.php';

$keakun = stringdoang($_POST['keakun']);

$select = $db->query("SELECT SUM(jumlah) AS total_tabungan FROM detail_penyetoran WHERE dari_akun = '$keakun' ");
$jumlah = mysqli_fetch_array($select);
echo $total = $jumlah['total_tabungan'];


 ?>