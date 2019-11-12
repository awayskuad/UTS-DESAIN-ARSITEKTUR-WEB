<?php
// Mengecek AJAX Request
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' )) {
	// panggil file config.php untuk koneksi ke database
	require_once "../../config/config.php";
	// mengecek data get dari ajax
	if (isset($_GET['tgl_awal'])) {
		// variabel untuk nomor urut tabel
		$no = 1;
		// variabel untuk total bayar
		$total = 0;
		// sql statement untuk menampilkan data dari tabel penjualan berdasarkan tanggal
		$query = "SELECT a.id_penjualan,a.tanggal,a.pelanggan,a.pulsa,a.jumlah_bayar,
				 b.nama,b.no_hp,c.provider,c.nominal
				 FROM tbl_penjualan as a INNER JOIN tbl_pelanggan as b INNER JOIN tbl_pulsa as c
				 ON a.pelanggan=b.id_pelanggan AND a.pulsa=c.id_pulsa
				 WHERE a.tanggal BETWEEN ? AND ? ORDER BY a.id_penjualan ASC";
		// membuat prepared statements
		$stmt = $mysqli->prepare($query);
		// cek query
		if (!$stmt) {
			die('Query Error: '.$mysqli->errno.'-'.$mysqli->error);
		}
		
		// ambil data get dari ajax
		$tgl_awal = date('Y-m-d', strtotime($_GET['tgl_awal']));
		$tgl_akhir = date('Y-m-d', strtotime($_GET['tgl_akhir']));
		// hubungkan "data" dengan prepared statements
		$stmt->bind_param("ss", $tgl_awal, $tgl_akhir);
		// jalankan query: execute
		$stmt->execute();
		// ambil hasil query
		$result = $stmt->get_result();
		// tampilkan hasil query
		while ($data = $result->fetch_assoc()) {
			echo "<tr>
					<td width='30' class='center'>".$no."</td>
					<td width='90' class='center'>".date('d-m-Y', strtotime($data['tanggal']))."</td>
					<td width='170'>".$data['nama']."</td>
					<td width='90' class='center'>".$data['no_hp']."</td>
					<td width='170'>".$data['provider']." - ".number_format($data['nominal'])."</td>
					<td width='100' class='right'>Rp.".number_format($data['jumlah_bayar'])."</td>
				</tr>";
			$no++;
			$total += $data['jumlah_bayar'];
		};
		echo "<tr>
				<td class='center' colspan='5'><strong>Total</strong></td>
				<td class='right'><strong>Rp.".number_format($total)."</strong></td>
			</tr>";
			
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