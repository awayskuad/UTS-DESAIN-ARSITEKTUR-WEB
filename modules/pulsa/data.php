<?php
// Mengecek AJAX Request
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' )) {
	
	// nama tabel
	$table = 'tbl_pulsa';
	// primary key tabel
	$primaryKey = 'id_pulsa';
	
	// membuat array untuk menampilkan isi tabel.
	// Parameter 'db' mewakili nama kolom dalam database.
	// parameter 'dt' mewakili pengenal kolom pada DataTable.
	$columns = array(
		array( 'db' => 'provider', 'dt' => 1 ),
		array(
			'db'	=> 'nominal',
			'dt'	=> 2,
			'formatter' => function( $d, $row ) {
				return number_format($d);
			}
		),
		array(
			'db'	=> 'harga',
			'dt'	=> 3,
			'formatter' => function( $d, $row ) {
				return 'Rp. '.number_format($d);
			}
		),
		array( 'db' => 'id_pulsa', 'dt' => 4 )
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