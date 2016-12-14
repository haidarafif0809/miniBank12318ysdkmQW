<?php

include 'sanitasi.php';
include 'db.php';

    
    $jenis_edit = stringdoang($_POST['jenis_edit']);

if ($jenis_edit == 'jumlah') {

$query = $db->prepare("UPDATE tbs_penarikan SET jumlah = ? WHERE id = ?");

$query->bind_param("ii",
    $input_jumlah, $id);
    
    $id = angkadoang($_POST['id']);
    $input_jumlah = angkadoang($_POST['input_jumlah']);

$query->execute();

    if (!$query) 
    {
    die('Query Error : '.$db->errno.
    ' - '.$db->error);
    }


}

    //Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>

