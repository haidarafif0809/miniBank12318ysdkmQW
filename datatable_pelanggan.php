<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
/* Database connection end */
include 'sanitasi.php';

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	0 =>'kode_pelanggan', 
	1 => 'nama_pelanggan',
	2 => 'level_harga',
	3 => 'tgl_lahir',
	4 => 'no_telp',
	5 => 'e_mail',
	6 => 'wilayah',
	7 => 'nama',
	8 => 'total',
	9 => 'edit',
	10 => 'hapus',
	11 => 'reset',
);


// getting total number records without any search
$sql = " SELECT * ";
$sql.= " FROM pelanggan ";
$query=mysqli_query($conn, $sql) or die("datatable_penjamin.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT * ";
$sql.=" FROM pelanggan WHERE 1=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( kode_pelanggan LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR nama_pelanggan LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR tgl_lahir LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR no_telp LIKE '".$requestData['search']['value']."%' )";
}
$query=mysqli_query($conn, $sql) or die("datatable_penjamin.php: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 




				//menampilkan data
		$select_jurusan = $db->query("SELECT nama FROM jurusan WHERE id = '$row[jurusan]'");
        $taked = mysqli_fetch_array($select_jurusan);

		$select = $db->query("SELECT SUM(jumlah) AS total_tabungan FROM detail_penyetoran WHERE dari_akun = '$row[id]' ");
		$jumlah = mysqli_fetch_array($select);

		$select1 = $db->query("SELECT SUM(jumlah) AS total_tabungan1 FROM detail_penarikan WHERE ke_akun = '$row[id]' ");
		$jumlah1 = mysqli_fetch_array($select1);


 		$total = $jumlah['total_tabungan'] - $jumlah1['total_tabungan1'];

 	$nestedData[] =  $row['kode_pelanggan'];
 	$nestedData[] =  $row['nama_pelanggan'];
 	$nestedData[] =  $row['level_harga'];
 	$nestedData[] =  tanggal($row['tgl_lahir']);
 	$nestedData[] =  $row['no_telp']; 
 	$nestedData[] =  $row['e_mail'];
 	$nestedData[] =  $row['wilayah'];
 	$nestedData[] =  $taked['nama'];
 	$nestedData[] =  rp($total);
	


	$pilih_akses_pelanggan_hapus = $db->query("SELECT pelanggan_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND pelanggan_hapus = '1'");
$pelanggan_hapus = mysqli_num_rows($pilih_akses_pelanggan_hapus);


    if ($pelanggan_hapus > 0){


			$nestedData[] = "<button class='btn btn-danger btn-hapus' data-id='". $row['id'] ."' data-pelanggan='". $row['nama_pelanggan'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button>";

		}


$pilih_akses_pelanggan_edit = $db->query("SELECT pelanggan_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND pelanggan_edit = '1'");
$pelanggan_edit = mysqli_num_rows($pilih_akses_pelanggan_edit);


    if ($pelanggan_edit > 0){
			$nestedData[] =  "<button class='btn btn-info btn-edit' data-pelanggan='". $row['nama_pelanggan'] ."' data-kode='". $row['kode_pelanggan'] ."' data-tanggal='". $row['tgl_lahir'] ."' data-nomor='". $row['no_telp'] ."' data-email='". $row['e_mail'] ."' data-wilayah='". $row['wilayah'] ."' data-level-harga='". $row['level_harga'] ."' data-jurusan='". $row['jurusan'] ."' data-id='". $row['id'] ."'> <span class='glyphicon glyphicon-edit'> </span> Edit </button>";
		}


			$nestedData[] = "<button class='btn btn-warning btn-reset' data-reset-id='". $row['id'] ."'> <span class='glyphicon glyphicon-repeat'> </span> Reset </button>";


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
