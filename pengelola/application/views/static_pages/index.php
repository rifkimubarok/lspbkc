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
    color: grey;
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
            <li class="active">Halaman Statis</li>
        </ol>
    </div>
</div>

<div class="row" id="data_berita">
	<div class="col-md-12 bx-shadow mini-stat">
        <h5 class="pull-left">Management Halaman Statis </h5>
        <button class="btn btn-primary btn-md pull-right" id="btn_tambah"><i class="fa fa-pencil"></i> Tambah Halaman</button>
    <div class="clearfix"></div>
		<hr>
		<table class="table table-striped table-bordered table-responsive" id="tgl_halaman">
			<thead>
				<tr>
					<th width="10px">No</th>
					<th>Judul Halaman</th>
					<th>Tgl Buat</th>
				</tr>
			</thead>
			<tbody></tbody>
		</table>
	</div>
</div>

<div class="row" id="editor_berita" style="display: none;">
	<form id="form_halaman">
		<div class="col-md-12 bx-shadow mini-stat">
			<div class="form-group col-md-8">
				<label for="judul">Judul Halaman</label>
				<input type="text" name="judul" id="judul" class="form-control" required="">
				<input type="hidden" name="id_halaman" id="id_halaman">
			</div>
			<div class="form-group col-md-12">
				<label for="summernote">Isi Halaman</label>
				<input type="text" name="summernote" id="summernote" class="form-control">
			</div>
			<div class="form-group col-md-12">
				<input type="hidden" name="status" id="status">
				<button class="btn btn-success" id="save_berita" type="submit">Simpan</button>
				<button class="btn btn-warning" id="cancel" onclick="return false;">Batal</button>
			</div>
		</div>
	</form>
</div>

<script type="text/javascript">
	var app_ = 'static_page';
  var table ;
	$(document).ready(function() {
		getHalaman();
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
                url: getUri("filemanager","file_manager/profile"),
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
    $('#data_berita').slideUp(200);
    $('#editor_berita').slideDown(200);
  })

	function getHalaman() {
            table =   $('#tgl_halaman').DataTable({
            "processing": true,
            "serverSide": true,
            "pagingType": "full_numbers",
            "scrollY":"500px",
            "scrollCollapse": true,
            paging: true,
            responsive: true,
            "order": [],
            "ajax": {
                "url": getUri(app_,'get_halaman'),
                "type": "POST"           
            }
        });
    }

   	function edit_halaman(item) {
   		$.ajax({
   			url:getUri(app_,"get_halaman_single"),
   			data:{"id_halaman":$(item).attr("data-value")},
   			dataType:"JSON",
   			type:"POST",
   			success:function(result) {
   				$('#judul').val(result.judul);
   				$('#id_halaman').val(result.id_halaman);
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

   	$('#form_halaman').submit(function() {
   		var judul = $('#judul').val();
   		var isi_halaman = $('#summernote').summernote('code');
   		var status = $('#status').val();
   		var id_halaman = $('#id_halaman').val();


   		var form_data = new FormData();
        form_data.append('judul', judul);
        form_data.append('isi_halaman', isi_halaman);
        if(status == 1)form_data.append('id_halaman', id_halaman);
        var url = status == 1 ? "update_halaman" : "save_halaman";
        $.ajax({
        	url:getUri(app_,url),
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
            swal("BERHASIL!", "Halaman Berhasil disimpan.",'success');
            clear_form();
  		   		$('#editor_berita').slideUp(200);
  		   		$('#data_berita').slideDown(200);
            refresh_table();
            $('#save_berita').html("Simpan").attr("disabled",false);
            $('#cancel').attr("disabled",false);
        	},
        	error:function() {
        		swal("GAGAL!", "Halaman Gagal disimpan.",'error');

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

    function delete_halaman(item) {
      swal({   
            title: "Anda Yakin?",   
            text: "Data halaman akan segera dihapus!",   
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
              url:getUri(app_,'delete_halaman'),
              type:"post",
              data:{id_halaman:$(item).attr('data-value')},
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
                swal("BERHASIL!", "Halaman Berhasil dihapus.",'success');
                refresh_table();
              },
              error:function() {
                swal("GAGAL!", "Halaman Gagal dihapus.",'error');
              }
            });
          }
        });
    }

    function toogle_publish(item) {
      var conf = $(item).attr('status') == '1' ? "Halaman akan dimasukan kedalam daftar draf ?":"Halaman akan dipublikasikan ?";
      var message = $(item).attr('status') == '1' ? "Halaman berhasil dipindahkan." : "Halaman berhasil dipublikasikan.";
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
              url:getUri(app_,'toogle_publish'),
              type:"post",
              data:{id_halaman:$(item).attr('data-value'),status:status},
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
</script>