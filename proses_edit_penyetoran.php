<?php session_start();


    include 'sanitasi.php';
    include 'db.php';
    
echo $no_faktur = stringdoang($_POST['no_faktur']);

$tahun_sekarang = date('Y');
$bulan_sekarang = date('m');
$tanggal_sekarang = date('Y-m-d');
$jam_sekarang = date('H:i:s');
$tahun_terakhir = substr($tahun_sekarang, 2);
$waktu = date('Y-m-d H:i:s');

$query5 = $db->query("DELETE FROM detail_penyetoran WHERE no_faktur = '$no_faktur'");  


    $perintah = $db->prepare("UPDATE penyetoran SET no_faktur = ?, keterangan = ?, ke_akun = ?, jumlah = ?, tanggal_edit = ?, jam_edit = ?, petugas_edit = ? WHERE no_faktur = ?");

    $perintah->bind_param("sssissss",
        $no_faktur, $keterangan, $ke_akun , $jumlah, $tanggal, $jam_sekarang, $user, $no_faktur);

    $no_faktur = stringdoang($_POST['no_faktur']);
    $keterangan = stringdoang($_POST['keterangan']);
    $ke_akun = stringdoang($_POST['ke_akun']);
    $tanggal = stringdoang($_POST['tanggal']);
    $jumlah = angkadoang($_POST['jumlah']);
    $user = $_SESSION['nama'];
    $no_faktur = stringdoang($_POST['no_faktur']);

    $perintah->execute();

    $query = $db->prepare("UPDATE kas SET jumlah = jumlah + ? WHERE nama = ?");
    
    $query->bind_param("is", 
    $jumlah, $ke_akun);

    $jumlah = angkadoang($_POST['jumlah']);
    $ke_akun = stringdoang($_POST['ke_akun']);
    
    $query->execute();

if (!$perintah) {
   die('Query Error : '.$db->errno.
   ' - '.$db->error);
}
else {
     "sukses";

}

    $query1 = $db->query("SELECT * FROM tbs_penyetoran WHERE no_faktur = '$no_faktur'");

    while ($data=mysqli_fetch_array($query1)) {

    $query2 = $db->query("INSERT INTO detail_penyetoran (no_faktur,keterangan,dari_akun,ke_akun,
        jumlah,tanggal,jam,user,waktu_edit) VALUES ('$no_faktur','$data[keterangan]',
        '$data[dari_akun]','$data[ke_akun]','$data[jumlah]','$data[tanggal]','$data[jam]',
        '$data[user]','$waktu')");

    }
    

//jurnal



    $query3 = $db->query("DELETE FROM tbs_penyetoran WHERE no_faktur = '$no_faktur'");                      
  
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
    ?>