<?php session_start();

    //memasukkan file db.php
    include 'sanitasi.php';
    include 'db.php';


    //mengirim data sesuai dengan variabel denagn metode POST 

// siapkan "data" query
        $no_faktur = stringdoang($_POST['no_faktur']);
        $keterangan = stringdoang($_POST['keterangan']);
        $dari_akun = stringdoang($_POST['dari_akun']);
        $ke_akun = stringdoang($_POST['ke_akun']);
        $jumlah = angkadoang($_POST['jumlah']);
        $user = $_SESSION['user_name'];
        $tanggal_sekarang = date('Y-m-d');
        $jam_sekarang = date('H:i:s');

// buat prepared statements
    $stmt = $db->prepare("INSERT INTO tbs_penarikan (no_faktur,keterangan,dari_akun,ke_akun,jumlah,tanggal,jam,user) VALUES (?,?,?,?,?,?,?,?)");

// hubungkan "data" dengan prepared statements
        $stmt->bind_param("ssssisss", 
        $no_faktur, $keterangan, $dari_akun, $ke_akun, $jumlah,$tanggal_sekarang,$jam_sekarang, $user);        
        


// jalankan query
        $stmt->execute();
        

        
if (!$stmt) {
   die('Query Error : '.$db->errno.
   ' - '.$db->error);
}

 //menampilkan semua data yang ada pada tabel tbs kas masuk dalam DB
     $perintah = $db->query("SELECT km.id, km.session_id, km.no_faktur, km.keterangan, km.dari_akun, km.ke_akun, km.jumlah, km.tanggal, km.jam, km.user, da.nama_daftar_akun,p.nama_pelanggan,p.kode_pelanggan,p.id AS id_pelanggan FROM tbs_penarikan km INNER JOIN daftar_akun da ON km.dari_akun = da.kode_daftar_akun INNER JOIN pelanggan p ON km.ke_akun = p.id WHERE km.no_faktur = '$no_faktur' AND km.ke_akun = '$ke_akun' ");

      //menyimpan data sementara yang ada pada $perintah

     $data1 = mysqli_fetch_array($perintah);


      echo "<tr class='tr-id-".$data1['id']."'>
      <td>". $data1['no_faktur'] ."</td>
      <td>". $data1['keterangan'] ."</td>
      <td data-dari-akun ='".$data1['nama_daftar_akun']."'>". $data1['nama_daftar_akun'] ."</td>
      <td>(". $data1['kode_pelanggan'] .") ". $data1['nama_pelanggan'] ."</td>
      
      <td class='edit-jumlah' data-id='".$data1['id']."'><span id='text-jumlah-".$data1['id']."'>". rp($data1['jumlah']) ."</span> <input type='hidden' id='input-jumlah-".$data1['id']."' value='".$data1['jumlah']."' class='input-jumlah' data-id='".$data1['id']."' data-ke_akun='".$data1['ke_akun']."' autofocus='' data-jumlah='".$data1['jumlah']."' onkeydown='return numbersonly(this, event);' onkeyup='javascript:tandaPemisahTitik(this);'> </td>
      
      <td>". $data1['tanggal'] ."</td>
      <td>". $data1['jam'] ."</td>
      <td>". $data1['user'] ."</td>

      <td> <button class='btn btn-danger btn-hapus-tbs btn-sm' data-id='". $data1['id'] ."' id='btn-hapus-".$data1['id']."' data-jumlah='". $data1['jumlah'] ."' data-dari='". $data1['dari_akun'] ."' data-faktur='". $data1['no_faktur'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button>  </td> 

      </tr>";
    
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
    ?>
