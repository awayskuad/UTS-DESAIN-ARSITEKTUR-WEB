<?php
// Mengecek AJAX Request
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' )) {
	// panggil file config.php untuk koneksi ke database
	require_once "../../config/config.php";
	
	// mengecek data post dari ajax
	if (isset($_POST['id_pelanggan'])) {
		// sql statement untuk update data di tabel pelanggan
		$query = "UPDATE tbl_pelanggan SET nama			= ?,
										   no_hp		= ?
									 WHERE id_pelanggan = ?";
		
		// membuat prepared statements
		$stmt = $mysqli->prepare($query);
		// hubungkan "data" dengan prepared statements
		$stmt->bind_param("ssi", $nama, $no_hp, $id_pelanggan);
		
		// ambil data hasil post dari ajax
		$id_pelanggan 	= trim($_POST['id_pelanggan']);
		$nama			= trim($_POST['nama']);
		$no_hp			= trim($_POST['no_hp']);
		
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