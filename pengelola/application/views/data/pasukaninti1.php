<div class="row">
	<div class="col-sm-12">
        <ol class="breadcrumb pull-right">
            <li><a href="#">Dashboard</a></li>
            <li class="active">Data Pasukan Inti</li>
        </ol>
    </div>
</div>

<div class="row">
	<div class="col-md-12 bx-shadow mini-stat">
		<!-- <div class="form-group col-md-3">
			<select class="form-control" id="status_krn_opt">
			</select>
		</div> -->
		<div class="form-group col-md-7 pull-right">
			<button class="btn btn-primary pull-right tambah-data"><i class="fa fa-plus"></i> Tambah Data</button>
		</div>
		<table class="table table-striped" id="table-anggota" style="width: 100%;">
			<thead>
				<tr>
					<th width="5%">No</th>
					<th width="25%">Nama</th>
					<th width="10%">JK</th>
					<th width="15%">Daerah Asal KRN</th>
					<th width="15%">Daerah Tugas KRN</th>
					<th width="20%">Status KRN</th>
					<th width="10%">#</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>
</div>

<div class="modal fade modal_anggota" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myLargeModalLabel">Data Pasukan Inti/Pendamping</h4>
            </div>
            <div class="modal-body">
              <form id="frm_registrasi">
					<div class="row">
							<div class="form-group col-md-8">
								<label for="nama">Nama Lengkap <span style="color: red" title="Wajib diisi">*</span></label>
								<input type="text" name="nama" id="nama" required="" class="form-control">
								<input type="hidden" name="id" id="id">
							</div>
							<div class="form-group col-md-4">
								<label for="jk">Jenis Kelamin <span style="color: red" title="Wajib diisi">*</span></label>
								<select class="form-control" id="jk" name="jk" required="">
									<option value="L">Laki-laki</option>
									<option value="P">Perempuan</option>
								</select>
							</div>
							<div class="form-group col-md-4">
								<label for="tempat_lahir">Tempat Lahir <span style="color: red" title="Wajib diisi">*</span></label>
								<input type="text" name="tempat_lahir" id="tempat_lahir" required="" class="form-control">
							</div>
							<div class="form-group col-md-4">
								<label for="tgl_lahir">Tanggal Lahir <span style="color: red" title="Wajib diisi">*</span></label>
								<input type="date" name="tgl_lahir" id="tgl_lahir" required="" class="form-control">
							</div>
							<div class="form-group col-md-4">
								<label for="no_hp">Nomor HP <span style="color: red" title="Wajib diisi">*</span></label>
								<input type="text" name="no_hp" id="no_hp" required="" class="form-control">
							</div>
							<div class="form-group col-md-6">
								<label for="email">Alamat Email </label>
								<input type="email" name="email" id="email" class="form-control">
							</div>

							<div class="form-group col-md-6">
								<label for="alamat">Alamat <span style="color: red" title="Wajib diisi">*</span></label>
								<textarea name="alamat" id="alamat" required="" class="form-control"></textarea>
							</div>

							<div class="form-group col-md-4">
								<label for="asal_krn">Daerah Asal KRN <span style="color: red" title="Wajib diisi">*</span></label>
								<select name="asal_krn" id="asal_krn" required="" class="form-control">
								</select>
								<input type="hidden" name="asal_text_krn" id="asal_text_krn">
							</div>
							<div class="form-group col-md-4">
								<label for="penugasan_krn">Daerah Penugasan KRN <span style="color: red" title="Wajib diisi">*</span></label>
								<select name="penugasan_krn" id="penugasan_krn" required="" class="form-control">
								</select>
								<input type="hidden" name="penugasan_text_krn" id="penugasan_text_krn">
							</div>
							<div class="form-group col-md-4">
								<label for="status_krn">Tahun KRN <span style="color: red" title="Wajib diisi">*</span></label>
								<input type="text" name="tahun_krn" id="tahun_krn" required="" class="form-control">
							</div>
							<div class="form-group col-md-12">
								<label for="saran">Saran </label>
								<textarea name="saran" id="saran" class="form-control" rows="4"></textarea>
							</div>
							<div class="form-group col-md-6">
								<input type="hidden" name="statusSave" id="statusSave">
								<button class="btn btn-primary btn-md" type="submit" id="savebutton">Update Data</button>
								<button class="btn btn-warning btn-md" data-dismiss="modal" aria-hidden="true">Cancel</button>
							</div>
					</div>
			  </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<script type="text/javascript">
	var app_data = "data";
	var app_dpd = 'dpd';
	var app_registrasi = 'registrasi';
	get_refprovinsi();
	get_ref_status();
	get_anggota();
	/*$('#table-anggota').dataTable({
		order:[]
	});*/
	$('#asal_krn').change(function() {
		$('#asal_text_krn').val($('#asal_krn option:selected').text());
	})
	$('#penugasan_krn').change(function() {
		$('#penugasan_text_krn').val($('#penugasan_krn option:selected').text());
	})
	$('#no_hp').inputmask({mask:'+62899999999999 ', placeholder: ''});
	$('#tahun_krn').inputmask({mask:'9999', placeholder: ''});

	$('.tambah-data').click(function() {
		clear_form();
		$('.modal_anggota').modal({backdrop: 'static', keyboard: false});
		$('#savebutton').text("Simpan Data");
		$('#statusSave').val(0);
	})

	function edit_data(item) {
		var id = $(item).attr("data-value");
		var elemen = $(item);

		$.ajax({
			url:getUri(app_data,"get_data_anggota_inti"),
			type:"post",
			dataType:"JSON",
			data:{id_anggota:id},
			beforeSend:function() {
				elemen.html("<i class='fa fa-spinner fa-spin'></i>");
			},
			success:function(result) {
				$('#id').val(result.id);
				$('#nama').val(result.nama);
				$('#jk').val(result.jk);
				$('#tempat_lahir').val(result.tempat_lahir);
				$('#tgl_lahir').val(result.tgl_lahir);
				$('#alamat').val(result.alamat);
				$('#no_hp').val(result.no_hp);
				$('#email').val(result.email);
				$('#saran').val(result.saran);
				$('#asal_krn').val(result.asal_krn);
				$('#asal_text_krn').val(result.asal_text_krn);
				$('#tahun_krn').val(result.tahun_krn);
				$('#penugasan_krn').val(result.penugasan_krn);
				$('#penugasan_text_krn').val(result.penugasan_text_krn);
				$('#statusSave').val(1);
				$('#savebutton').text("Update Data");
				$('.modal_anggota').modal({backdrop: 'static', keyboard: false});
				elemen.html("<i class='fa fa-pencil'></i>");
			},
			error:function() {
				gagal_screen();
				elemen.html("<i class='fa fa-pencil'></i>");
			}
		})
	}

	function get_refprovinsi() {
   		$.ajax({
   			url:getUriOrigin(app_dpd,"ref_provinsi"),
   			type:"post",
   			dataType:"JSON",
   			success:function(result) {
   				var option ='';
   				for(var i = 0; i<result.length;i++){
   					var isi = result[i]['id'];
   					var text = result[i]['name'];
   					option += "<option value='"+isi+"'> "+text+" </option>";
   				}
   				$('#asal_krn').html(option);
   				$('#penugasan_krn').html(option);

   			},
   			complete:function() {
   				$('#asal_text_krn').val($('#asal_krn option:selected').text());
   				$('#penugasan_text_krn').val($('#penugasan_krn option:selected').text());
   			},
   			error:function() {
   				alert("gagal");
   			}
   		});
   	}


	function get_ref_status() {
   		$.ajax({
   			url:getUriOrigin(app_registrasi,"ref_status"),
   			type:"post",
   			dataType:"JSON",
   			success:function(result) {
   				var option ='';
   				var option2 = '<option value="">- Semua Pasukan -</option>';
   				for(var i = 0; i<result.length;i++){
   					var isi = result[i]['id'];
   					var text = result[i]['status'];
   					option += "<option value='"+isi+"'> "+text+" </option>";
   					option2 += "<option value='"+isi+"'> "+text+" </option>";
   				}
   				$('#status_krn').html(option);
   				$('#status_krn_opt').html(option2);

   			},
   			complete:function() {
   			},
   			error:function() {
   				alert("gagal");
   			}
   		});
   	}

   	$('#frm_registrasi').submit(function() {
   		status = $('#statusSave').val();
   		url = status == 1 ? getUri(app_data,"update_anggota_inti") : getUri(app_data,"save_anggota_inti");
   		$.ajax({
   			url:url,
   			type:"post",
   			dataType:"JSON",
   			data:$('#frm_registrasi').serialize(),
   			beforeSend:loading_screen,
   			success:function(result) {
   				if(result.status){
   					swal("Berhasil!","Data Berhasil disimpan.","success");
   					$('.modal_anggota').modal("hide");
   					refresh_table();
   					get_angkatan();
   				}else{
   					gagal_screen();
   				}
   			},
   			complete:function() {
   			},
   			error:function() {
   				gagal_screen();
   			}
   		});
   		return false;
   	});

   	$('#status_krn_opt').change(function() {
		refresh_table();
	});
	
	function get_anggota() {
		$('#table-anggota').dataTable({
			"processing": true,
	        "serverSide": true,
	        "scrollY":"200px",
	        "scrollCollapse": true,
	        paging: true,
	        responsive: true,
	        "order": [],
	        "ajax": {
	            "url": getUri(app_data,'get_member_inti'),
	            "type": "POST",
	            data:function(data) {
	            	data.status_krn = get_status();
	            },      
	        }
		});
	}

   	function get_status() {
   		return $('#status_krn_opt').val();
   	}

   	function refresh_table() {
   		var table = $('#table-anggota').dataTable();
   		table.api().ajax.reload();
   	}

   	function hapus_data(item) {
   		var nama = $(item).attr("data-nama");
   		var id = $(item).attr("data-value");
   		swal({   
            title: "Anda Yakin?",   
            text: "Data  "+nama+" akan segera dihapus.",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "Ya!",  
            cancelButtonText:"Tidak",
            closeOnConfirm: false, 
      		showLoaderOnConfirm: true,
        }, function(data) {
          if (data) {
            $.ajax({
              url:getUri(app_data,'delete_anggota_inti'),
              type:"post",
              data:{id_anggota:id},
              dataType:"JSON",
              beforeSend:function() {
                loading_screen();
              },
              success:function(result) {
                swal("BERHASIL!", "Data "+nama+" Berhasil dihapus.",'success');
                refresh_table();
              },
              error:function() {
                gagal_screen();
              }
            });
          }
        });
   	}

   	function clear_form(argument) {
   		document.getElementById("frm_registrasi").reset();
   	}
</script>