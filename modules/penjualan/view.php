<div class="content-header row mb-3">
	<div class="col-md-12">
		<h5>
			<!-- judul halaman tampil data penjualan -->
			<i class="fas fa-shopping-cart title-icon"></i> Data Penjualan
			<!-- tombol tambah data penjualan -->
			<a class="btn btn-info float-right" id="btnTambah" href="javascript:void(0);" data-toggle="modal"data-target="#modalPenjualan" role="button"><i class="fas fa-plus"></i> Tambah </a>
		</h5>
	</div>
</div>

<div class="border mb-4"></div>

<div class="row">
	<div class="col-md-12">
		<!-- Tabel penjualan untuk menampilkan data penjualan dari database -->
		<table id="tabel-penjualan" class="table table-striped table-bordered" style="width:100%">
			<!-- judul kolom pada bagian kepala (atas) tabel -->
			<thead>
				<tr>
					<th>No.</th>
					<th>ID Penjualan</th>	 	<!-- kolom disembunyikan -->
					<th>Tanggal</th>
					<th>ID Pelanggan</th>		<!-- kolom disembunyikan -->
					<th>Nama Pelanggan</th>
					<th>No. HP</th>
					<th>ID Pulsa</th>			<!-- kolom disembunyikan -->
					<th>Pulsa</th>
					<th>Nominal</th>			<!-- kolom disembunyikan, digabung dengan kolom Pulsa -->
					<th>Jumlah Bayar</th>
					<th></th>
				</tr>
			</thead>
		</table>
	</div>
</div>

<!-- Modal form data penjualan -->
<div class="modal fade" id="modalPenjualan" tabindex="-1" role="dialog" aria-labelledby="modalPenjualan"aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<!-- judul form data penjualan -->
			<div class="modal-header">
				<h5 class="modal-title"><i class="fas fa-edit title-icon"></i><span id="modalLabel"></span></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<!-- isi form data penjualan -->
			<form id="formPenjualan">
				<div class="modal-body">
					<input type="hidden" id="id_penjualan" name="id_penjualan">

					<div class="form-group">
						<label>Tanggal</label>
						<input type="text" class="form-control date-picker" data-date-format="dd-mm-yyyy" id="tanggal"name="tanggal" value="<?php echo date("d-m-Y"); ?>" autocomplete="off">
					</div>
					
					<div class="form-group">
						<label>No. HP</label>
						<select class="chosen-select" id="id_pelanggan" name="id_pelanggan" onchange="get_pelanggan()"autocomplete="off">
							<option value="0">-- Pilih --</option>
							<?php
							// panggil file config.php untuk koneksi ke database
							require_once "../../config/config.php";
							// sql statement untuk menampilkan data no_hp dari tabel pelanggan
							$query = "SELECT id_pelanggan, no_hp FROM tbl_pelanggan ORDER BY no_hp ASC";
							// membuat prepared statements
							$stmt = $mysqli->prepare($query);
							//cek query
							if (!$stmt) {
							die('Query Error: '.$mysqli->errno.'-'.$mysqli->error);
							}
							// jalankan query: execute
							$stmt->execute();
							// ambil hasil query
							$result = $stmt->get_result();
							// tampilkan data
							while ($data_pelanggan = $result->fetch_assoc()) {
							echo"<option value='$data_pelanggan[id_pelanggan]'> $data_pelanggan[no_hp] </option>";
							}
							// tutup statement
							$stmt->close();
							?>
						</select>
					</div>
					<div class="form-group">
						<label>Nama Pelanggan</label>
						<input type="text" class="form-control" id="nama" name="nama" readonly>
					</div>

					<div class="form-group">
						<label>Pulsa</label>
						<select class="chosen-select" id="id_pulsa" name="id_pulsa" onchange="get_pulsa()"autocomplete="off">
							<option value="0">-- Pilih --</option>
							<?php
							// sql statement untuk menampilkan data no_hp dari tabel pelanggan
							$query = "SELECT id_pulsa, provider, nominal FROM tbl_pulsa ORDER BY provider ASC, nominal ASC";
							// membuat prepared statements
							$stmt = $mysqli->prepare($query);
							// cek query
							if (!$stmt) {
							die('Query Error: '.$mysqli->errno.'-'.$mysqli->error);
							}
							// jalankan query: execute
							$stmt->execute();
							// ambil hasil query
							$result = $stmt->get_result();
							// tampilkan data
							while ($data_pulsa = $result->fetch_assoc()) {
							echo"<option value='$data_pulsa[id_pulsa]'> $data_pulsa[provider] – ".number_format($data_pulsa['nominal'])." </option>";
							}
							// tutup statement
							$stmt->close();
							// tutup koneksi
							$mysqli->close();
							?>
						</select>
					</div>
					
					<div class="form-group">
						<label>Harga</label>
						<div class="input-group mb-2">
							<div class="input-group-prepend"><div class="input-group-text">Rp.</div></div>
							<input type="text" class="form-control" id="harga" name="harga" readonly>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-info btn-submit" id="btnSimpan">Simpan</button>
					<button type="button" class="btn btn-secondary btn-reset" data-dismiss="modal">Batal</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
