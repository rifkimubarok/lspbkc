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
            <li class="active">Berita</li>
        </ol>
    </div>
</div>

<div class="row" id="data_berita">
	<div class="col-md-12 bx-shadow mini-stat">
        <h5 class="pull-left">Management Forum Diskusi </h5>
        <button class="btn btn-primary btn-md pull-right" id="btn_tambah"><i class="fa fa-pencil"></i> Tambah Forum</button>
    <div class="clearfix"></div>
		<hr>
    <label for="cb_tampil"><input type="checkbox" name="cb_tampil" id="cb_tampil"> Tampilkan Hanya Forum saya</label>
		<table class="table table-striped table-bordered"" id="tbl_berita">
			<thead>
				<tr>
					<th width="10px">No</th>
					<th>Judul</th>
					<th>Pemilik Forum</th>
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
			<div class="form-group col-md-12">
				<label for="judul">Judul Forum Diskusi</label>
				<input type="text" name="judul_forum" id="judul_forum" class="form-control" required="">
				<input type="hidden" name="id_forum" id="id_forum">
			</div>
			<!-- <div class="form-group col-md-4">
				<label for="kategori">Kategori</label>
				<select class="form-control" name="kategori" id="kategori" required=""></select>
			</div> -->
			<div class="form-group col-md-12">
				<label for="summernote">Konten</label>
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
	var app_forum = 'forum';
  var table ;
  var isChecked = 0;
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
                url: getUri("filemanager","file_manager/forum"),
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

  $('#cb_tampil').click(function() {
      if($(this).is(":checked")){
          isChecked = 1;
      }else{
          isChecked = 0;
      }
      refresh_table();
  })

  $('#btn_tambah').click(function() {
    clear_form();
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
                "url": getUri(app_forum,'get_forum'),
                "type": "POST",
                 data :function(data) {
                    data.checkedbox = isChecked;    
                 }
            }
        });
    }

   	function edit_forum(item) {
   		$.ajax({
   			url:getUri(app_forum,"get_forum_single"),
   			data:{"id_forum":$(item).attr("data-value")},
   			dataType:"JSON",
   			type:"POST",
   			success:function(result) {
   				$('#judul_forum').val(result.data.judul_forum);
   				$('#id_forum').val(result.data.id);
   				/*$('#kategori').val(result.data.id_kategori);*/
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
   		var judul = $('#judul_forum').val();
   		var kategori = $('#kategori').val();
   		var id_forum = $('#id_forum').val();
   		var isi_berita = $('#summernote').summernote('code');
   		var status = $('#status').val();


   		var form_data = new FormData();
        form_data.append('judul', judul);
        form_data.append('content', isi_berita);
        if(status == 1)form_data.append('id_forum', id_forum);
        var url = status == 1 ? "update_forum" : "save_forum";
        $.ajax({
        	url:getUri(app_forum,url),
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
            swal("BERHASIL!", "Forum Berhasil disimpan.",'success');
            clear_form();
  		   		$('#editor_berita').slideUp(200);
  		   		$('#data_berita').slideDown(200);
            refresh_table();
            $('#save_berita').html("Simpan").attr("disabled",false);
            $('#cancel').attr("disabled",false);
        	},
        	error:function() {
        		swal("GAGAL!", "Forum Gagal disimpan.",'error');

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
      $('#judul_forum').val('');
      $('#kategori').val('');
      $('#id_forum').val('');
      $('#summernote').summernote('reset');
      $('#status').val('');
    }

    function delete_forum(item) {
      swal({   
            title: "Anda Yakin?",   
            text: "Forum diskusi ini akan segera dihapus!",   
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
              url:getUri(app_forum,'delete_forum'),
              type:"post",
              data:{id_forum:$(item).attr('data-value')},
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
      var conf = $(item).attr('status') == '1' ? "Forum diskusi akan dimasukan kedalam daftar draf ?":"Forum diskusi akan dipublikasikan ?";
      var message = $(item).attr('status') == '1' ? "Forum diskusi berhasil dipindahkan." : "Forum diskusi berhasil dipublikasikan.";
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
              url:getUri(app_forum,'toogle_publish'),
              type:"post",
              data:{id_forum:$(item).attr('data-value'),status:status},
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