<?php
// Mengecek AJAX Request
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' )) {

// sql statement untuk join table
$table = <<<EOT
(
	SELECT a.id_penjualan,a.tanggal,a.pelanggan,a.pulsa,a.jumlah_bayar,b.nama,b.no_hp,c.provider,c.nominal
	FROM tbl_penjualan as a INNER JOIN tbl_pelanggan as b INNER JOIN tbl_pulsa as c
	ON a.pelanggan=b.id_pelanggan AND a.pulsa=c.id_pulsa
) temp
EOT;

	// primary key tabel
	$primaryKey = 'id_penjualan';

	// membuat array untuk menampilkan isi tabel.
	// Parameter 'db' mewakili nama kolom dalam database.
	// parameter 'dt' mewakili pengenal kolom pada DataTable.
	$columns = array(
		array( 'db' => 'id_penjualan', 'dt' => 1 ),
		array(
			'db' => 'tanggal',
			'dt' => 2,
			'formatter' => function( $d, $row ) {
			return date('d-m-Y', strtotime($d));
			}
		),
		array( 'db' => 'pelanggan', 'dt' => 3 ),
		array( 'db' => 'nama', 'dt' => 4 ),
		array( 'db' => 'no_hp', 'dt' => 5 ),
		array( 'db' => 'pulsa', 'dt' => 6 ),
		array( 'db' => 'provider', 'dt' => 7 ),
		array(
			'db' => 'nominal',
			'dt' => 8,
			'formatter' => function( $d, $row ) {
			return number_format($d);
			}
		),
		array(
			'db' => 'jumlah_bayar',
			'dt' => 9,
			'formatter' => function( $d, $row ) {
			return 'Rp. '.number_format($d);
			}
		),
		array( 'db' => 'id_penjualan', 'dt' => 10 )
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