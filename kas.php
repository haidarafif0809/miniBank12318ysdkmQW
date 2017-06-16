<?php include 'session_login.php';

include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';


$query = $db->query("SELECT id, kode_daftar_akun, nama_daftar_akun FROM daftar_akun WHERE tipe_akun = 'Kas & Bank' ");



 ?>

<style>
      
      tr:nth-child(even){background-color: #f2f2f2}
      
</style>

<div class="container">
 <h3><b>DATA KAS</b></h3> <hr>


<!-- Modal edit data -->
<div id="modal_edit-default" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Data Kas Keluar</h4>
      </div>
      <div class="modal-body">
  <form role="form" action="update_default_kas.php" method="post">
   <div class="form-group">

          <label> Default Kas </label><br>
          <select type="text" name="kas_default" id="kas_default" autocomplete="off" class="form-control" >
          <option value="Ya">Ya</option>
          <option value="">Tidak</option>
          </select> 
     
          
          <input type="hidden" name="kode_daftar_akun" id="kode_daftar_akun" class="form-control">
          <input type="hidden" name="id" id="id_edit_default" class="form-control"> 
    
   </div>
   
   
   <button type="submit" id="submit_edit_default" class="btn btn-success">Submit</button>
  </form>


  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data Berhasil Di Edit
  </div>
 

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div><!-- end of modal edit data  -->

<div class="card card-block">

<div class="table-responsive"> 
<span id="tabel_baru">
<table id="tableuser" class="table table-bordered">
		<thead>
			<th style="background-color: #4CAF50; color: white;"> Nama  </th>
			<th style="background-color: #4CAF50; color: white;"> Jumlah </th>

			

			
			
		</thead>
		
		<tbody>
		<?php

		
			while ($data = mysqli_fetch_array($query))
		{
			echo "<tr>
      <td>". $data['nama_daftar_akun'] ."</td>";

            
// MENCARI JUMLAH KAS


           

            $query2 = $db->query("SELECT SUM(jumlah) AS jumlah_kas_masuk FROM detail_kas_masuk WHERE ke_akun = '$data[kode_daftar_akun]' ");
            $cek2 = mysqli_fetch_array($query2);
            $jumlah_kas_masuk = $cek2['jumlah_kas_masuk'];

            $query20 = $db->query("SELECT SUM(jumlah) AS jumlah_kas_masuk_mutasi FROM kas_mutasi WHERE ke_akun = '$data[kode_daftar_akun]'");
            $cek20 = mysqli_fetch_array($query20);
            $jumlah_kas_masuk_mutasi = $cek20['jumlah_kas_masuk_mutasi'];



            $query_detail_penyetoran = $db->query("SELECT SUM(jumlah) AS jumlah_detail_penyetoran FROM detail_penyetoran WHERE ke_akun = '$data[kode_daftar_akun]'");
            $data_detail_penyetoran = mysqli_fetch_array($query_detail_penyetoran);
            $sum_detail_penyetoran = $data_detail_penyetoran['jumlah_detail_penyetoran'];

//jumlah kas masuk 1

            $kas_pemasukan = $jumlah_kas_masuk + $jumlah_kas_masuk_mutasi + $sum_detail_penyetoran;



// start kas keluar 2 



            $query5 = $db->query("SELECT SUM(jumlah) AS jumlah_kas_keluar FROM kas_keluar WHERE dari_akun = '$data[kode_daftar_akun]' ");
            $cek5 = mysqli_fetch_array($query5);
            $jumlah_kas_keluar = $cek5['jumlah_kas_keluar'];

            $query5 = $db->query("SELECT SUM(jumlah) AS jumlah_kas_keluar_mutasi FROM kas_mutasi WHERE dari_akun = '$data[kode_daftar_akun]'");
            $cek5 = mysqli_fetch_array($query5);
            $jumlah_kas_keluar_mutasi = $cek5['jumlah_kas_keluar_mutasi'];




            $query_detail_penarikan = $db->query("SELECT SUM(jumlah) AS jumlah_detail_penarikan FROM detail_penarikan WHERE dari_akun = '$data[kode_daftar_akun]'");
            $data_detail_penarikan = mysqli_fetch_array($query_detail_penarikan);
            $sum_detail_penarikan = $data_detail_penarikan['jumlah_detail_penarikan'];

//jumlah kas keluar 2
            $kas_pengeluaran = $jumlah_kas_keluar + $jumlah_kas_keluar_mutasi + $sum_detail_penarikan;


// perhitungan jumlah
            $jumlah_kas = $kas_pemasukan - $kas_pengeluaran;

            echo "<td>". rp($jumlah_kas) ."</td>";

      }


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
		?>
		</tbody>

	</table>
</span>

</div>

</div>

<script>

$(document).ready(function(){
    $('#tableuser').DataTable();
});

</script>




<script type="text/javascript">
  
    $(".btn-edit-default").click(function(){
    
    $("#modal_edit-default").modal('show');
    var kode_daftar_akun = $(this).attr("data-kode");
    var id  = $(this).attr("data-id");
    $("#kode_daftar_akun").val(kode_daftar_akun);
    $("#id_edit_default").val(id);
    
    
    });

    $(".btn-edit-default").click(function(){

      var kode_daftar_akun = $("#kode_daftar_akun").val();
      var kas_default = $("#kas_default").val();
      var id = $("#id_edit_default").val();

        $.post("update_default_kas.php",{id:id,kas_default:kas_default,kode_daftar_akun:kode_daftar_akun},function(data){
        
        
        });
      });

</script>



<?php include 'footer.php'; ?>

