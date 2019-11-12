<?php
// Mengecek AJAX Request
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' )) {
	// panggil file config.php untuk koneksi ke database
	require_once "../../config/config.php";
	
	// mengecek data get dari ajax
	if (isset($_GET['id_pelanggan'])) {
		// sql statement untuk menampilkan data dari tabel pelanggan berdasarkan id_pelanggan
		$query = "SELECT * FROM tbl_pelanggan WHERE id_pelanggan=?";
		// membuat prepared statements
		$stmt = $mysqli->prepare($query);
		//cek query
		if (!$stmt) {
			die('Query Error: '.$mysqli->errno.'-'.$mysqli->error);
		}
		
		// ambil data get dari ajax
		$id_pelanggan = $_GET['id_pelanggan'];
		// hubungkan "data" dengan prepared statements
		$stmt->bind_param("i", $id_pelanggan);
		// jalankan query: execute
		$stmt->execute();
		// ambil hasil query
		$result = $stmt->get_result();
		// tampilkan hasil query
		$data = $result->fetch_assoc();
		
		// tutup statement
		$stmt->close();
	}
	// tutup koneksi
	$mysqli->close();
	
	echo json_encode($data);
} else {
	// jika tidak ada ajax request, maka alihkan ke halaman index.php
	echo '<script>window.location="../../index.php"</script>';
}
?>