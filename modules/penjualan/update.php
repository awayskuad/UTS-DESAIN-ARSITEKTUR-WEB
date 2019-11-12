<?php
// Mengecek AJAX Request
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' )) {
	// panggil file config.php untuk koneksi ke database
	require_once "../../config/config.php";
	// mengecek data post dari ajax
	if (isset($_POST['id_penjualan'])) {
		// sql statement untuk update data di tabel penjualan
		$query = "UPDATE tbl_penjualan SET  tanggal      = ?,
											pelanggan    = ?,
											pulsa        = ?,
											jumlah_bayar = ?
									  WHERE id_penjualan = ?";
		// membuat prepared statements
		$stmt = $mysqli->prepare($query);
		// hubungkan "data" dengan prepared statements
		$stmt->bind_param("siiii", $tanggal, $pelanggan, $pulsa, $jumlah_bayar, $id_penjualan);
		
		// ambil data hasil post dari ajax
		$id_penjualan = trim($_POST['id_penjualan']);
		$tanggal      = trim(date('Y-m-d', strtotime($_POST['tanggal'])));
		$pelanggan    = trim($_POST['id_pelanggan']);
		$pulsa		  = trim($_POST['id_pulsa']);
		$jumlah_bayar = trim($_POST['harga']);
		
		// jalankan query: execute
		$stmt->execute();
		
		// cek query
		if ($stmt) {
			// jika berhasil tampilkan pesan berhasil ubah data
			echo "sukses";
			} else {
				// jika gagal tampilkan pesan gagal ubah data
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