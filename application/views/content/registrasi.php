<link rel="stylesheet" type="text/css" href="<?=VENDORS?>croppie/croppie.css">
<style type="text/css">
    .foto-upload .foto-upload-wrap,.foto-upload .upload-result,.foto-upload.ready .upload-msg{display:none}
    .foto-upload.ready .foto-upload-wrap{display:block}
    .foto-upload.ready .upload-result{display:inline-block}
    .foto-upload-wrap{width:430px;height:350px;margin:0 auto}
    .upload-msg{text-align:center;padding:50px;font-size:22px;color:#aaa;width:260px;margin:10px auto;;border:1px solid #aaa}
    .button_upload {display: none;}
    .file_upload {display: none;}
    .custom-file-upload-foto {display: inline-block;padding: 50px 50px;cursor: pointer;width: 100%;text-align: center}
    .custom-file-upload-foto.ready{width: 50%;border-right:1px solid #ccc;border-bottom: 1px solid #ccc;float: left; display: block!important;padding: 15px 20px !important;}

    .ktp-upload .ktp-upload-wrap,.ktp-upload .upload-result,.ktp-upload.ready .upload-msg{display:none}
    .ktp-upload.ready .ktp-upload-wrap{display:block}
    .ktp-upload.ready .upload-result{display:inline-block}
    .ktp-upload-wrap{width:430px;height:350px;margin:0 auto}
    .custom-file-upload-ktp {display: inline-block;padding: 50px 50px;cursor: pointer;width: 100%;text-align: center}
    .custom-file-upload-ktp.ready{width: 50%;border-right:1px solid #ccc;border-bottom: 1px solid #ccc;float: left; display: block!important;padding: 15px 20px !important;}
</style>
<div class="single-post-wrap">
	<div class="content">
		<h3 class="pb-30">Registrasi Pasukan <?=$status_krn == 1?"Utama":"Inti"?></h3>
		<form id="frm_registrasi">
			<div class="row">
					<div class="form-group col-md-8">
						<label for="nama">Nama Lengkap <span style="color: red" title="Wajib diisi">*</span></label>
						<input type="text" name="nama" id="nama" required="" class="form-control">
					</div>
					<div class="form-group col-md-4">
						<label for="jk">Jenis Kelamin <span style="color: red" title="Wajib diisi">*</span></label>
						<select class="form-control" id="jk" name="jk" required="">
							<option value="L">Laki-laki</option>
							<option value="P">Perempuan</option>
						</select>
					</div>
					<div class="form-group col-md-4">
						<label for="tempat_lahir">Tempat Lahir <span style="color: red" title="Wajib diisi">*</span></label>
						<input type="text" name="tempat_lahir" id="tempat_lahir" required="" class="form-control">
					</div>
					<div class="form-group col-md-4">
						<label for="tgl_lahir">Tanggal Lahir <span style="color: red" title="Wajib diisi">*</span></label>
						<input type="date" name="tgl_lahir" id="tgl_lahir" required="" class="form-control">
					</div>
					<div class="form-group col-md-4">
						<label for="no_hp">Nomor HP <span style="color: red" title="Wajib diisi">*</span></label>
						<input type="text" name="no_hp" id="no_hp" required="" class="form-control">
					</div>
					<div class="form-group col-md-6">
						<label for="email">Alamat Email </label>
						<input type="email" name="email" id="email" class="form-control">
					</div>

					<div class="form-group col-md-6">
						<label for="alamat">Alamat <span style="color: red" title="Wajib diisi">*</span></label>
						<textarea name="alamat" id="alamat" required="" class="form-control"></textarea>
					</div>

					<div class="form-group col-md-5">
						<label for="asal_krn"><?=$status_krn==1?"Daerah Asal KRN":"Daerah Pasukan Inti"?> <span style="color: red" title="Wajib diisi">*</span></label>
						<select name="asal_krn" id="asal_krn" required="" class="form-control">
						</select>
						<input type="hidden" name="asal_text_krn" id="asal_text_krn">
					</div>
					<?php 
              if($status_krn == 1){
                ?>
          <div class="form-group col-md-5">
            <label for="penugasan_krn"><?=$status_krn==1?"Daerah Penugasan KRN":"Daerah Penugasan Pasukan Inti"?> <span style="color: red" title="Wajib diisi">*</span></label>
            <select name="penugasan_krn" id="penugasan_krn" required="" class="form-control">
            </select>
            <input type="hidden" name="penugasan_text_krn" id="penugasan_text_krn">
          </div>
                <?php
              }
           ?>
					<div class="form-group col-md-2">
						<label for="status_krn"><?=$status_krn==1?"Tahun Krn":"Tahun"?> <span style="color: red" title="Wajib diisi">*</span></label>
            <input type="text" name="tahun_krn" id="tahun_krn" required="" class="form-control">
						<input type="hidden" name="status_krn" id="status_krn" value="<?=$status_krn?>">
					</div>
					<div class="form-group col-md-12">
						<label for="saran">Saran </label>
						<textarea name="saran" id="saran" class="form-control" rows="4"></textarea>
					</div>
					<div class="form-group col-md-6">
						<label for="foto_file">Foto 4X6</label><br>
						<button class="btn btn-primary pilih-foto"><i class="fa fa-image"></i> Pilih Foto</button>
						<textarea id="foto_file" name="foto_file" style="display: none;"></textarea>
						<div style="text-align: center;padding-top: 5px;">
							<img src="" id="tmp_foto" style="display: none;width: 50%;margin: 0 auto;">
						</div>
					</div>
					<div class="form-group col-md-6">
						<label for="ktp_file">Scan KTP</label><br>
						<button class="btn btn-primary pilih-ktp"><i class="fa fa-image"></i> Pilih Gambar</button>
						<textarea id="ktp_file" name="ktp_file" style="display: none;"></textarea>
						<div style="text-align: center;padding-top: 5px;">
							<img src="" id="tmp_ktp" style="display: none;width: 100%;margin: 0 auto;">
						</div>
					</div>
					<div class="form-group col-md-6">
						<div class="row">
							<div class="col-5" id="captcha_box">
								<?=$captcha->image?>
							</div>
							<div class="col-7">
								<input type="text" class="form-control" name="security_code" id="security_code" required="" placeholder="Security Code">
							</div>
						</div>
					</div>
					<div class="form-group col-md-6">
						<button class="btn btn-primary btn-md" type="submit">Registrasi</button>
					</div>
			</div>
		</form>
	</div>
</div>

<div id="foto_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content" style="padding: 0px!important;">
      <div class="modal-body" style="padding: 0px!important;">
      	<div class="demo-wrap foto-upload">
		    <div class="col-md-12">
		        <div class="row">
		                <input type="hidden" name="id_profile" id="id_profile" value="">
		                <label for="foto_up" class="custom-file-upload-foto">
		                    <i class="fa fa-cloud-upload"></i> Pilih Gambar
		                </label>
		                <input id="foto_up" type="file" class="file_upload" />
		                <label for="upload_foto" class="custom-file-upload-foto" style="display: none;">
		                    <i class="fa fa-save"></i> Simpan
		                </label>
		                <input type="hidden" name="replace_to" id="replace_to">
		                <input type="button" id="upload_foto" class="button_upload" />
		        </div>
		        <div class="foto-upload-wrap">
		            <div id="foto-upload"></div>
		        </div>
		    </div>
		</div>
		<div class="clearfix"></div>
      </div>
	<div class="modal-footer" style="margin-top: 10px;padding: 10px!important;border-top: none;">
	<button type="submit" class="btn btn-warning btn-md" data-dismiss="modal">Batal</button>
	</div>
    </div>

  </div>
</div>

<div id="ktp_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content" style="padding: 0px!important;">
      <div class="modal-body" style="padding: 0px!important;">
      	<div class="demo-wrap ktp-upload">
		    <div class="col-md-12">
		        <div class="row">
		                <input type="hidden" name="id_profile" id="id_profile" value="">
		                <label for="ktp_up" class="custom-file-upload-ktp">
		                    <i class="fa fa-cloud-upload"></i> Pilih Gambar
		                </label>
		                <input id="ktp_up" type="file" class="file_upload" />
		                <label for="upload_ktp" class="custom-file-upload-ktp" style="display: none;">
		                    <i class="fa fa-save"></i> Simpan
		                </label>
		                <input type="hidden" name="replace_to" id="replace_to">
		                <input type="button" id="upload_ktp" class="button_upload" />
		        </div>
		        <div class="ktp-upload-wrap">
		            <div id="ktp-upload"></div>
		        </div>
		    </div>
		</div>
		<div class="clearfix"></div>
      </div>
	<div class="modal-footer" style="margin-top: 10px;padding: 10px!important;border-top: none;">
	<button type="submit" class="btn btn-warning btn-md" data-dismiss="modal">Batal</button>
	</div>
    </div>

  </div>
</div>


<script type="text/javascript" src="<?=VENDORS?>croppie/croppie.js"></script>
<script type="text/javascript">
	var app_dpd = 'dpd';
	var app_registrasi = 'registrasi';
	get_refprovinsi();
	get_ref_status();
	$('#asal_krn').change(function() {
		$('#asal_text_krn').val($('#asal_krn option:selected').text());
	})
	$('#penugasan_krn').change(function() {
		$('#penugasan_text_krn').val($('#penugasan_krn option:selected').text());
	})
	$('#no_hp').inputmask({mask:'+62899999999999 ', placeholder: ''});
	$('#security_code').inputmask({mask:'999999', placeholder: ''});
	$('#tahun_krn').inputmask({mask:'9999', placeholder: ''});

	$('.pilih-foto').click(function() {
		$("#replace_to").val("foto_file");
		$('#foto_modal').modal({keyboard:false,backdrop: 'static'})
		return false;
	})

	$('.pilih-ktp').click(function() {
		$("#replace_to").val("ktp_file");
		$('#ktp_modal').modal({keyboard:false,backdrop: 'static'})
		return false;
	})

	function get_refprovinsi() {
   		$.ajax({
   			url:getUri(app_dpd,"ref_provinsi"),
   			type:"post",
   			dataType:"JSON",
   			success:function(result) {
   				var option ='';
   				for(var i = 0; i<result.length;i++){
   					var isi = result[i]['kode'];
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
   			url:getUri(app_registrasi,"ref_status"),
   			type:"post",
   			dataType:"JSON",
   			success:function(result) {
   				var option ='';
   				for(var i = 0; i<result.length;i++){
   					var isi = result[i]['id'];
   					var text = result[i]['status'];
   					option += "<option value='"+isi+"'> "+text+" </option>";
   				}
   				//$('#status_krn').html(option);

   			},
   			complete:function() {
   			},
   			error:function() {
   				alert("gagal");
   			}
   		});
   	}

   	$('#frm_registrasi').submit(function() {
   		$.ajax({
   			url:getUri(app_registrasi,"register"),
   			type:"post",
   			dataType:"JSON",
   			data:$('#frm_registrasi').serialize(),
        beforeSend:loading_screen,
   			success:function(result) {
   				if(result.status){
   					swal("Berhasil!","Registrasi Berhasil.","success");
   				}else{
   					swal("Terjadi Kesalahan!",result.message,"error");
   					refresh_captcha();
   				}
   			},
   			complete:function() {
   			},
   			error:function() {
   				gagal_screen();
   				refresh_captcha();
   			}
   		});
   		return false;
   	});

   	function refresh_captcha() {
   		$.ajax({
   			url:getUri(app_registrasi,"refresh_captcha"),
   			type:"post",
   			dataType:"JSON",
   			success:function(result) {
   				$('#captcha_box').html(result.image);
   			},
   			error:function() {
   				alert("gagal");
   			}
   		});
   	}


   	$(document).ready(function(){
        foto_file();
        ktp_file();
    });
    
    function foto_file() {
        var $uploadCrop;

        function readFile(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('.foto-upload').addClass('ready');
                    $uploadCrop.croppie('bind', {
                        url: e.target.result
                    }).then(function(){
                    });

                }
                reader.readAsDataURL(input.files[0]);
            }
            else {
                swal("Sorry - you're browser doesn't support the FileReader API");
            }
        }

        $uploadCrop = $('#foto-upload').croppie({
            viewport: {
                width: 200,
                height: 300,
                type: 'square'
            },
            enableExif: true
        });

        $('#foto_up').on('change', function () { readFile(this); $('.custom-file-upload-foto').addClass('ready')});
        $('#upload_foto').on('click', function (ev) {
            $uploadCrop.croppie('result', {
                type: 'base64',
                size: 'original',
                format: 'jpeg'
            }).then(function (resp) {
                $('#foto_file').val(resp);
                $('#tmp_foto').attr("src",resp);
                $('#tmp_foto').slideDown(200);
                $('#foto_modal').modal("hide");
            });
        });
    }

    function ktp_file() {
        var $uploadCrop;

        function readFile(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('.ktp-upload').addClass('ready');
                    $uploadCrop.croppie('bind', {
                        url: e.target.result
                    }).then(function(){
                    });

                }
                reader.readAsDataURL(input.files[0]);
            }
            else {
                swal("Sorry - you're browser doesn't support the FileReader API");
            }
        }

        $uploadCrop = $('#ktp-upload').croppie({
            viewport: {
                width: 300,
                height: 200,
                type: 'square'
            },
            enableExif: true
        });

        $('#ktp_up').on('change', function () { readFile(this); $('.custom-file-upload-ktp').addClass('ready')});
        $('#upload_ktp').on('click', function (ev) {
            $uploadCrop.croppie('result', {
                type: 'base64',
                size: 'original',
                format: 'jpeg'
            }).then(function (resp) {
            	$('#ktp_file').val(resp);
                $('#tmp_ktp').attr("src",resp);
                $('#tmp_ktp').slideDown(200);
                $('#ktp_modal').modal("hide");
            });
        });
    }
</script>