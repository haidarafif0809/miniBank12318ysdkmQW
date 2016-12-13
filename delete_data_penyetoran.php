<?php session_start();

//memasukkan file db.php
include 'db.php';

//mengirimkan $id menggunakan metode GET
	 $id = $_POST['id'];
	 $no_faktur = $_POST['no_faktur'];
	 $user = $_SESSION['nama'];
	 $waktu = date('Y-m-d H:i:s');

 // INSERT HISTORY KAS MASUK
$kas_masuk = $db->query("SELECT * FROM penyetoran WHERE no_faktur = '$no_faktur'");
$data_setor = mysqli_fetch_array($kas_masuk);

	$insert_kas_masuk = $db->query("INSERT INTO history_penyetoran (no_faktur, keterangan, ke_akun, jumlah, tanggal, jam, user,petugas_edit,tanggal_edit,jam_edit,petugas_hapus, waktu_hapus) VALUES ('$no_faktur','$data_setor[keterangan]','$data_setor[ke_akun]','$data_setor[jumlah]',
		'$data_setor[tanggal]','$data_setor[jam]','$data_setor[user]',
		'$data_setor[petugas_edit]','$data_setor[tanggal_edit]','$data_setor[jam_edit]',
		'$user','$waktu')");


// INSERT HISTORY DETAIL KAS MASUK
$detail_kas_masuk = $db->query("SELECT * FROM detail_penyetoran WHERE no_faktur = '$no_faktur'");
while($out = mysqli_fetch_array($detail_kas_masuk)){

$in_history = $db->query("INSERT INTO history_detail_penyetoran (no_faktur, keterangan, dari_akun,ke_akun,jumlah,tanggal,jam,user,petugas_hapus,waktu_hapus,waktu_edit) VALUES ('$no_faktur','$out[keterangan]','$out[dari_akun]','$out[ke_akun]','$out[jumlah]','$out[tanggal]',
	'$out[jam]','$out[user]','$user','$waktu','$out[waktu_edit]')");

} 



//jika $query benar maka akan menuju file kas.php , jika salah maka failed
if ($in_history == TRUE)
{

echo "sukses";
}
else
{
	
}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>
