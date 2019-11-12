<?php
// Mengecek AJAX Request
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' )) {
	// panggil file config.php untuk koneksi ke database
	require_once "../../config/config.php";
	
	// sql statement untuk menampilkan jumlah data dari tabel penjualan
	$query = "SELECT count(id_penjualan) as jumlah FROM tbl_penjualan";
	// membuat prepared statements
	$stmt = $mysqli->prepare($query);
	// cek query
	if (!$stmt) { // jika error
		die('Query Error: '.$mysqli->errno.'-'.$mysqli->error);
	}
	
	// jalankan query: execute
	$stmt->execute();
	// ambil hasil query
	$result = $stmt->get_result();
	// tampilkan hasil query
	$data = $result->fetch_assoc();
	// tampilkan data
	echo number_format($data['jumlah']);
	// tutup statement
	$stmt->close();
	// tutup koneksi
	$mysqli->close();
} else {
	// jika tidak ada ajax request, maka alihkan ke halaman index.php
	echo '<script>window.location="../../index.php"</script>';
}
?>