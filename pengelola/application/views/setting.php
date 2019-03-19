<style type="text/css">
    .upload-demo .upload-demo-wrap,.upload-demo .upload-result,.upload-demo.ready .upload-msg{display:none}
    .upload-demo.ready .upload-demo-wrap{display:block}
    .upload-demo.ready .upload-result{display:inline-block}
    .upload-demo-wrap{width:300px;height:350px;margin:0 auto}
    .upload-msg{text-align:center;padding:50px;font-size:22px;color:#aaa;width:260px;margin:10px auto;;border:1px solid #aaa}
    input[type="button"] {display: none;}
    input[type="file"] {display: none;}
    .custom-file-upload {display: inline-block;padding: 50px 50px;cursor: pointer;width: 100%;text-align: center}
    .custom-file-upload.ready{width: 50%;border:1px solid #ccc;float: left; display: block!important;padding: 15px 20px !important;}
</style>
<div class="wraper container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="bg-picture text-center" style="background-image:url('<?=IMAGES?>big/bg.jpg')">
                <div class="bg-picture-overlay"></div>
                <div class="profile-info-name">
                    <img src="<?=BASE?>api/pictures/show_picture/member_docs/foto_<?=$user->id?>" class="thumb-lg img-circle img-thumbnail center-cropped" alt="profile-image">
                    <h3 class="text-white"><?=$user->nama?></h3>
                </div>
            </div>
            <!--/ meta -->
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12"> 
        
        <div class="tab-content profile-tab-content"> 
            <div class="tab-pane active" id="home-2"> 
                <div class="row">
                    <div class="col-md-6">
                        <!-- Personal-Information -->
                        <div class="panel panel-default panel-fill">
                            <div class="panel-heading"> 
                                <h3 class="panel-title">Data Pribadi</h3> 
                            </div> 
                            <div class="panel-body"> 
                                <div class="about-info-p">
                                    <strong>Nama</strong>
                                    <br/>
                                    <span id="txt_nama" class="text-muted"><?=$user->nama?></span>
                                    <input type="text" class="form-control" name="nama" id="nama" style="display: none;">
                                </div>
                                <div class="about-info-p">
                                    <strong>No. Hp</strong>
                                    <br/>
                                    <span id="txt_no_hp" class="text-muted"><?=$user->no_hp?></span>
                                    <input type="text" class="form-control" name="no_hp" id="no_hp" style="display: none;">
                                </div>
                                <div class="about-info-p">
                                    <strong>Email</strong>
                                    <br/>
                                    <span id="txt_email" class="text-muted"><?=$user->email?></span>
                                    <input type="email" class="form-control" name="email" id="email" style="display: none;">
                                </div>
                                <div class="form-group" id="edit_group">
                                    <button class="btn btn-primary btn-edit"><i class="fa fa-edit"></i> Perbaharui Profil</button>
                                </div>
                                <div class="form-group" style="display: none;" id="save_group">
                                    <button class="btn btn-primary btn-save"><i class="fa fa-save"></i> Save</button>
                                    <button class="btn btn-warning btn-cancel"><i class="fa fa-times"></i> Batal</button>
                                </div>
                            </div> 
                        </div>
                        <!-- Personal-Information -->

                    </div>


                    <div class="col-md-6">
                        <!-- Personal-Information -->
                        <div class="panel panel-default panel-fill">
                            <div class="panel-heading"> 
                                <h3 class="panel-title">Ubah Password</h3> 
                            </div> 
                            <div class="panel-body"> 
                                <form id="frm_akun">
                                    <div class="form-group">
                                        <input class="form-control" type="password" name="cur_password" id="cur_password" placeholder="Password Sekarang" required="">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" type="password" name="new_password" id="new_password" placeholder="Password Baru" required="">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" type="password" name="conf_password" id="conf_password" placeholder="Konfirmasi Password" required="">
                                    </div>
                                    <div class="form-group">
                                        <label for="opt_user">Perbaharui Username Juga? </label>
                                        <label class="radio-inline" ><input type="radio" name="opt_user" value="1"> Ya</label>
                                        <label class="radio-inline"><input type="radio" name="opt_user" value="0" checked> Tidak</label>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="username" id="username" class="form-control" placeholder="Username Baru" style="display: none;">
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-primary btn-md btn-save-password">Perbaharui</button>
                                    </div>
                                </form>
                            </div> 
                        </div>
                        <!-- Personal-Information -->

                    </div>

                    <div class="col-md-6">
                        <div class="panel panel-default panel-fill">
                            <div class="panel-heading"> 
                                <h3 class="panel-title">Ubah Photo Profile</h3> 
                            </div> 
                            <div class="panel-body" style="padding-bottom: 40px !important;"> 
                                <div class="demo-wrap upload-demo">
                                    <div class="col-md-12">
                                        <div class="row">
                                                <label for="upload" class="custom-file-upload">
                                                    <i class="fa fa-cloud-upload"></i> Pilih Gambar
                                                </label>
                                                <input id="upload" type="file"/>
                                                <label for="upload_foto" class="custom-file-upload" style="display: none;">
                                                    <i class="fa fa-save"></i> Simpan
                                                </label>
                                                <input type="button" id="upload_foto" />
                                        </div>
                                        <div class="upload-demo-wrap">
                                            <div id="upload-demo"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div> 
                        </div>
                    </div>
                </div>
            </div> 
        </div> 
    </div>
    </div>
</div>

<script type="text/javascript">
    var app_member = "setting";
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

        var password = document.getElementById("new_password")
      , confirm_password = document.getElementById("conf_password");

        function validatePassword(){
          if(password.value != confirm_password.value) {
            confirm_password.setCustomValidity("Password Tidak Sama.");
          } else {
            confirm_password.setCustomValidity('');
          }
        }

        $('#new_password').on('change',validatePassword);
        $('#conf_password').on('keyup',validatePassword);

        $('#frm_akun').submit(function() {
        var cur_pass = $('#cur_password').val();
        var new_pass = $('#new_password').val();
        var con_pass = $('#conf_password').val();
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
                    var a = result.message;
                    console.log(a);
                    swal('',a,'warning')
                }
            },
            error:function() {
                //window.location.reload();
            }
        })
        return false;
    })
    })

    function show_edit() {
        $('#edit_group').slideUp(200);
        $('#save_group').slideDown(200);
        var email = $('#txt_email');
        var no_hp = $('#txt_no_hp');
        var nama = $('#txt_nama');
        var txt_nama = $('#nama');
        var txt_email = $('#email');
        var txt_no_hp = $('#no_hp');
        email.slideUp(200);no_hp.slideUp(200);nama.slideUp(200);
        txt_email.slideDown(200);txt_no_hp.slideDown(200);txt_nama.slideDown(200);
        txt_email.val(email.text());txt_no_hp.val(no_hp.text());txt_nama.val(nama.text())
    }

    function hide_edit() {
        $('#edit_group').slideDown(200);
        $('#save_group').slideUp(200);
        var email = $('#txt_email');
        var no_hp = $('#txt_no_hp');
        var nama = $('#txt_nama');
        var txt_nama = $('#nama');
        var txt_email = $('#email');
        var txt_no_hp = $('#no_hp');
        email.slideDown(200);no_hp.slideDown(200);nama.slideDown(200);
        txt_email.slideUp(200);txt_no_hp.slideUp(200);txt_nama.slideUp(200);
    }

    function save_edit() {
        $('#edit_group').slideDown(200);
        $('#save_group').slideUp(200);
        var email = $('#txt_email');
        var no_hp = $('#txt_no_hp');
        var nama = $('#txt_nama');
        var txt_nama = $('#nama');
        var txt_email = $('#email');
        var txt_no_hp = $('#no_hp');
        email.slideDown(200);no_hp.slideDown(200);nama.slideDown(200);
        txt_email.slideUp(200);txt_no_hp.slideUp(200);txt_nama.slideUp(200);
        email.text(txt_email.val());no_hp.text(txt_no_hp.val());nama.text(txt_nama.val());
    }

    function save_data() {
        var txt_email = $('#email');
        var txt_no_hp = $('#no_hp');
        var txt_nama = $('#nama');

        data = {email:txt_email.val(),nama:txt_nama.val(),no_hp:txt_no_hp.val()};
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
</script>


<script>
    $(document).ready(function(){
        demoUpload();
    });
    function demoUpload() {
        var $uploadCrop;

        function readFile(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('.upload-demo').addClass('ready');
                    $('#update_photo .modal-body').addClass('ready');
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

        $uploadCrop = $('#upload-demo').croppie({
            viewport: {
                width: 200,
                height: 300,
                type: 'square'
            },
            enableExif: true
        });

        $('#upload').on('change', function () { readFile(this); $('.custom-file-upload').addClass('ready')});
        $('#upload_foto').on('click', function (ev) {
            $uploadCrop.croppie('result', {
                type: 'base64',
                size: 'viewport',
                format: 'jpeg'
            }).then(function (resp) {
                $.ajax({
                    url:getUri('setting','update_photo'),
                    type:"post",
                    dataType:"JSON",
                    data:{image:resp},
                    beforeSend:loading_screen,
                    success:function(result){
                        if(result.status){
                            $('.nav-list .active').click();
                            swal(" ","Photo Berhasil diupdate.","success");
                            window.location.reload();
                        }
                    },
                    error:gagal_screen
                });
            });
        });
    }
</script>