// fungsi untuk menampilkan data pelanggan dari select box ke textfield
function get_pelanggan(){
	// membuat variabel untuk menampung id_pelanggan
	var id_pelanggan = $('#id_pelanggan').val();

	$.ajax({
		type : "GET", // mengirim data dengan method GET
		url : "modules/penjualan/get_pelanggan.php", // proses get data pelanggan berdasarkan id_penjualan
		data : {id_pelanggan:id_pelanggan}, // data yang dikirim
		dataType : "JSON", // tipe data JSON
		success: function(result){ // ketika sukses get data
		// tampilkan data
		$("#nama").val(result.nama);
	}
  });
}

// fungsi untuk menampilkan data pulsa dari select box ke textfield
function get_pulsa(){
	// membuat variabel untuk menampung id_pulsa
	var id_pulsa = $('#id_pulsa').val();

	$.ajax({
		type : "GET", // mengirim data dengan method GET
		url : "modules/penjualan/get_pulsa.php", // proses get data pelanggan berdasarkan id_penjualan
		data : {id_pulsa:id_pulsa}, // data yang dikirim
		dataType : "JSON", // tipe data JSON
		success: function(result){ // ketika sukses get data
		// tampilkan data
		$("#harga").val(result.harga);
	}
  });
}

$(document).ready(function(){
	// datepicker plugin
	$('.date-picker').datepicker({
		autoclose: true,
		todayHighlight: true
	});

	// chosen-select plugin
	$('.chosen-select').chosen();
	// ============================================ View =============================================
	// dataTables plugin untuk membuat nomor urut tabel
	$.fn.dataTableExt.oApi.fnPagingInfo = function (oSettings)
	{
		return {
			"iStart": oSettings._iDisplayStart,
			"iEnd": oSettings.fnDisplayEnd(),
			"iLength": oSettings._iDisplayLength,
			"iTotal": oSettings.fnRecordsTotal(),
			"iFilteredTotal": oSettings.fnRecordsDisplay(),
			"iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
			"iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
		};
	};
	
	// datatables serverside processing
	var table = $('#tabel-penjualan').DataTable( {
		"scrollY": '45vh', // vertikal scroll pada tabel
		"scrollCollapse": true,
		"processing": true, // tampilkan loading saat proses data
		"serverSide": true, // server-side processing
		"ajax": 'modules/penjualan/data.php', // panggil file data.php untuk menampilkan data penjualan dari database
		// menampilkan data
		"columnDefs": [
			{ "targets": 0, "data": null, "orderable": false, "searchable": false, "width": '30px', "className":'center' },
			{ "targets": 1, "visible": false }, // kolom disembunyikan
			{ "targets": 2, "width": '70px', "className": 'center' },
			{ "targets": 3, "visible": false }, // kolom disembunyikan
			{ "targets": 4, "width": '150px', },
			{ "targets": 5, "width": '100px', "className": 'center' },
			{ "targets": 6, "visible": false }, // kolom disembunyikan
			{
				"targets": 7, "width": '170px',
				"render": function ( data, type, row ) {
					return data +' - '+ row[ 8 ]+'';
				}
			},
			{ "targets": 8, "visible": false }, // kolom disembunyikan, digabung dengan kolom Pulsa
			{ "targets": 9, "width": '100px', "className": 'right' },
			{
				"targets": 10, "data": null, "orderable": false, "searchable": false, "width": '60px', "className":'center',
				// tombol ubah dan hapus
				"render": function(data, type, row) {
				var btn = "<a style=\"margin-right:7px\" title=\"Ubah\" class=\"btn btn-info btn-sm getUbah\"href=\"javascript:void(0);\"><i class=\"fas fa-edit\"></i></a><a title=\"Hapus\"class=\"btn btn-danger btn-sm btnHapus\" href=\"javascript:void(0);\"><i class=\"fas fa-trash\"></i></a>";
				return btn;
			}
		}
	],
	"order": [[ 1, "desc" ]], // urutkan data berdasarkan id_penjualan secara descending
	"iDisplayLength": 10, // tampilkan 10 data per halaman
	// membuat nomor urut tabel
	"rowCallback": function (row, data, iDisplayIndex) {
		var info = this.fnPagingInfo();
		var page = info.iPage;
		var length = info.iLength;
		var index = page * length + (iDisplayIndex + 1);
		$('td:eq(0)', row).html(index);
	}
} );
// ===============================================================================================

// ============================================ Form =============================================
// Tampilkan Modal Form Tambah Data
$('#btnTambah').click(function(){
	// reset form
	$('#formPenjualan')[0].reset();
	$('#id_pelanggan').val('').trigger('chosen:updated');
	$('#id_pulsa').val('').trigger('chosen:updated');
	// judul form
	$('#modalLabel').text('Entri Data Penjualan');
});

// Tampilkan Modal Form Ubah Data
$('#tabel-penjualan tbody').on( 'click', '.getUbah', function (){
	// judul form
	$('#modalLabel').text('Ubah Data Penjualan');

	var data = table.row( $(this).parents('tr') ).data();
	// membuat variabel untuk menampung data id_penjualan
	var id_penjualan = data[ 1 ];
	$.ajax({
		type : "GET", // mengirim data dengan method GET
		url : "modules/penjualan/get_data.php", // proses get data penjualan berdasarkan id_penjualan
		data : {id_penjualan:id_penjualan}, // data yang dikirim
		dataType : "JSON", // tipe data JSON
		success: function(result){ // ketika sukses get data
			// ubah tanggal menjadi d-m-Y
			var tgl = result.tanggal;
			var dateAr = tgl.split('-');
			var tanggal = dateAr[2] + '-' + dateAr[1] + '-' + dateAr[0];
			// tampilkan modal ubah data penjualan
			$('#modalPenjualan').modal('show');
			// tampilkan data penjualan
			$('#id_penjualan').val(result.id_penjualan);
			$('#tanggal').val(tanggal);
			$('#id_pelanggan').val(result.pelanggan).trigger('chosen:updated');
			$('#nama').val(result.nama);
			$('#id_pulsa').val(result.pulsa).trigger('chosen:updated');
			$('#harga').val(result.jumlah_bayar);
		}
	});
});
// ===============================================================================================

// Proses Simpan Data
$('#btnSimpan').click(function(){
	// Validasi form input
	// jika tanggal kosong
	if ($('#tanggal').val()==""){
		// focus ke input tanggal
		$( "#tanggal" ).focus();
		// tampilkan peringatan data tidak boleh kosong
		swal("Peringatan!", "Tanggal tidak boleh kosong.", "warning");
	}
	// jika data pelanggan kosong
	else if ($('#id_pelanggan').val()==""){
		// focus ke input data pelanggan
		$( "#id_pelanggan" ).focus();
		// tampilkan peringatan data tidak boleh kosong
		swal("Peringatan!", "Data Pelanggan tidak boleh kosong.", "warning");
	}
	// jika data pulsa kosong
	else if ($('#id_pulsa').val()==""){
		// focus ke input data pulsa
		$( "#id_pulsa" ).focus();
		// tampilkan peringatan data tidak boleh kosong
		swal("Peringatan!", "Data Pulsa tidak boleh kosong.", "warning");
	}
	// jika semua data sudah terisi, jalankan perintah simpan data
	else {
		// jika form entri data penjualan yang ditampilkan, jalankan perintah insert
		if ($('#modalLabel').text()=="Entri Data Penjualan") {
			// membuat variabel untuk menampung data dari form entri data
			var data = $('#formPenjualan').serialize();

			$.ajax({
				type : "POST", // mengirim data dengan method POST
				url : "modules/penjualan/insert.php", // proses insert data
				data : data, // data yang dikirim
				success: function(result){ // ketika sukses menyimpan data
					if (result==="sukses") {
						// reset form
						$('#formPenjualan')[0].reset();
						$('#id_pelanggan').val('').trigger('chosen:updated');
						$('#id_pulsa').val('').trigger('chosen:updated');
						// tutup modal entri data penjualan
						$('#modalPenjualan').modal('hide');
						// tampilkan pesan sukses simpan data
						swal("Sukses!", "Data Penjualan berhasil disimpan.", "success");
						// tampilkan data penjualan
						var table = $('#tabel-penjualan').DataTable();
						table.ajax.reload( null, false );
					} else {
						// tampilkan pesan gagal simpan data
						swal("Gagal!", "Data Penjualan tidak bisa disimpan.", "error");
					}
				}
			});
			return false;
		}
		// jika form ubah data penjualan yang ditampilkan, jalankan perintah update
		else if ($('#modalLabel').text()=="Ubah Data Penjualan") {
			// membuat variabel untuk menampung data dari form ubah data
			var data = $('#formPenjualan').serialize();

			$.ajax({
				type : "POST", // mengirim data dengan method POST
				url : "modules/penjualan/update.php", // proses update data
				data : data, // data yang dikirim
				success: function(result){ // ketika sukses mengubah data
					if (result==="sukses") {
						// reset form
						$('#formPenjualan')[0].reset();
						$('#id_pelanggan').val('').trigger('chosen:updated');
						$('#id_pulsa').val('').trigger('chosen:updated');
						// tutup modal ubah data penjualan
						$('#modalPenjualan').modal('hide');
						// tampilkan pesan sukses ubah data
						swal("Sukses!", "Data penjualan berhasil diubah.", "success");
						// tampilkan data penjualan
						var table = $('#tabel-penjualan').DataTable();
						table.ajax.reload( null, false );
					} else {
						// tampilkan pesan gagal ubah data
						swal("Gagal!", "Data penjualan tidak bisa diubah.", "error");
					}
				}
			});
			return false;
		}
	}
});
// ===============================================================================================

// =========================================== Delete ============================================
 $('#tabel-penjualan tbody').on( 'click', '.btnHapus', function (){
	var data = table.row( $(this).parents('tr') ).data();
		// tampilkan notifikasi saat akan menghapus data
		swal({
			title: "Apakah Anda Yakin?",
			text: "Anda akan menghapus data penjualan tanggal : "+ data[ 2 ] +" - Pelanggan : "+ data[ 4 ] +",No. HP : "+ data[ 5 ] +"",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Ya, Hapus!",
			closeOnConfirm: false
		},
		// jika dipilih ya, maka jalankan perintah hapus data
		function () {
			// membuat variabel untuk menampung data id_penjualan
			var id_penjualan = data[ 1 ];
			
			$.ajax({
				type : "POST",							// mengirim data dengan method POST
				url : "modules/penjualan/delete.php",	// proses delete data
				data : {id_penjualan:id_penjualan},		// data yang dikirim
				success: function(result){				// ketika sukses menghapus data
					if (result==="sukses") {
						// tampilkan pesan sukses hapus data
						swal("Sukses!", "Data Penjualan berhasil dihapus.", "success");
						// tampilkan data penjualan
						var table = $('#tabel-penjualan').DataTable();
						table.ajax.reload( null, false );
					} else {
						// tampilkan pesan gagal hapus hapus data
						swal("Gagal!", "Data Penjualan tidak bisa dihapus.", "error");
					}
				}
			});
		});
	});
	// ===============================================================================================
});
</script>