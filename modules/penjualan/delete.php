<?php
// Mengecek AJAX Request
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' )) {
	// panggil file config.php untuk koneksi ke database
	require_once "../../config/config.php";
	
	// mengecek data post dari ajax
	if (isset($_POST['id_penjualan'])) {
		// sql statement untuk delete data dari tabel penjualan
		$query = "DELETE FROM tbl_penjualan WHERE id_penjualan=?";
		// membuat prepared statements
		$stmt = $mysqli->prepare($query);
		// hubungkan "data" dengan prepared statements
		$stmt->bind_param("i", $id_penjualan);

		// ambil data post dari ajax
		$id_penjualan = $_POST['id_penjualan'];
		
		// jalankan query: execute
		$stmt->execute();
		
		// cek hasil query
		if ($stmt) {
			// jika berhasil tampilkan pesan berhasil hapus data
		echo "sukses";
		} else {
			// jika gagal tampilkan pesan gagal hapus data
			echo "gagal";
		}
	
		// tutup statement
		$stmt->close();
	}
	// tutup koneksi
	$mysqli->close();
} else {
	// jika tidak ada ajax request, maka alihkan ke halaman index.php
	echo '<script>window.location="../../index.php"</script>';
}
?>