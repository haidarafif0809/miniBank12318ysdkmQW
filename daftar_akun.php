<?php include_once 'session_login.php';
 

// memasukan file session login,  header, navbar, db.php,
include 'header.php';
include 'navbar.php';
include 'db.php';
include 'sanitasi.php';



// menampilkan seluruh data yang ada pada tabel penjualan yang terdapt pada DB
 $perintah = $db->query("SELECT * FROM daftar_akun WHERE tipe_akun = 'Kas & Bank' ORDER BY id DESC");



 ?>


<style>
tr:nth-child(even){background-color: #f2f2f2}
</style>

<div class="container">

<h3><b>DATA AKUN KAS</b></h3> <hr>


<?php 
include 'db.php';

$pilih_akses_satuan_tambah = $db->query("SELECT daftar_akun_tambah FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND daftar_akun_tambah = '1'");
$satuan_tambah = mysqli_num_rows($pilih_akses_satuan_tambah);


    if ($satuan_tambah > 0){
// Trigger the modal with a button -->
echo '<a href="form_tambah_daftar_akun.php" class="btn btn-info"><i class="fa fa-plus"> </i> TAMBAH AKUN KAS</a>';

}

?>
<br><br>


<!-- Modal Hapus data -->
<div id="modal_hapus" class="modal fade" role="dialog">
  <div class="modal-dialog">



    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmasi Hapus Data Akun</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
    <label> Nama Akun :</label>
     <input type="text" id="nama_group" class="form-control" readonly=""> 
     <input type="hidden" id="id_hapus" class="form-control" > 
    </div>
   
   </form>
   
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Hapus
  </div>
 

     </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-info" id="btn_jadi_hapus"> <span class='glyphicon glyphicon-ok-sign'> </span>Ya</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal"><span class='glyphicon glyphicon-remove-sign'> </span>Batal</button>
      </div>
    </div>

  </div>
</div><!-- end of modal hapus data  -->

<br><br>


<div class="table-responsive">
<span id="table-baru">
<table id="tableuser" class="table table-bordered">
		<thead>
			<th style="background-color: #4CAF50; color:white"> Kode Akun </th>
			<th style="background-color: #4CAF50; color:white"> Nama Akun </th>

			<th style="background-color: #4CAF50; color:white"> User Buat</th>
			<th style="background-color: #4CAF50; color:white"> User Edit </th>
			<th style="background-color: #4CAF50; color:white"> Waktu </th>

<?php 
include 'db.php';

$pilih_akses_satuan_hapus = $db->query("SELECT daftar_akun_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND daftar_akun_hapus = '1'");
$satuan_hapus = mysqli_num_rows($pilih_akses_satuan_hapus);


    if ($satuan_hapus > 0){
			echo "<th style='background-color: #4CAF50; color:white'> Hapus </th>";

		}
?>

			
		</thead>
		
		<tbody>
		<?php

		
			while ($data = mysqli_fetch_array($perintah))
			{
				$query2 = $db->query("SELECT kode_grup_akun FROM grup_akun");
				$data1 = mysqli_fetch_array($query2);

			echo "<tr class='tr-id-". $data['id'] ."'>
			<td>". $data['kode_daftar_akun'] ."</td>

			<td class='edit-nama' data-id='".$data['id']."'><span id='text-nama-". $data['id'] ."'>". $data['nama_daftar_akun'] ."</span>
			<input type='hidden' id='input-nama-".$data['id']."' value='".$data['nama_daftar_akun']."' class='input_nama' data-id='".$data['id']."' autofocus=''></td>";

			echo"
			<td>". $data['user_buat'] ."</td>
			<td>". $data['user_edit'] ."</td>
			<td>". $data['waktu'] ."</td>";

$pilih_akses_satuan_hapus = $db->query("SELECT daftar_akun_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND daftar_akun_hapus = '1'");
$satuan_hapus = mysqli_num_rows($pilih_akses_satuan_hapus);


    if ($satuan_hapus > 0){
			echo "<td> <button class='btn btn-danger btn-hapus' data-id='". $data['id'] ."' data-akun='". $data['nama_daftar_akun'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td>

			</tr>";
		}

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
		$('#tableuser').DataTable(
			{"ordering": false});
		});
		</script>

<script type="text/javascript">
    $(document).ready(function(){
	//fungsi hapus data 
		$(".btn-hapus").click(function(){
		var nama_group = $(this).attr("data-akun");
		var id = $(this).attr("data-id");
		$("#nama_group").val(nama_group);
		$("#id_hapus").val(id);
		$("#modal_hapus").modal('show');
		
		
		});


		$("#btn_jadi_hapus").click(function(){
		
		var id = $("#id_hapus").val();
		$.post("hapus_daftar_akun.php",{id:id},function(data){
		if (data != "") {
		
		$(".tr-id-"+id+"").remove();
		$("#modal_hapus").modal('hide');
		
		}

		
		});
		
		});
		});


	$("form").submit(function(){
    return false;
    
    });
// end fungsi hapus data
</script>


<!-- EDIT --><!-- EDIT --><!-- EDIT --><!-- EDIT --><!-- EDIT --><!-- EDIT --><!-- EDIT -->

                             <script type="text/javascript">
                                 
                                 $(".edit-nama").dblclick(function(){

                                    var id = $(this).attr("data-id");

                                    $("#text-nama-"+id+"").hide();

                                    $("#input-nama-"+id+"").attr("type", "text");

                                 });

                                 $(".input_nama").blur(function(){

                                    var id = $(this).attr("data-id");

                                    var input_nama = $(this).val();


                                    $.post("update_daftar_akun.php",{id:id, input_nama:input_nama,jenis_edit:"nama_daftar_akun"},function(data){

                                    $("#text-nama-"+id+"").show();
                                    $("#text-nama-"+id+"").text(input_nama);

                                    $("#input-nama-"+id+"").attr("type", "hidden");           

                                    });
                                 });

                             </script>


                             <script type="text/javascript">
                                 
                                 $(".edit-parent").dblclick(function(){

                                    var id = $(this).attr("data-id");

                                    $("#text-parent-"+id+"").hide();

                                    $("#select-parent-"+id+"").show();

                                 });

                                 $(".select-parent").blur(function(){

                                    var id = $(this).attr("data-id");

                                    var select_parent = $(this).val();


                                    $.post("update_daftar_akun.php",{id:id, select_parent:select_parent,jenis_select:"grup_akun"},function(data){

                                    $("#text-parent-"+id+"").show();
                                    $("#text-parent-"+id+"").text(select_parent);

                                    $("#select-parent-"+id+"").hide();           

                                    });
                                 });

                             </script>


                             <script type="text/javascript">
                                 
                                 $(".edit-kategori").dblclick(function(){

                                    var id = $(this).attr("data-id");

                                    $("#text-kategori-"+id+"").hide();

                                    $("#select-kategori-"+id+"").show();

                                 });

                                 $(".select-kategori").blur(function(){

                                    var id = $(this).attr("data-id");

                                    var select_kategori = $(this).val();


                                    $.post("update_daftar_akun.php",{id:id, select_kategori:select_kategori,jenis_select:"kategori_akun"},function(data){

                                    $("#text-kategori-"+id+"").show();
                                    $("#text-kategori-"+id+"").text(select_kategori);

                                    $("#select-kategori-"+id+"").hide();           

                                    });
                                 });

                             </script>

                             <script type="text/javascript">
                                 
                                 $(".edit-tipe").dblclick(function(){

                                    var id = $(this).attr("data-id");

                                    $("#text-tipe-"+id+"").hide();

                                    $("#select-tipe-"+id+"").show();

                                 });

                                 $(".select-tipe").blur(function(){

                                    var id = $(this).attr("data-id");

                                    var select_tipe = $(this).val();


                                    $.post("update_daftar_akun.php",{id:id, select_tipe:select_tipe,jenis_select:"tipe_akun"},function(data){

                                    $("#text-tipe-"+id+"").show();
                                    $("#text-tipe-"+id+"").text(select_tipe);

                                    $("#select-tipe-"+id+"").hide();           

                                    });
                                 });

                             </script>

                             <?php 
                             include 'footer.php';
                              ?>