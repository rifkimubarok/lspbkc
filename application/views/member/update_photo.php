<style type="text/css">
    .upload-demo .upload-demo-wrap,.upload-demo .upload-result,.upload-demo.ready .upload-msg{display:none}
    .upload-demo.ready .upload-demo-wrap{display:block}
    .upload-demo.ready .upload-result{display:inline-block}
    .upload-demo-wrap{width:300px;height:350px;margin:0 auto}
    .upload-msg{text-align:center;padding:50px;font-size:22px;color:#aaa;width:260px;margin:10px auto;;border:1px solid #aaa}
    input[type="button"] {display: none;}
    input[type="file"] {display: none;}
    .custom-file-upload {display: inline-block;padding: 50px 50px;cursor: pointer;width: 100%;text-align: center}
    .custom-file-upload.ready{width: 50%;border-right:1px solid #ccc;border-bottom: 1px solid #ccc;float: left; display: block!important;padding: 15px 20px !important;}
</style>
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

<div class="modal-footer" style="margin-top: 20px;padding: 15px!important;border-top: none;">
<button type="button" class="btn btn-warning btn-md" data-dismiss="modal">Batal</button>
</div>
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
                var id = $('#id_profile').val();
                $.ajax({
                    url:getUri('registrasi','update_photo'),
                    type:"post",
                    dataType:"JSON",
                    data:{image:resp,id:id},
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