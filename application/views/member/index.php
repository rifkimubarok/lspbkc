<link rel="stylesheet" type="text/css" href="<?=VENDORS?>croppie/croppie.css"> 
<style type="text/css">
	.image,.middle{transition:.5s ease;width:100%}.middle,.middle a,.text{color:#fff}.image{opacity:1;display:block;height:auto;backface-visibility:hidden}.middle{opacity:0;position:absolute;left:50%;bottom:0;margin-top:10px;padding:10px;background-color:rgba(00,00,00,.6);transform:translate(-50%,-50%);-ms-transform:translate(-50%,-50%);text-align:center}.imagecontent{position:relative;width:100%}.imagecontent:hover .image{opacity:.3}.imagecontent:hover .middle{opacity:1}.text{background-color:#4CAF50;font-size:16px;padding:16px 32px}
	.middle i {
		padding-left: 5px;
		padding-right: 5px;
		margin: auto;
		cursor: pointer;
	}
	.btn-xs {
	    padding: 1px 5px;
	    font-size: 12px;
	    line-height: 1.5;
	}
</style>
<div class="latest-post-wrap">
	<h4 class="cat-title">Member Area</h4>
	<div class="row">
		<div class="col-md-3 pb-20 pt-10">
			<div class="imagecontent" style="max-width: 250px;">
				<img src="<?=BASEURL?>api/pictures/show_picture/member_docs/foto_<?=$user->id?>" style="max-width: 250px;padding: 20px;border: solid 1px #ccc;border-radius: 5px;" class="image">
				<span class="middle">
					<button class="btn btn-default btn-xs" data-value="<?=$user->id?>" onclick=updatephoto(this)><i class="fa fa-camera white" title="Update Photo Profile"></i>Update Foto</button>
				</span>
				</div>
				<a href="#" data-toggle="modal" data-target="#modal-akun"><span>Perbaharui Akun</span></a>
		</div>
		<div class="col-md-9 pb-20 pt-10">

			<div id="profile">
			<table class="table table-striped">
				<tr>
					<td>Nama</td>
					<td><span id="txt_nama"><?=$user->nama?></span>
						<input type="text" class="form-control" name="nama" id="nama" style="display: none;">
					</td>
				</tr>
				<tr>
					<td>Email</td>
					<td><span id="txt_email"><?=$user->email?></span>
						<input type="email" class="form-control" name="email" id="email" style="display: none;">
					</td>
				</tr>
				<tr>
					<td>HP</td>
					<td><span id="txt_no_hp"><?=$user->no_hp?></span>
						<input type="text" class="form-control" name="no_hp" id="no_hp" style="display: none;">
					</td>
				</tr>
			</table>
			<div class="form-group" id="edit_group">
				<button class="btn btn-primary btn-edit"><i class="fa fa-edit"></i> Perbaharui Profil</button>
			</div>
			<div class="form-group" style="display: none;" id="save_group">
				<button class="btn btn-primary btn-save"><i class="fa fa-save"></i> Save</button>
				<button class="btn btn-warning btn-cancel"><i class="fa fa-times"></i> Batal</button>
			</div>
			</div>

			<div id="akun">
				
			</div>

		</div>
	</div>
</div>

<div class="latest-post-wrap" style="margin-top: 20px;" id="form_diskusi">
	<h4 class="cat-title">Post Saya | Forum Diskusi</h4>
	<div class="row">
		<div class="col-md-12">
			<button class="btn btn-primary pull-right add-post" style="margin-top: 10px;"><i class="fa fa-pencil"></i> Buat Diskusi Baru</button>
		</div>
		<div class="col-md-12 forum-content" style="margin-top: 10px;display: none;">
			<form id="frm_forum">
				<div class="col-md-12" style="padding: 10px;border: 1px solid #ddd;background-color: #eee;">
					<div class="form-group">
						<input type="text" class="form-control" name="judul_forum" id="judul_forum" placeholder="Judul Diskusi">
						<input type="hidden" name="forum_id" id="forum_id">
						<input type="hidden" name="status_save" id="status_save">
					</div>
					<div class="form-group">
						<textarea class="form-control" id="summernote" name="summernote"></textarea>
					</div>
					<div class="form-group">
						<button class="btn btn-success btn-md" type="submit"><i class="fa fa-paper-plane"></i> Kirim</button>
						<button class="btn btn-warning btn-md btn-batal-post" type="button"><i class="fa fa-times"></i> Batal</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	<div class="content-forum">
		<p style='text-align:center;'><i class='fa fa-spinner fa-spin'></i> Memuat Data </p>
	</div>
</div>

<div id="modal-akun" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Perbaharui Akun</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form id="frm_akun">
        	<div class="row">
        		<div class="form-group col-md-6">
        			<input type="password" name="cur_pass" id="cur_pass" class="form-control" placeholder="Password Sekarang" required="">
        		</div>
        		<div class="col-md-6"></div>
        		<div class="form-group col-md-6">
        			<input type="password" name="new_pass" id="new_pass" class="form-control" placeholder="Password Baru" required="">
        		</div>
        		<div class="form-group col-md-6">
        			<input type="password" name="con_pass" id="con_pass" class="form-control" placeholder="Konfirmasi Password" required="">
        		</div>
        		<div class="col-md-12">
        			<label for="opt_user">Perbaharui Username Juga? </label>
        			<label class="radio-inline" ><input type="radio" name="opt_user" value="1"> Ya</label>
        			<label class="radio-inline"><input type="radio" name="opt_user" value="0" checked> Tidak</label>
        		</div>
        		<div class="col-md-6">
        			<div class="form-group">
        				<input type="text" name="username" id="username" class="form-control" placeholder="Username Baru" style="display: none;">
        			</div>
        		</div>
        		<div class="col-md-12">
        			<input type="submit" class="btn btn-success" value="Perbaharui">
        			<button class="btn btn-warning" type="button" class="close" data-dismiss="modal">Batal</button>
        		</div>
        	</div>
        </form>
      </div>
    </div>

  </div>
</div>

<div id="updatemodal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content" style="padding: 0px!important;">
      <div class="modal-body" style="padding-top: 0px!important;">
      </div>
    </div>

  </div>
</div>

<script type="text/javascript" src="<?=VENDORS?>croppie/croppie.js"></script>
<script type="text/javascript">
	var app_member = "member";
	$(document).ready(function() {
		$('.btn-edit').click(function(e) {
			e.preventDefault();
			show_edit();
		});
		$('.btn-save').click(function(e) {
			e.preventDefault();
			save_data();
		});
		$('.btn-cancel').click(function(e) {
			e.preventDefault();
			hide_edit();
		});

		$('.add-post').click(function() {
			if($('.forum-content').css("display") == "none"){
				$('.forum-content').slideDown();
			}else{
				$('.forum-content').slideUp();
			}
			reset();
		})

		$('.btn-batal-post').click(function() {
			$('.add-post').click();
		})


		$('input[name=opt_user]').click(function(){
	        if($(this).val() == 1){
	            $('#username').slideDown(200);
	            $('#username').attr("required",'');
	        }else{
	            $('#username').slideUp(200);
	            $('#username').val('');
	            $('#username').removeAttr("required");
	        }
	    })

	    var password = document.getElementById("new_pass")
	  , confirm_password = document.getElementById("con_pass");

		function validatePassword(){
		  if(password.value != confirm_password.value) {
		    confirm_password.setCustomValidity("Password Tidak Sama.");
		  } else {
		    confirm_password.setCustomValidity('');
		  }
		}

		$('#new_pass').on('change',validatePassword);
		$('#con_pass').on('keyup',validatePassword);
		get_forum_detail();

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
	        ['insert', ['link', 'image', 'video']],
	        ['view', ['codeview']]
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
	})

	function show_edit() {
		$('#edit_group').slideUp(200);
		$('#save_group').slideDown(200);
		var email = $('#txt_email');
		var no_hp = $('#txt_no_hp');
		var txt_nama = $('#nama');
		var txt_email = $('#email');
		var txt_no_hp = $('#no_hp');
		email.slideUp(200);no_hp.slideUp(200);
		txt_email.slideDown(200);txt_no_hp.slideDown(200);
		txt_email.val(email.text());txt_no_hp.val(no_hp.text());
	}

	function hide_edit() {
		$('#edit_group').slideDown(200);
		$('#save_group').slideUp(200);
		var email = $('#txt_email');
		var no_hp = $('#txt_no_hp');
		var txt_nama = $('#nama');
		var txt_email = $('#email');
		var txt_no_hp = $('#no_hp');
		email.slideDown(200);no_hp.slideDown(200);
		txt_email.slideUp(200);txt_no_hp.slideUp(200);
	}

	function save_edit() {
		$('#edit_group').slideDown(200);
		$('#save_group').slideUp(200);
		var email = $('#txt_email');
		var no_hp = $('#txt_no_hp');
		var txt_nama = $('#nama');
		var txt_email = $('#email');
		var txt_no_hp = $('#no_hp');
		email.slideDown(200);no_hp.slideDown(200);
		txt_email.slideUp(200);txt_no_hp.slideUp(200);
		email.text(txt_email.val());no_hp.text(txt_no_hp.val());
	}

	function save_data() {
		var txt_email = $('#email');
		var txt_no_hp = $('#no_hp');

		data = {email:txt_email.val(),no_hp:txt_no_hp.val()};
		$.ajax({
			url:getUri(app_member,"save_data_member"),
			type:"post",
			data:data,
			dataType:"JSON",
			beforeSend:loading_screen,
			success:function(result) {
				save_edit();
				swal("Berhasil","Data Berhasil diUpdate.","success");
			},
			error:gagal_screen
		})
	}

	$('#frm_akun').submit(function() {
		var cur_pass = $('#cur_pass').val();
		var new_pass = $('#new_pass').val();
		var con_pass = $('#con_pass').val();
		var username = $('#username').val();
		var stat_user = $('input[name=opt_user]:checked').val();
		var data = {cur_pass:cur_pass,new_pass:new_pass,con_pass:con_pass,username:username,stat_user:stat_user};
		$.ajax({
			url:getUri(app_member,"update_akun"),
			type:"POST",
			dataType:"JSON",
			data:data,
			beforeSend:loading_screen,
			success:function(result) {
				if(result.status){
					swal("Berhasil","Akun Berhasil Diperbaharui.","success");
				}else{
					swal({
						title:"",
						message:result.message,
						type:"warning"
					},function() {
					})
				}
			},
			error:function() {
				//window.location.reload();
			}
		})
		return false;
	})

	function get_forum_detail() {
		$.ajax({
			url:getUri(app_member,"get_forum"),
			dataType:"html",
			beforeSend:function() {
				$('.content-forum').html("<p style='text-align:center;'><i class='fa fa-spinner fa-spin'></i> Memuat Data </p>");
			},
			success:function(result) {
				$('.content-forum').html(result);
			},
			error:function() {
				$('.content-forum').html("<p style='text-align:center;'><i class='fa fa-warning'></i> Tidak Dapat Memuat Konten </p>");	
			}
		})
	}

	$('#frm_forum').submit(function() {
		var uri = $('#status_save').val() == 1 ? "update_diskusi" : "post_diskusi";
		var message = $('#status_save').val() == 1 ? "Perbaharui" : "Unggah";
		$.ajax({
			url:getUri(app_member,uri),
			type:"post",
			data:$('#frm_forum').serialize(),
			dataType:"JSON",
			beforeSend:loading_screen,
			success:function(result) {
				swal("","Postingan Baru Berhasil di "+message,"success");
				get_forum_detail();
				$('.add-post').click();
			},
			error:gagal_screen
		})
		return false;
	})

	function reset() {
		$('#forum_id').val('');
		$('#summernote').summernote("reset");
		$('#judul_forum').val('');
		$('#status_save').val(0);
	}



	function updatephoto(item) {
		$.ajax({
			url:getUri(app_member,"get_form_update"),
			type:"post",
			dataType:"html",
			data:{id:$(item).attr("data-value"),page:"photo_update"},
			success:function(data) {
				$('#updatemodal .modal-body').html(data);
				showModal();
			}
		})
	}

	function showModal() {
		$('#updatemodal').modal({backdrop: 'static', keyboard: false});
	}
</script>