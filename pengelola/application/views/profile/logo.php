<div class="row">
	<div class="col-sm-12">
        <ol class="breadcrumb pull-right">
            <li><a href="#">Dashboard</a></li>
            <li class="active">Logo</li>
        </ol>
    </div>
</div>

<div class="row" id="data_berita">
	<div class="col-md-12 bx-shadow mini-stat">

	    <form id="profile">
	    	<div class="form-group col-md-12">
        	<h5>Logo </h5>
	    		<textarea id="summernote">
	    			
	    		</textarea>
	    	</div>
	    	<div class="form-group col-md-12">
				<input type="hidden" name="status" id="status">
				<button class="btn btn-success" id="save_berita" type="submit">Simpan</button>
			</div>
	    </form>
    </div>
</div>

<script type="text/javascript">
	app_prof = 'profile';
	$(document).ready(function() {
    $('#summernote').summernote({

          minHeight: 350,             // set minimum height of editor
          maxHeight: null,             // set maximum height of editor

          focus: true,
          onInit:get_isi(),
      toolbar: [
        ['style', ['style']],
        ['font', ['bold','underline', 'clear']],
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

	function get_isi() {
		$.ajax({
			url:getUri(app_prof,'get_profile'),
			data:{id:5},
			type:'post',
			dataType:"json",
			success:function(data) {
				$('#summernote').summernote('code',data.isi_profile);
				return true;
			},
			error:function() {
				console.log("Terjadi Sebuah Kesalahan");
			}
		});
	}

	$('#profile').submit(function() {
		var isi_profile = $('#summernote').summernote('code');
		$.ajax({
			url:getUri(app_prof,'save_profile'),
			data:{id:5,isi_profile:isi_profile},
			type:'post',
			dataType:"json",
			success:function(data) {
				swal("BERHASIL!", "Data Berhasil disimpan.",'success');
			},
			error:function() {
				console.log("Terjadi Sebuah Kesalahan");
			}
		});

		return false;
	})
</script>