<?php session_start();

include 'header.php';
include 'sanitasi.php';
include 'db.php';

$no_faktur = $_GET['no_faktur'];


$select_one = $db->query("SELECT p.keterangan,p.jumlah, p.tanggal, p.jam, p.user, da.nama_daftar_akun FROM penyetoran p INNER JOIN daftar_akun da ON p.ke_akun = da.kode_daftar_akun WHERE no_faktur = '$no_faktur'");
$out_one = mysqli_fetch_array($select_one);

$query1 = $db->query("SELECT * FROM perusahaan ");
$next_cp = mysqli_fetch_array($query1);
    


 ?>
<style type="text/css">
/*unTUK mengatur ukuran font*/
   .satu {
   font-size: 15px;
   font: verdana;
   }
</style>


<div class="container">
    
    <div class="row"><!--row1-->
        <div class="col-sm-2">
                <img src='save_picture/<?php echo $next_cp['foto']; ?>' class='img-rounded' alt='Cinque Terre' width='80' height='80`'> 
        </div><!--penutup colsm2-->

        <div class="col-sm-8">
                 <center> <h4> <b> <?php echo $next_cp['nama_perusahaan']; ?> </b> </h4> 
                 <p> <?php echo $next_cp['alamat_perusahaan']; ?><br>
                  No.Telp:<?php echo $next_cp['no_telp']; ?> </p> </center>
                 
        </div><!--penutup colsm5-->
        
    </div><!--penutup row1-->



    <center> <h4> <b> Faktur Tabungan</b> </h4> </center>
<br>

  <div class="row">
    <div class="col-sm-9">
        

 <table>
  <tbody>
      <tr><td width="25%"><font class="satu">No Faktur</font></td> <td> :&nbsp;</td> <td><font class="satu"><?php echo $no_faktur; ?></font> </tr>

      <tr><td  width="25%"><font class="satu">Ket.</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo $out_one['keterangan']; ?> </font></td></tr>
        
  </tbody>
</table>


    </div>

    <div class="col-sm-3">
 <table>
  <tbody>

       <tr><td width="50%"><font class="satu"> Tanggal</td> <td> :&nbsp;&nbsp;</td> <td><?php echo tanggal($out_one['tanggal']);?></font> </td></tr> 

       <tr><td width="50%"><font class="satu"> Petugas</td> <td> :&nbsp;&nbsp;</td> <td><?php echo $_SESSION['nama']; ?></font></td></tr> 

      </tbody>
</table>

    </div> <!--end col-sm-2-->
   </div> <!--end row-->  




<style type="text/css">
  th,td{
    padding: 1px;
  }


.table1, .th, .td {
    border: 1px solid black;
    font-size: 15px;
    font: verdana;
}


</style>
<br><br>

<table id="tableuser" class="table table-bordered">
    <thead>
      <th> No. Faktur </th>
      <th> Dari Akun </th>
      <th> Ke Akun </th>
      <th> Jumlah </th> 
      <th> Tanggal </th>
      <th> Jam </th>
      <th> Keterangan </th>
      <th> User </th>    
      
    </thead>
    
    <tbody>
    <?php

$perintah = $db->query("SELECT dp.keterangan,dp.no_faktur,dp.dari_akun,dp.ke_akun,dp.jumlah,dp.tanggal,dp.jam,dp.user,da.nama_daftar_akun FROM detail_penyetoran dp INNER JOIN daftar_akun da ON dp.ke_akun = da.kode_daftar_akun WHERE dp.no_faktur = '$no_faktur'");
      while ($data1 = mysqli_fetch_array($perintah))
      {

  $show = $db->query("SELECT kode_pelanggan,nama_pelanggan FROM pelanggan WHERE id = '$data1[dari_akun]'");
        $take = mysqli_fetch_array($show);

        //menampilkan data
      echo "<tr>
      <td>". $data1['no_faktur'] ."</td>
      <td>(".$take['kode_pelanggan'] .") ".$take['nama_pelanggan']."</td>
      <td>". $data1['nama_daftar_akun'] ."</td>
      <td>". rp($data1['jumlah']) ."</td>      
      <td>". $data1['tanggal'] ."</td>
      <td>". $data1['jam'] ."</td>
      <td>". $data1['keterangan'] ."</td>
      <td>". $data1['user'] ."</td>
      </tr>";
      }

//Untuk Memutuskan Koneksi Ke Database

mysqli_close($db); 
    ?>
    </tbody>

  </table>


<br>

        <div class="col-sm-6">
            
            <i><b><font class="satu">Terbilang :</font></b> <?php echo kekata($out_one['jumlah']); ?> </i> <br>
            <!DOCTYPE html>

<style>
div.dotted {border-style: dotted;}
div.dashed {border-style: dashed;}
div.solid {border-style: solid;}
div.double {border-style: double;}
div.groove {border-style: groove;}
div.ridge {border-style: ridge;}
div.inset {border-style: inset;}
div.outset {border-style: outset;}
div.none {border-style: none;}
div.hidden {border-style: hidden;}
div.mix {border-style: dotted dashed solid double;}
</style>


</div>
 <div class="col-sm-3">

 <table>
  <tbody>

      <tr><td  width="50%"><font class="satu">Total Uang</font></td> <td> :&nbsp;</td> <td><font class="satu">Rp. <?php echo rp($out_one['jumlah']); ?></font>  </td></tr> 

  </tbody>
</table>

        </div>

        <div class="col-sm-3">

 <table>
  <tbody>


  </tbody>
</table>

        </div>


    <div class="col-sm-9">
    

    
    </div> <!--/ col-sm-6-->
    
    <div class="col-sm-3">
    
    <font class="satu"><b>Petugas <br><br><br> <font class="satu"><?php echo $_SESSION['nama']; ?></font></b></font>

    </div> <!--/ col-sm-6-->




</div> <!--/container-->


 <script>
$(document).ready(function(){
  window.print();
});
</script>



<?php include 'footer.php'; ?>