<?php
// Mengecek AJAX Request
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' )) {
	// panggil file config.php untuk koneksi ke database
	require_once "../../config/config.php";
	
	// sql statement untuk insert data ke tabel pelanggan
	$query = "INSERT INTO tbl_pelanggan(nama, no_hp) VALUES (?,?)";
	// membuat prepared statements
	$stmt = $mysqli->prepare($query);
	// hubungkan data dengan prepared statements
	$stmt->bind_param("ss", $nama, $no_hp);
	
	// ambil data hasil post dari ajax
	$nama = trim($_POST['nama']);
	$no_hp = trim($_POST['no_hp']);
	
	// jalankan query: execute
	$stmt->execute();
	
	// cek query
	if ($stmt) {
		// jika berhasil tampilkan pesan berhasil simpan data
		echo "sukses";
	} else {
		// jika gagal tampilkan pesan gagal simpan data
		echo "gagal";
	}
	
	// tutup statement
	$stmt->close();
	// tutup koneksi
	$mysqli->close();
} else {
	// jika tidak ada ajax request, maka alihkan ke halaman index.php
	echo '<script>window.location="../../index.php"</script>';
}
?>