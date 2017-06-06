<?php include 'session_login.php';


// memsukan file session login, header,navbar dan db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';
 
?>


<div class="container">
<!-- Modal Untuk Confirm Delete-->
<div id="modale-delete" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>       
    </div>
    <div class="modal-body">
      <center><h4>Apakah Anda Yakin Ingin Menghapus Data Ini ?</h4></center>
      <input type="hidden" id="id2" name="id2">
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-success" id="yesss" >Yes</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
    </div>
    </div>
  </div>
</div>
<!--modal end Confirm Delete-->


<h1>Kas</h1>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal"><span class="glyphicon glyphicon-plus"></span> Tambah Kas </button>
<br>

<span id="table_baru">
<div class="table-responsive">  
<table id="table-pelamar" class="table table-bordered table-sm">
    <thead>
      <tr>
        <th>Nama</th>
        <th>Edit</th>
        <th>Hapus</th>
    </tr>
    </thead>
    <tbody>
    
   <?php 
        $query = $db->query(" SELECT * FROM kas ");
   while($data = mysqli_fetch_array($query))
      {

      echo "<tr>
      <td>". $data['nama']."</td>";


      echo "<td><a href='edit_kas.php?id=".$data['id']."'class='btn btn-warning'><span class='glyphicon glyphicon-wrench'></span> Edit </a>
      </td>
      <td><button data-id='".$data['id']."'class='btn btn-danger delete'><span class='glyphicon glyphicon-trash'></span> Hapus </button>
      </td>";
 
      echo "</tr>";
   
      }
    ?>
  </tbody>
 </table>
</div>



<!-- Modal -->
  <div class="modal fade" id="modal" role="dialog">
    <div class="modal-dialog">
  <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Form Tambah Kas</h4>
        </div>
        <div class="modal-body">

          <form role="form" action="proses_kas.php" method="POST">

<div class="form-group">
  <label for="sel1">Nama </label>
  <input type="text" class="form-control" id="nama" required="" name="nama" autocomplete="off">
</div>


<button type="submit" class="btn btn-info"><span class="glyphicon glyphicon-plus"></span> Tambah</button>
</form>
</div>
    <div class="modal-footer">
      <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

</div><!--DIV CONTAINER-->


<script>
// untuk memunculkan data tabel 
$(document).ready(function() {
        $('#table-pelamar').DataTable({"ordering":false});
    });

</script>

<!--   script modal confirmasi delete -->
<script type="text/javascript">
$(".delete").click(function(){

  var id = $(this).attr('data-id');

$("#modale-delete").modal('show');
$("#id2").val(id);

});
</script>
<!--   end script modal confiormasi dellete -->


<!--  script modal  lanjkutan confiormasi delete -->
<script type="text/javascript">
$("#yesss").click(function(){

var id = $("#id2").val();

$.post('delete_kas.php',{id:id},function(data){
    if(data == 'ok')
    {
      $("#modale-delete").modal('hide');
    }
  else{
    }

    });

});
</script>
<!--  end modal confirmasi delete lanjutan  -->

<!--FOOTER-->
<?php 
  include 'footer.php';
?>
<!--END FOOTER-->
