<?php
// Mengecek AJAX Request
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' )) {
	// panggil file config.php untuk koneksi ke database
	require_once "../../config/config.php";
	// mengecek data get dari ajax
	if (isset($_GET['id_penjualan'])) {
		// sql statement untuk menampilkan data dari tabel penjualan berdasarkan id_penjualan
		$query = "SELECT a.id_penjualan,a.tanggal,a.pelanggan,a.pulsa,a.jumlah_bayar,b.nama,b.no_hp,c.provider,c.nominal
				FROM tbl_penjualan as a INNER JOIN tbl_pelanggan as b INNER JOIN tbl_pulsa as c
				ON a.pelanggan=b.id_pelanggan AND a.pulsa=c.id_pulsa WHERE id_penjualan=?";
		// membuat prepared statements
		$stmt = $mysqli->prepare($query);
		// cek query
		if (!$stmt) {
			die('Query Error: '.$mysqli->errno.'-'.$mysqli->error);
		}
		
		// ambil data get dari ajax
		$id_penjualan = $_GET['id_penjualan'];
		// hubungkan "data" dengan prepared statements
		$stmt->bind_param("i", $id_penjualan);
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