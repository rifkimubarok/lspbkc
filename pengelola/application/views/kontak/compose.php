<style type="text/css">
	table tr td {
		padding: 3px;
	}
</style>
<div class="col-md-12">
	<table>
		<tr>
			<td><?='Kepada'?></td>
			<td>:</td>
			<td><?=$data->nama.' <span><</span>'.$data->email.'<span>></span>'?></td>
		</tr>
		<tr>
			<td>Subject</td>
			<td>:</td>
			<td>RE:<?=$data->subjek?></td>
		</tr>
		<tr>
			<td><strong>Pesan</strong></td>
			<td>:</td>
			<td></td>
		</tr>
	</table>
	<form id="send_message">
		<div class="form-group">
			<input type="hidden" name="nama" id="nama" value="<?=$data->nama?>">
			<input type="hidden" name="subjek" id="subjek" value="RE:<?=$data->subjek?>">
			<input type="hidden" name="email" id="email" value="<?=$data->email?>">
			<textarea class="form-control" rows="7" id="summernote" required=""></textarea>
			<textarea id="current_message" style="display: none;"><?="\n\n".htmlspecialchars_decode("--Pesan Sebelumnya--\n".$data->pesan)?></textarea>
		</div>
		<button class="btn btn-primary" data-email="$item->email" data-nama="$item->nama"><i class="fa fa-paper-plane"></i> Kirim</button>
	</form>
</div>

<script type="text/javascript">
	$(document).ready(function() {
    $('#summernote').summernote({

          minHeight: 200,             // set minimum height of editor
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
                url: getUri("filemanager","file_manager/pesan"),
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
	$('#send_message').submit(function() {
		var nama = $('#nama').val();
		var email = $('#email').val();
		var subjek = $('#subjek').val();
		var pesan = $('#summernote').summernote('code')+$('#current_message').val();
		$.ajax({
		url:getUri(app_message,"send_message"),
		type:"post"	,
		dataType:"json",
		data:{nama:nama,email:email,subjek:subjek,pesan:pesan},
		beforeSend:loading_screen,
		success:function(data) {
			swal("","Pesan Berhasil dikirim.","success");
			$('.menu_message a.active').click();
		},
		error:function() {
			swal("","Pesan Gagal dikirim.","error");
		}
		})
		return false;
	})
</script>