<?php include 'session_login.php';
include 'db.php';
include 'sanitasi.php';

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	0 => 'no_faktur', 
	1 => 'ke_akun',
	2 => 'jumlah',
	3 => 'tanggal',
	4 => 'jam',
	5 => 'user',
	6 => 'petugas_edit',
	7 => 'tanggal_edit',
	8 => 'cetak',
	9=> 'detal',
	10=> 'edit',
	11=> 'hapus',
	12=> 'id'

);

// getting total number records without any search
$sql = "SELECT km.user,km.petugas_edit,km.tanggal_edit,km.jam_edit,km.id, km.no_faktur, km.keterangan, km.ke_akun, km.jumlah, km.tanggal, km.jam, km.user, da.nama_daftar_akun ";
$sql.= "FROM penyetoran km INNER JOIN daftar_akun da ON km.ke_akun = da.kode_daftar_akun ";
$query=mysqli_query($conn, $sql) or die("1.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

// getting total number records without any search
$sql = "SELECT km.user,km.petugas_edit,km.tanggal_edit,km.jam_edit,km.id, km.no_faktur, km.keterangan, km.ke_akun, km.jumlah, km.tanggal, km.jam, km.user, da.nama_daftar_akun ";
$sql.= "FROM penyetoran km INNER JOIN daftar_akun da ON km.ke_akun = da.kode_daftar_akun ";
$sql.=" WHERE 1=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter

	$sql.=" AND (km.no_faktur LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR km.tanggal LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR km.user LIKE '".$requestData['search']['value']."%' ";  
	$sql.=" OR km.jumlah LIKE '".$requestData['search']['value']."%' "; 
	$sql.=" OR da.nama_daftar_akun LIKE '".$requestData['search']['value']."%' )";
}

$query=mysqli_query($conn, $sql) or die("2.php: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY km.id ".$requestData['order'][0]['dir']." LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("3.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 
		
	$nestedData[] = $row["no_faktur"];
	$nestedData[] = $row["nama_daftar_akun"];
	$nestedData[] = rp($row["jumlah"]);	
	$nestedData[] = $row["tanggal"];
	$nestedData[] = $row["jam"];
	$nestedData[] = $row["user"];
	$nestedData[] = $row["petugas_edit"];
	$nestedData[] = " ".$row['tanggal_edit']." ".$row['jam_edit']." ";

$pilih_akses = $db->query("SELECT penyetoran_edit, penyetoran_hapus FROM otoritas_transaksi_kas WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$data_akses = mysqli_fetch_array($pilih_akses);

$nestedData[] = "<a style='width: 65px;' class='btn btn-primary btn-sm' href='cetak_data_penyetoran.php?no_faktur=".$row['no_faktur']."' target='blank'> <i class='fa fa-print'></i> &nbsp;Cetak </a> ";

$nestedData[] = "<button class=' btn btn-info detail btn-sm' no_faktur='". $row['no_faktur'] ."'> <span class='glyphicon glyphicon-th-list'></span> Detail </button>";

if ($data_akses['penyetoran_edit'] == 1) {

	$nestedData[] = "<a href='proses_edit_data_penyetoran.php?no_faktur=". $row['no_faktur']."&nama_daftar_akun=". $row['nama_daftar_akun']."' class='btn btn-success btn-sm'> <span class='glyphicon glyphicon-edit'></span> Edit </a>";
		}

if ($data_akses['penyetoran_hapus'] == 1) {
	$nestedData[] = "<button class=' btn btn-danger btn-hapus btn-sm' data-id='". $row['id'] ."' no-faktur='". $row['no_faktur'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button>";
}

	$nestedData[] = $row["id"];

	$data[] = $nestedData;
}

$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format

?>