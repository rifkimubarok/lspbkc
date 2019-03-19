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

  .kategori{
    color: red;
    font-style: italic;
    margin: 0;
    opacity: .54;
    text-decoration: none;
    display: inline-block;
    vertical-align: top;
    font-weight: bold;
  }

</style>
<div class="row">
	<div class="col-sm-12">
        <ol class="breadcrumb pull-right">
            <li><a href="#">Dashboard</a></li>
            <li class="active">Berita</li>
        </ol>
    </div>
</div>

<div class="row" id="data_berita">
	<div class="col-md-12 bx-shadow mini-stat">
        <h5 class="pull-left">Management Posting </h5>
        <button class="btn btn-primary btn-md pull-right" id="btn_tambah"><i class="fa fa-pencil"></i> Tambah Posting</button>
    <div class="clearfix"></div>
		<hr>
		<table class="table table-striped table-bordered table-responsive" id="tbl_berita">
			<thead>
				<tr>
					<th width="10px">No</th>
					<th>Judul</th>
					<th>Penulis</th>
					<th>Aktivitas</th>
					<th>Tgl Posting</th>
				</tr>
			</thead>
			<tbody></tbody>
		</table>
	</div>
</div>

<div class="row" id="editor_berita" style="display: none;">
	<form id="form_berita">
		<div class="col-md-12 bx-shadow mini-stat">
			<div class="form-group col-md-8">
				<label for="judul">Judul Berita</label>
				<input type="text" name="judul" id="judul" class="form-control" required="">
				<input type="hidden" name="id_berita" id="id_berita">
			</div>
			<div class="form-group col-md-4">
				<label for="kategori">Kategori</label>
				<select class="form-control" name="kategori" id="kategori" required=""></select>
			</div>
			<div class="form-group col-md-12">
				<label for="cover_image">Gambar Sampul</label>
				<input type="file" name="cover_image" class="form-control" id="cover_image" accept="image/*">
                <div class="alert alert-danger " id="alert-maxsize" style="margin-top: 10px;padding: 5px !important;display: none;">Maksimum Ukuran Gambar 2MB</div>
			</div>
			<div class="form-group col-md-12">
				<label for="summernote">Isi Berita</label>
				<input type="text" name="summernote" id="summernote" class="form-control">
			</div>
			<div class="form-group">
				<input type="hidden" name="status" id="status">
				<button class="btn btn-success" id="save_berita" type="submit">Simpan</button>
				<button class="btn btn-warning" id="cancel" onclick="return false;">Batal</button>
			</div>
		</div>
	</form>
</div>

<script type="text/javascript">
	var app_berita = 'berita';
  var table ;
	$(document).ready(function() {
		getForum();
		get_kategori();
	})

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
                url: getUri("filemanager","file_manager/berita"),
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
    $('#alert-maxsize').slideUp(200);
    $('#save_berita').attr("disabled",false);
    $('#data_berita').slideUp(200);
    $('#editor_berita').slideDown(200);
  })

	function getForum() {
            table =   $('#tbl_berita').DataTable({
            "processing": true,
            "serverSide": true,
            "pagingType": "full_numbers",
            "scrollY":"500px",
            "scrollCollapse": true,
            paging: true,
            responsive: true,
            "order": [],
            "ajax": {
                "url": getUri(app_berita,'get_berita'),
                "type": "POST"           
            }
        });
    }

   	function edit_berita(item) {
   		$.ajax({
   			url:getUri(app_berita,"get_berita_single"),
   			data:{"id_berita":$(item).attr("data-value")},
   			dataType:"JSON",
   			type:"POST",
   			success:function(result) {
   				$('#judul').val(result.data.judul);
   				$('#id_berita').val(result.data.id_berita);
   				$('#kategori').val(result.data.id_kategori);
   				$('#status').val(1);
          $('#summernote').summernote('code', result.isi);
		   		$('#data_berita').slideUp(200);
		   		$('#editor_berita').slideDown(200);
   			},
   			error:function() {
   				swal("GAGAL!", "Silahkan coba lagi.",'error');
   			}
   		});
   	}

   	$('#cancel').click(function() {
   		$('#editor_berita').slideUp(200);
   		$('#data_berita').slideDown(200);
   	});

   	$('#form_berita').submit(function() {
   		var judul = $('#judul').val();
   		var kategori = $('#kategori').val();
   		var id_berita = $('#id_berita').val();
   		var isi_berita = $('#summernote').summernote('code');
   		var status = $('#status').val();
      var cover = $('#cover_image').prop('files')[0];


   		var form_data = new FormData();
   		if(cover != null)form_data.append('cover_image', cover);
        form_data.append('judul', judul);
        form_data.append('isi_berita', isi_berita);
        form_data.append('id_kategori', kategori);
        if(status == 1)form_data.append('id_berita', id_berita);
        var url = status == 1 ? "update_berita" : "save_berita";
        $.ajax({
        	url:getUri(app_berita,url),
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
            swal("BERHASIL!", "Berita Berhasil disimpan.",'success');
            clear_form();
  		   		$('#editor_berita').slideUp(200);
  		   		$('#data_berita').slideDown(200);
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

   	function get_kategori() {
   		$.ajax({
   			url:getUri("kategori","get_kategori"),
   			type:"post",
   			dataType:"JSON",
   			success:function(result) {
   				var option = "<option value=''> Pilih Kategori </option>";
   				for(var i = 0; i<result.length;i++){
   					var isi = result[i]['id_kategori'];
   					var text = result[i]['nama_kategori'];
   					option += "<option value='"+isi+"'> "+text+" </option>";
   				}
   				$('#kategori').html(option);
   			},
   			error:function() {
   				swal("GAGAL!", "Silahkan coba lagi.",'error');
   			}
   		});
   	}

    function clear_form() {
      $('#judul').val('');
      $('#kategori').val('');
      $('#id_berita').val('');
      $('#summernote').summernote('reset');
      $('#status').val('');
      $('#cover_image').val('');
    }

    function delete_berita(item) {
      swal({   
            title: "Anda Yakin?",   
            text: "Data berita akan segera dihapus!",   
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
              url:getUri(app_berita,'delete_berita'),
              type:"post",
              data:{id_berita:$(item).attr('data-value')},
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
                swal("BERHASIL!", "Berita Berhasil dihapus.",'success');
                refresh_table();
              },
              error:function() {
                swal("GAGAL!", "Berita Gagal dihapus.",'error');
              }
            });
          }
        });
    }

    function toogle_publish(item) {
      var conf = $(item).attr('status') == '1' ? "Berita akan dimasukan kedalam daftar draf ?":"Berita akan dipublikasikan ?";
      var message = $(item).attr('status') == '1' ? "Berita berhasil dipindahkan." : "Berita berhasil dipublikasikan.";
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
              url:getUri(app_berita,'toogle_publish'),
              type:"post",
              data:{id_berita:$(item).attr('data-value'),status:status},
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