<style type="text/css">
	tbody tr:hover .action{
		display: block;
	}

	.action {
    display: none;
    padding-top: 2px;
    padding-left: 0px;
    list-style: none;
    margin-bottom: 0;
  }

  .action a{
    cursor: pointer;
  } 

  .green{
    color: green;
  }

  .red{
    color: red;
  }
</style>
<div class="row">
	<div class="col-sm-12">
        <ol class="breadcrumb pull-right">
            <li><a href="#">Dashboard</a></li>
            <li class="active">Agenda</li>
        </ol>
    </div>
</div>

<div class="row" id="data_agenda">
	<div class="col-md-12 bx-shadow mini-stat">
        <h5 class="pull-left">Management Agenda </h5>
        <button class="btn btn-primary btn-md pull-right" id="btn_tambah"><i class="fa fa-pencil"></i> Tambah Agenda</button>
    <div class="clearfix"></div>
		<hr>
		<table class="table table-striped table-bordered"" id="tbl_agenda">
			<thead>
				<tr>
					<th width="10px">No</th>
					<th>Nama Agenda</th>
					<th>Penulis</th>
					<th>Tgl & Waktu Agenda</th>
				</tr>
			</thead>
			<tbody></tbody>
		</table>
	</div>
</div>

<div class="row" id="editor_agenda" style="display: none;">
	<form id="form_agenda">
		<div class="col-md-12 bx-shadow mini-stat">
			<div class="form-group col-md-12">
				<label for="tema">Judul Agenda</label>
				<input type="text" name="tema" id="tema" class="form-control" required="">
				<input type="hidden" name="id_agenda" id="id_agenda">
			</div>
			<div class="form-group col-md-4">
				<label for="tgl_mulai">Tanggal Mulai</label>
				<input type="date" name="tgl_mulai" id="tgl_mulai" class="form-control" required="">
			</div>
			<div class="form-group col-md-4">
				<label for="tgl_selesai">Tanggal Selesai</label>
				<input type="date" name="tgl_selesai" id="tgl_selesai" class="form-control" required="">
			</div>
			<div class="form-group col-md-4">
				<label for="jam">Waktu Pelaksanaan</label>
				<input type="text" name="jam" id="jam" class="form-control" required="">
			</div>
			<div class="form-group col-md-12">
				<label for="cover_image">Gambar Sampul</label>
				<input type="file" name="cover_image" class="form-control" id="cover_image" accept="image/*">
                <div class="alert alert-danger " id="alert-maxsize" style="margin-top: 10px;padding: 5px !important;display: none;">Maksimum Ukuran Gambar 2MB</div>
            </div>
			<div class="form-group col-md-12">
				<label for="isi">Isi Agenda</label>
				<input type="text" name="summernote" id="summernote" class="form-control">
			</div>
			<div class="form-group">
				<input type="hidden" name="status" id="status">
				<button class="btn btn-success" id="save_agenda" type="submit">Simpan</button>
				<button class="btn btn-warning" id="cancel" onclick="return false;">Batal</button>
			</div>
		</div>
	</form>
</div>

