<?php include 'session_login.php';

    
    //memasukkan file session login, header, navbar, db
    include 'header.php';
    include 'navbar.php';
    include 'db.php';
    include 'sanitasi.php';
    
?>

<div class="container">

<h3><b>DAFTAR AKUN KAS</b></h3> <br>

<form action="proses_daftar_akun.php" method="post">
					<div class="form-group">
					<label> Kode Akun </label><br>
					<input type="text" name="kode_akun" id="kode_akun" class="form-control" placeholder="Kode Akun" autocomplete="off" required="" >
					</div>

					<div class="form-group">
					<label> Nama Akun </label>
					<br>
					<input type="text" id="nama_akun" name="nama_akun" class="form-control" placeholder="Nama Akun" autocomplete="off" required="">

					</div>


					<div class="form-group">
					<input type="hidden" name="grup_akun" id="grup_akun" value="1-1100" class="form-control">
					</div>

					<div class="form-group">
					<input type="hidden" name="kategori_akun" id="kategori_akun" value="Aktiva" class="form-control">

					
					</div>

					<div class="form-group">
					<input type="hidden" name="tipe_akun" id="tipe_akun" class="form-control" value="Kas & Bank" required="" >
					</div>

   
   					<button type="submit" id="submit_tambah" class="btn btn-primary"><span class='glyphicon glyphicon-plus'> </span> Tambah</button>

</form>
</div> <!-- end container-->





      <script type="text/javascript">
      
      $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!"});  
      
      </script>

<script type="text/javascript">

               $(document).ready(function(){
               $("#kode_akun").blur(function(){
               var kode_akun = $("#kode_akun").val();

              $.post('cek_kode_daftar_akun.php',{kode_akun:$(this).val()}, function(data){
                
                if(data == 1){

                    alert ("Kode Akun Sudah Ada");
                    $("#kode_akun").val('');
                    $("#kode_akun").focus();
                }
                else {
                    
                }
              });
                
               });
               });

</script>

<?php 

// memasukan file footer.php
include 'footer.php'; 
?>