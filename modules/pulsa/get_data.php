<?php
// Mengecek AJAX Request
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' )) {
	// panggil file config.php untuk koneksi ke database
	require_once "../../config/config.php";
	// mengecek data get dari ajax
	if (isset($_GET['id_pulsa'])) {
		// sql statement untuk menampilkan data dari tabel pulsa berdasarkan id_pulsa
		$query = "SELECT * FROM tbl_pulsa WHERE id_pulsa=?";
		// membuat prepared statements
		$stmt = $mysqli->prepare($query);
		//cek query
		if (!$stmt) {
			die('Query Error: '.$mysqli->errno.'-'.$mysqli->error);
		}
		
		// ambil data get dari ajax
		$id_pulsa = $_GET['id_pulsa'];
		// hubungkan "data" dengan prepared statements
		$stmt->bind_param("i", $id_pulsa);
		// jalankan query: execute
		$stmt->execute();
		// ambil hasil query
		$result = $stmt->get_result();
		// tampilkan hasil query
		$data = $result->fetch_assoc();
		
		// tutup statement
		$stmt->close();
	// tutup koneksi
	$mysqli->close();
	
	echo json_encode($data);
} else {
	// jika tidak ada ajax request, maka alihkan ke halaman index.php
	echo '<script>window.location="../../index.php"</script>';
}
?>