<script type="text/javascript">
	var app_agenda = 'agenda';
  var table ;
	$(document).ready(function() {
		getForum();
	})

	$(document).ready(function() {
		var today = new Date();
		var dd1 = today.getDate();
		var mm = today.getMonth()+1;
		var yyyy = today.getFullYear();
		if(dd1 < 10){
		    dd1 = '0'+dd1;
		}
		if(mm<10){
		    mm='0'+mm;
		}
		today = yyyy+'-'+mm+'-'+dd1; 
		// document.getElementById('tgl_mulai').setAttribute('min',today);
		 $('#tgl_selesai').attr("disabled",true);
		$('#jam').inputmask({mask:'99.99 s/d 99.99 ', placeholder: ''});
	});

	$('#tgl_mulai').change(function() {
		var today = new Date($('#tgl_mulai').val());
		var dd1 = today.getDate();
		var mm = today.getMonth()+1;
		var yyyy = today.getFullYear();
		if(dd1 < 10){
		    dd1 = '0'+dd1;
		}
		if(mm<10){
		    mm='0'+mm;
		}
		today = yyyy+'-'+mm+'-'+dd1; 
		document.getElementById('tgl_selesai').setAttribute('min',today);
		$('#tgl_selesai').attr("disabled",false);
	});

	$(document).ready(function() {
    $('#summernote').summernote({

          minHeight: 350,             // set minimum height of editor
          maxHeight: null,             // set maximum height of editor

          focus: true,
          callbacks: {
          onImageUpload: function(files, editor, welEditable) {
            // upload image to server and create imgNode...
            sendFile(files[0],editor,welEditable);
          }
        },
      toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'clear']],
        ['fontname', ['fontname']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['table', ['table']],
        ['insert', ['link', 'image', 'video']],
        ['view', ['fullscreen', 'codeview']]
      ],
      buttons: {
        image: function() {
          var ui = $.summernote.ui;
          var button = ui.button({
            contents: '<i class="fa fa-image" />',
            tooltip: "Image manager",
            click: function () {
              $('#modal-image').remove();
              $.ajax({
                url: getUri("filemanager","file_manager/agenda"),
                dataType: 'html',
                success: function(html) {
                  $('body').append('<div id="modal-image" class="modal">' + html + '</div>');
                  $('#modal-image').modal('show');
                }
              });           
            }
          });
          return button.render();
        }
      }
      });
  });

  $('#btn_tambah').click(function() {
    clear_form();
    $('#data_agenda').slideUp(200);
    $('#editor_agenda').slideDown(200);
  })

	function getForum() {
            table =   $('#tbl_agenda').DataTable({
            "processing": true,
            "serverSide": true,
            "pagingType": "full_numbers",
            "scrollY":"200px",
            "scrollCollapse": true,
            paging: true,
            responsive: true,
            "order": [],
            "ajax": {
                "url": getUri(app_agenda,'get_agenda'),
                "type": "POST"           
            }
        });
    }

   	function edit_agenda(item) {
   		$.ajax({
   			url:getUri(app_agenda,"get_agenda_single"),
   			data:{"id_agenda":$(item).attr("data-value")},
   			dataType:"JSON",
   			type:"POST",
   			success:function(result) {
   				$('#tema').val(result.data.tema);
   				$('#id_agenda').val(result.data.id_agenda);
   				$('#tgl_mulai').val(result.data.tgl_mulai);
   				$('#tgl_selesai').val(result.data.tgl_selesai);
          $('#status').val(1);
   				$('#jam').val(result.data.jam);
   				$('#summernote').summernote('code', result.isi);
		   		$('#data_agenda').slideUp(200);
		   		$('#editor_agenda').slideDown(200);
   			},
   			error:function() {
   				swal("GAGAL!", "Silahkan coba lagi.",'error');
   			}
   		});
   	}

   	$('#cancel').click(function() {
   		$('#editor_agenda').slideUp(200);
   		$('#data_agenda').slideDown(200);
   	});

   	$('#form_agenda').submit(function() {
   		var tema = $('#tema').val();
   		var kategori = $('#kategori').val();
   		var id_agenda = $('#id_agenda').val();
   		var tgl_mulai = $('#tgl_mulai').val();
   		var tgl_selesai = $('#tgl_selesai').val();
   		var jam = $('#jam').val();
   		var isi_agenda = $('#summernote').summernote('code');
   		var status = $('#status').val();
      	var cover = $('#cover_image').prop('files')[0];


   		var form_data = new FormData();
   		if(cover != null)form_data.append('cover_image', cover);
        form_data.append('tema', tema);
        form_data.append('isi_agenda', isi_agenda);
        form_data.append('id_kategori', kategori);
        form_data.append('tgl_mulai', tgl_mulai);
        form_data.append('tgl_selesai', tgl_selesai);
        form_data.append('jam', jam);
        if(status == 1)form_data.append('id_agenda', id_agenda);
        var url = status == 1 ? "update_agenda" : "save_agenda";
        $.ajax({
        	url:getUri(app_agenda,url),
        	cache: false,
          contentType: false,
          processData: false,
          data: form_data,
          type: 'post',
          dataType:"JSON",
          beforeSend:function() {
            $('#save_berita').html("<i class='fa fa-spin fa-spinner'></i> Menyimpan ...").attr("disabled",true);
            $('#cancel').attr("disabled",true);
          },
        	success:function() {
            swal("BERHASIL!", "Agenda Berhasil disimpan.",'success');
            clear_form();
  		   		$('#editor_agenda').slideUp(200);
  		   		$('#data_agenda').slideDown(200);
            refresh_table();
            $('#save_berita').html("Simpan").attr("disabled",false);
            $('#cancel').attr("disabled",false);
        	},
        	error:function() {
        		swal("GAGAL!", "Berita Gagal disimpan.",'error');
            $('#save_berita').html("Simpan").attr("disabled",false);
            $('#cancel').attr("disabled",false);
        	}
        });
   		return false;
   	})

    function clear_form() {
      $('#tema').val('');
   		$('#kategori').val('');
   		$('#id_agenda').val('');
   		$('#tgl_mulai').val('');
   		$('#tgl_selesai').val('');
   		$('#jam').val('');
   		$('#summernote').summernote('reset');
   		$('#status').val('');
      $('#cover_image').val('')
    }

    function delete_agenda(item) {
      swal({   
            title: "Anda Yakin?",   
            text: "Data Agenda akan segera dihapus!",   
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
            url:getUri(app_agenda,'delete_agenda'),
            type:"post",
            data:{id_agenda:$(item).attr('data-value')},
            dataType:"JSON",
            beforeSend:function() {
              swal({   
                  title: "Mohon Tunggu!",   
                  text: "Sedang Memprosess.",   
                  imageUrl: getUri("assets","images/loading.gif"), 
                  showConfirmButton:false
              });
            },
            success:function(result) {
              swal("BERHASIL!", "Agenda Berhasil dihapus.",'success');
              refresh_table();
            },
            error:function() {
              swal("GAGAL!", "Silahkan coba lagi.",'error');
            }
          });
          }
        });
    }

    function toogle_publish(item) {
      var conf = $(item).attr('status') == '1' ? "Agenda akan dimasukan kedalam daftar draf ?":"Agenda akan dipublikasikan ?";
      var message = $(item).attr('status') == '1' ? "Agenda berhasil dipindahkan." : "Agenda berhasil dipublikasikan.";
      var status = $(item).attr('status') == '1' ? 0 : 1;
      swal({   
            title: "Anda Yakin?",   
            text: conf,   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#ffd740",   
            confirmButtonText: "Ya!",  
            cancelButtonText:"Tidak",
            closeOnConfirm: false, 
            showLoaderOnConfirm: true,
        }, function(data) {
          if (data) {
          $.ajax({
            url:getUri(app_agenda,'toogle_publish'),
            type:"post",
            data:{id_agenda:$(item).attr('data-value'),status:status},
            dataType:"JSON",
            beforeSend:function() {
              swal({   
                  title: "Mohon Tunggu!",   
                  text: "Sedang Memprosess.",   
                  imageUrl: getUri("assets","images/loading.gif"), 
                  showConfirmButton:false
              });
            },
            success:function(result) {
              swal("BERHASIL!", message,'success');
              refresh_table();
            },
            error:function() {
              swal("GAGAL!", "Silahkan coba lagi.",'error');
            }
          });
          }
        });


    }

    function refresh_table() {
      table.ajax.reload();
    }

    $('#cover_image').on("change",function () {
        var a=(this.files[0].size);
        var input = this;
        console.log(a);
        if(a > 2048000) {
            $('#alert-maxsize').slideDown(200).text("Maksimum Ukuran Gambar 2MB");
            $('#save_berita').attr("disabled",true);
        }else {
            $('#alert-maxsize').slideUp(200);
            $('#save_berita').attr("disabled", false);
            var validExtensions = ['jpg', 'JPG', 'jpeg', 'JPEG']; //array of valid extensions
            var fileName = this.files[0].name;
            var fileNameExt = fileName.substr(fileName.lastIndexOf('.') + 1);
            if ($.inArray(fileNameExt, validExtensions) == -1) {
                $('#alert-maxsize').slideDown(200).text("Tipe File Harus .jpg");
                $('#save_berita').attr("disabled", true);
            } else {
                $('#alert-maxsize').slideUp(200);
                $('#save_berita').attr("disabled", false);
            }
        }
    })
</script>