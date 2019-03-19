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
		<h5>Data Purna Pasma Teregistrasi</h5><br>
		<div class="row">
      <div class="form-group col-md-3">
        <select class="form-control" id="status_krn_opt">
        </select>
      </div>
    </div>
		<!-- <div class="form-group col-md-7 pull-right">
			<button class="btn btn-primary pull-right tambah-data"><i class="fa fa-plus"></i> Tambah Data</button>
		</div> -->
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
                <h4 class="modal-title" id="myLargeModalLabel">Data Pasukan Utama</h4>
            </div>
            <div class="modal-body">
              <table class="table table-striped">
              	<tr>
              		<td width="160px">Nama</td>
              		<td><span id="nama"></span></td>
              	</tr>
              	<tr>
              		<td>Jenis Kelamin</td>
              		<td><span id="jk"></span></td>
              	</tr>
              	<tr>
              		<td>Tempat Lahir</td>
              		<td><span id="tempat_lahir"></span></td>
              	</tr>
              	<tr>
              		<td>Tanggal Lahir</td>
              		<td><span id="tgl_lahir"></span></td>
              	</tr>
              	<tr>
              		<td>No. HP</td>
              		<td><span id="no_hp"></span></td>
              	</tr>
              	<tr>
              		<td>Email</td>
              		<td><span id="email"></span></td>
              	</tr>
              	<tr>
              		<td>Alamat</td>
              		<td><span id="alamat"></span></td>
              	</tr>
              	<tr>
              		<td>Daerah Asal KRN</td>
              		<td><span id="asal_text_krn"></span></td>
              	</tr>
              	<tr>
              		<td>Daerah Penugasan KRN</td>
              		<td><span id="penugasan_text_krn"></span></td>
              	</tr>
              	<tr>
              		<td>Tahun KRN</td>
              		<td><span id="tahun_krn"></span></td>
              	</tr>
              	<tr>
              		<td>Status KRN</td>
              		<td><span id="status_krn"></span></td>
              	</tr>
              	<tr>
              		<td>Saran</td>
              		<td><span id="saran"></span></td>
              	</tr>
              	<tr>
              		<td>Scan KTP</td>
              		<td><a href="#ktp_file" data-toggle="collapse">Tampilkan KTP</a></td>
              	</tr>
              	<tr>
              		<td colspan="2">
		              	<div id="ktp_file" class="collapse">
		          			<div style="text-align: center;">
		          				<img src="" id="foto_ktp" style="max-width: 50%;">
		          			</div>
		              	</div>
              		</td>
              	</tr>

              	<div style="position: absolute;right: 0;max-width: 150px; padding: 10px; border: 1px solid #ccc;">
              		<img src="" style="width: 100%;" id="foto_profile">
              	</div>
              </table>
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
		var htm = elemen.html();
		$.ajax({
			url:getUri(app_data,"get_data_anggota_inti"),
			type:"post",
			dataType:"JSON",
			data:{id_anggota:id},
			beforeSend:function() {
				elemen.html("<i class='fa fa-spinner fa-spin'></i>");
			},
			success:function(result) {
				var jk = result.jk === "L" ? "LAKI-LAKI" : "PEREMPUAN";
				$('#id').val(result.id);
				$('#nama').text(result.nama);
				$('#jk').text(jk);
				$('#tempat_lahir').text(result.tempat_lahir);
				$('#tgl_lahir').text(result.tgl_lahir);
				$('#alamat').text(result.alamat);
				$('#no_hp').text(result.no_hp);
				$('#email').text(result.email);
				$('#saran').text(result.saran);
				$('#asal_krn').text(result.asal_krn);
				$('#asal_text_krn').text(result.asal_text_krn);
				$('#tahun_krn').text(result.tahun_krn);
				$('#status_krn').text(result.status_);
				$('#penugasan_krn').text(result.penugasan_krn);
				$('#penugasan_text_krn').text(result.penugasan_text_krn);
				$('#statusSave').text(1);
				$('#savebutton').text("Update Data");
				$('#foto_profile').attr("src",getUriOrigin("api/pictures/show_picture/member_docs","foto_"+result.id));
				$('#foto_ktp').attr("src",getUriOrigin("api/pictures/show_picture/member_docs","ktp_"+result.id));
				$('.modal_anggota').modal("show");

				/*$('.modal_anggota').modal({backdrop: 'static', keyboard: false});*/
				elemen.html(htm);
			},
			error:function() {
				gagal_screen();
				elemen.html(htm);
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

   	function aprove_data(item) {
   		var nama = $(item).attr("data-nama");
   		var id = $(item).attr("data-value");
   		swal({   
            title: "Anda Yakin?",   
            text: "Data  "+nama+" akan diverifikasi kebenarannya.",   
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
              url:getUri(app_data,'aprove_anggota_'),
              type:"post",
              data:{id_anggota:id},
              dataType:"JSON",
              beforeSend:function() {
                loading_screen();
              },
              success:function(result) {
                swal("BERHASIL!", "Data "+nama+" Berhasil diverifikasi.",'success');
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