<?php 
include 'sanitasi.php';
include 'db.php';

$keakun = stringdoang($_POST['keakun']);
$no_faktur = stringdoang($_POST['no_faktur']);

$select = $db->query("SELECT SUM(jumlah) AS total_tabungan FROM detail_penyetoran WHERE dari_akun = '$keakun' ");
$jumlah = mysqli_fetch_array($select);

$select1 = $db->query("SELECT SUM(jumlah) AS total_tabungan1 FROM detail_penarikan WHERE ke_akun = '$keakun' ");
$jumlah1 = mysqli_fetch_array($select1);

$select2 = $db->query("SELECT SUM(jumlah) AS total_tabungan2 FROM detail_penarikan WHERE ke_akun = '$keakun' AND no_faktur = '$no_faktur' ");
$jumlah2 = mysqli_fetch_array($select2);


echo $total = $jumlah['total_tabungan'] - $jumlah1['total_tabungan1'] + $jumlah2['total_tabungan2'];;

?>