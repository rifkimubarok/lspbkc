<div class="row">
	<div class="col-sm-12">
        <ol class="breadcrumb pull-right">
            <li><a href="#">Dashboard</a></li>
            <li class="active">Data Pengurus DPD</li>
        </ol>
    </div>
</div>

<div class="row">
	<div class="col-md-12 bx-shadow mini-stat">
		<div class="form-group col-md-3">
			<select class="form-control" id="provinsi_opt">
			</select>
		</div>
		<div class="form-group col-md-7 pull-right">
			<button class="btn btn-primary pull-right tambah-data"><i class="fa fa-plus"></i> Tambah Data</button>
		</div>
		<table class="table table-striped" id="table-anggota" style="width: 100%;">
			<thead>
				<tr>
					<th width="5%">No</th>
					<th width="15%">No. KTA</th>
					<th width="30%">Nama Lengkap</th>
					<th width="15%">Jabatan</th>
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
                <h4 class="modal-title" id="myLargeModalLabel">Data Pengurus DPD</h4>
            </div>
            <div class="modal-body">
              <form id="frm_registrasi">
					<div class="row">
							<div class="form-group col-md-4">
								<label for="nama">No KTA <span style="color: red" title="Wajib diisi">*</span></label>
								<input type="text" name="no_kta" id="no_kta" required="" class="form-control">
							</div>
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
								<label for="jk">Jabatan <span style="color: red" title="Wajib diisi">*</span></label>
								<select class="form-control" id="id_jabatan" name="id_jabatan" required="">
								</select>
							</div>
							<div class="form-group col-md-4">
								<label for="jk">Provinsi <span style="color: red" title="Wajib diisi">*</span></label>
								<select class="form-control" id="kode_prov" name="kode_prov" required="">
								</select>
							</div>
							<div class="form-group col-md-12">
								<label for="alamat">Alamat</label>
								<textarea class="form-control" id="alamat" name="alamat">
									
								</textarea>
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
	get_ref_jabatan();
	get_refprovinsi();
	/*$('#table-anggota').dataTable({
		order:[]
	});*/
	/*$('#asal_krn').change(function() {
		$('#asal_text_krn').val($('#asal_krn option:selected').text());
	})
	$('#penugasan_krn').change(function() {
		$('#penugasan_text_krn').val($('#penugasan_krn option:selected').text());
	})*/
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
			url:getUri(app_data,"get_data_anggota_dpd"),
			type:"post",
			dataType:"JSON",
			data:{id_anggota:id},
			beforeSend:function() {
				elemen.html("<i class='fa fa-spinner fa-spin'></i>");
			},
			success:function(result) {
				$('#id').val(result.id);
				$('#no_kta').val(result.no_kta);
				$('#nama').val(result.nama);
				$('#jk').val(result.jk);
				$('#id_jabatan').val(result.id_jabatan);
				$('#alamat').val(result.alamat);
				$('#keterangan').val(result.keterangan);
				$('#kode_prov').val(result.kode_prov);
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
   					var isi = result[i]['kode'];
   					var text = result[i]['name'];
   					option += "<option value='"+isi+"'> "+text+" </option>";
   				}
   				$('#kode_prov').html(option);
   				$('#provinsi_opt').html(option);

   			},
   			complete:function() {
   				$('#asal_text_krn').val($('#asal_krn option:selected').text());
   				$('#penugasan_text_krn').val($('#penugasan_krn option:selected').text());
   				get_anggota();
   			},
   			error:function() {
   				alert("gagal");
   			}
   		});
   	}


   	$('#frm_registrasi').submit(function() {
   		status = $('#statusSave').val();
   		url = status == 1 ? getUri(app_data,"update_anggota_dpd") : getUri(app_data,"save_anggota_dpd");
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

   	$('#provinsi_opt').change(function() {
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
	            "url": getUri(app_data,'get_member_dpd'),
	            "type": "POST",
	            data:function(data) {
	            	data.provinsi = get_provinsi_opt();
	            },      
	        }
		});
	}

	function get_ref_jabatan() {
   		$.ajax({
   			url:getUri(app_data,"get_ref_jabatan"),
   			type:"post",
   			dataType:"JSON",
   			success:function(result) {
   				var option ="<option value='' selected>- Pilih Jabatan -</option>";
   				for(var i = 0; i < result.length;i++){
   					var text = result[i]['nama_jabatan'];
   					var id = result[i]['id'];
   					option += "<option value='"+id+"'> "+text+" </option>";
   				}
   				$('#id_jabatan').html(option);

   			},
   			complete:function() {
   			},
   			error:function() {
   				alert("gagal");
   			}
   		});
   	}

   	function get_provinsi_opt() {
   		return $('#provinsi_opt').val();
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
              url:getUri(app_data,'delete_anggota_dpd'),
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