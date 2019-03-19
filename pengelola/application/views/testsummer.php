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
		<form method="post">
		  <textarea id="summernote" name="editordata"></textarea>
		</form>
	</div>
</div>

<script type="text/javascript">
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

	function sendFile(file,editor,welEditable) {
	    data = new FormData();
	    data.append("cover_image", file);
	    $.ajax({
	        data: data,
	        type: "POST",
	        url: getUri("home","upload_image"),
	        cache: false,
	        contentType: false,
	        processData: false,
	        success: function(url) {
	            $('#summernote').summernote('insertImage', url);
	        }
	    });
	}
</script>