<?php 
include 'db.php';
include 'sanitasi.php';

$id_nasabah = stringdoang($_POST['id']);

$query_penarikan = $db->query("SELECT ke_akun FROM detail_penarikan WHERE ke_akun = '$id_nasabah'");
$jumlah_penarikan = mysqli_num_rows($query_penarikan);

$query_penyetoran = $db->query("SELECT ke_akun FROM detail_penarikan WHERE ke_akun = '$id_nasabah'");
$jumlah_penyetoran = mysqli_num_rows($query_penyetoran);


if ($jumlah_penarikan > 0 OR $jumlah_penyetoran > 0){
	echo "1";
}
else {

}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);

?>