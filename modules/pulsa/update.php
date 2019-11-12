<?php
// Mengecek AJAX Request
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' )) {
	// panggil file config.php untuk koneksi ke database
	require_once "../../config/config.php";

	// mengecek data post dari ajax
	if (isset($_POST['id_pulsa'])) {
		// sql statement untuk update data di tabel pulsa
		$query = "UPDATE tbl_pulsa SET provider = ?,
							   nominal = ?,
							   harga = ?
						 WHERE id_pulsa = ?";
		// membuat prepared statements
		$stmt = $mysqli->prepare($query);
		// hubungkan "data" dengan prepared statements
		$stmt->bind_param("siii", $provider, $nominal, $harga, $id_pulsa);

		// ambil data hasil post dari ajax
		$id_pulsa = trim($_POST['id_pulsa']);
		$provider = trim($_POST['provider']);
		$nominal = trim($_POST['nominal']);
		$harga = trim($_POST['harga']);

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