<?php
// Mengecek AJAX Request
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' )) {

	// nama tabel
	$table = 'tbl_pelanggan';
	// primary key tabel
	$primaryKey = 'id_pelanggan';
	
	// membuat array untuk menampilkan isi tabel.
	// Parameter 'db' mewakili nama kolom dalam database.
	// parameter 'dt' mewakili pengenal kolom pada DataTable.
	$columns = array(
		array( 'db' => 'id_pelanggan', 'dt' => 1 ),
		array( 'db' => 'nama', 'dt' => 2 ),
		array( 'db' => 'no_hp', 'dt' => 3 ),
		array( 'db' => 'id_pelanggan', 'dt' => 4 )
	);
	
	// memanggil file database.php untuk informasi koneksi ke server SQL
	require_once "../../config/database.php";
	// memanggil file ssp.class.php untuk menjalankan datatables server-side processing
	require '../../config/ssp.class.php';
	
	echo json_encode(
		SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
	);
} else {
	// jika tidak ada ajax request, maka alihkan ke halaman index.php
	echo '<script>window.location="../../index.php"</script>';
}
?>