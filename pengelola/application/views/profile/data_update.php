<div class="row" style="padding: 20px;">
	<div class="col-md-12">
		<h4>Update Profile Detail</h4>
	</div>
	<div class="col-md-12">
		<form id="update_data">
			<div class="form-group col-md-12">
				<label for="nama">Nama</label>
				<input type="text" name="nama" id="nama" class="form-control" required="">
				<input type="hidden" name="id_profile" id="id_profile" value="<?=$id?>" >
			</div>
			<div class="form-group col-md-6">
				<label for="struktur">Struktur Organisasi</label>
				<select class="form-control" id="struktur" name="struktur" required=""></select>
			</div>
			<div class="form-group col-md-6">
				<label for="jabatan">Jabatan</label>
				<select class="form-control" id="jabatan" name="jabatan" required=""></select>
			</div>
			<div class="form-group col-md-6" id="fiel_keterangan" style="display: none;">
				<label for="keterangan">Keteranan</label>
				<input type="text" name="keterangan" id="keterangan" class="form-control">
			</div>
			<div class="form-group col-md-12">
				<button class="btn btn-success btn-md">Simpan</button>
				<button type="button" class="btn btn-warning btn-md" data-dismiss="modal">Batal</button>
			</div>
		</form>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		get_opt_struktur();
	})

	function get_opt_struktur() {
		$.ajax({
			url:getUri(app_struktur,'get_struktur'),
			type:"post",
			dataType:"json",
			success:function(data) {
				var list = "<option>- Pilih Struktur -</option>";
				for (var i = 0; i < data.length; i++) {
					var nama = data[i]['nama_struktur'];
					var nama_seo = data[i]['nama_seo'];
					var id = data[i]['id'];
						list += '<option value="'+id+'"> '+nama+'</option>';
				}
				$('#struktur').html(list);
			},
			complete:getJabatan,
		})
	}

	function getJabatan() {
		$.ajax({
			url:getUri(app_struktur,'get_jabatan'),
			type:"post",
			dataType:"json",
			success:function(data) {
				var list = "<option>- Pilih Jabatan -</option>";
				for (var i = 0; i < data.length; i++) {
					var nama = data[i]['nama_jabatan'];
					var id = data[i]['id'];
						list += '<option value="'+id+'"> '+nama+'</option>';
				}
				$('#jabatan').html(list);
			},
			complete:get_detail_profile,
		})
	}

	function get_detail_profile() {
		$.ajax({
			url:getUri(app_struktur,'get_detail_profile'),
			type:"post",
			dataType:"json",
			data:{id:$('#id_profile').val()},
			success:function(data) {
				$('#nama').val(data.nama);
				$('#jabatan').val(data.jabatan);
				$('#struktur').val(data.struktur);
				$('#keterangan').val(data.keterangan);
			}
		})
	}

	$('#jabatan').change(function() {
		if(parseInt($(this).val()) == 3){
			$('#fiel_keterangan').slideDown(200);
		}else{
			$('#fiel_keterangan').slideUp(200);
		}
	})

	$('#update_data').submit(function() {
		var nama = $('#nama').val();
		var jabatan = $('#jabatan').val();
		var struktur = $('#struktur').val();
		var keterangan = $('#keterangan').val();
		var id_profile = $('#id_profile').val();

		var data = {nama:nama,keterangan:keterangan,jabatan:jabatan,struktur:struktur,id_profile:id_profile};
		$.ajax({
			url:getUri(app_struktur,"update_data"),
			type:"post",
			dataType:"json",
			data:data,
			beforSend:function() {
				swal({   
                    title: "Mohon Tunggu!",   
                    text: "Sedang Memprosess.",   
                    imageUrl: getUri("assets","images/loading.gif"), 
                    showConfirmButton:false
                });
			},
			success:function() {
				swal("BERHASIL!", "Data Berhasil diupdate.",'success');
				$('.nav-list .active').click();
				closeModal();
			},
			error:function() {
				swal("GAGAL!", "Terjadi Kesalahan.\nSilahkan Coba Lagi.",'error');
			}
		})
		return false;
	})
</script>