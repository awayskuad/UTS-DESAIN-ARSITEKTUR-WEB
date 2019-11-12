<div class="content-header row mb-3">
	<div class="col-md-12">
		<h5>
			<!-- judul halaman laporan penjualan -->
			<i class="fas fa-file-alt title-icon"></i> Laporan Penjualan
		</h5>
	</div>
</div>

<div class="border mb-4"></div>

<div class="row">
	<div class="col-md-12">
		<!-- form filter data penjualan -->
		<form id="formFilter" action="modules/laporan/export.php" method="get">
			<div class="row">
				<div class="col">
					<div class="form-group mb-0">
						<label>Filter : </label>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col">
					<div class="form-group">
						<input type="text" class="form-control date-picker" data-date-format="dd-mm-yyyy"id="tgl_awal" name="tgl_awal" placeholder="Tanggal Awal" autocomplete="off" required>
					</div>
				</div>
				
				<div class="col">
					<div class="form-group">
						<input type="text" class="form-control date-picker" data-date-format="dd-mm-yyyy"id="tgl_akhir" name="tgl_akhir" placeholder="Tanggal Akhir" autocomplete="off" required>
					</div>
				</div>
				
				<div class="col">
					<div class="form-group">
						<button type="button" class="btn btn-info btn-submit" id="btnTampil">Tampilkan</button>
					</div>
				</div>
				
				<div class="col">
					<div class="form-group right">
						<!-- tombol export data ke excel -->
						<button type="submit" class="btn btn-success mb-3" id="btnExport">
							<i class="fas fa-file-excel title-icon"></i> Export ke Excel
						</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

<div class="border mt-2 mb-4"></div>

<div class="row">
	<div id="tabelLaporan" class="col-md-12">
		<!-- Tabel untuk menampilkan laporan data penjualan dari database -->
		<table class="table table-striped table-bordered" style="width:100%">
			<!-- judul kolom pada bagian kepala (atas) tabel -->
			<thead>
				<tr>
					<th class="center">No.</th>
					<th class="center">Tanggal</th>
					<th class="center">Nama Pelanggan</th>
					<th class="center">No. HP</th>
					<th class="center">Pulsa</th>
					<th class="center">Jumlah Bayar</th>
				</tr>
			</thead>
			<!-- parameter untuk memuat isi tabel -->
			<tbody id="loadData"></tbody>
		</table>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function(){
	// datepicker plugin
	$('.date-picker').datepicker({
		autoclose: true,
		todayHighlight: true
	});
	
	// menyembunyikan tabel laporan
	$('#tabelLaporan').hide();
	// menyembunyikan tombol export
	$('#btnExport').hide();
	
	// Tampilkan tabel laporan data penjualan
	$('#btnTampil').click(function(){
		// Validasi form input
		// jika tanggal awal kosong
		if ($('#tgl_awal').val()==""){
			// focus ke input tanggal awal
			$( "#tgl_awal" ).focus();
			// tampilkan peringatan data tidak boleh kosong
			swal("Peringatan!", "Tanggal awal tidak boleh kosong.", "warning");
		}
		// jika tanggal akhir kosong
		else if ($('#tgl_akhir').val()==""){
			// focus ke input tanggal akhir
			$( "#tgl_akhir" ).focus();
			// tampilkan peringatan data tidak boleh kosong
			swal("Peringatan!", "Tanggal akhir tidak boleh kosong.", "warning");
		// jika semua tanggal sudah diisi, jalankan perintah untuk menampilkan data
		} else {
			// membuat variabel untuk menampung data dari form filter
			var data = $('#formFilter').serialize();
			
			$.ajax({
				type : "GET",							// mengirim data dengan method GET
				url : "modules/laporan/get_data.php",	// proses get data penjualan berdasarkan tanggal
				data : data,							// data yang dikirim
				success: function(data){				// ketika sukses get data
					// menampilkan tabel laporan
					$('#tabelLaporan').show();
					// menampilkan data penjualan
					$('#loadData').html(data);
					// menampilkan tombol export
					$('#btnExport').show()
				}
			});
		}
	});
	
	// saat tombol export diklik
	$('#btnExport').click(function(){
		// tampilkan pesan sukses export data
		swal("Sukses!", "Laporan Data Penjualan berhasil diexport.", "success");
	});
});
</script>