<style type="text/css">
	.upload-demo .upload-demo-wrap,.upload-demo .upload-result,.upload-demo.ready .upload-msg{display:none}
    .upload-demo.ready .upload-demo-wrap{display:block}
    .upload-demo.ready .upload-result{display:inline-block}
    .upload-demo-wrap{width:450px;height:168px;margin:0 auto}
    .upload-msg{text-align:center;padding:50px;font-size:22px;color:#aaa;width:260px;margin:10px auto;;border:1px solid #aaa}
    .dataTables_scrollBody{
        height: 100vh;}
</style>

<div class="row">
	<div class="col-sm-12">
        <ol class="breadcrumb pull-right">
            <li><a href="#">Dashboard</a></li>
            <li class="active">Silder</li>
        </ol>
    </div>
</div>

<div class="row" id="data_berita">
	<div class="col-md-12 bx-shadow mini-stat" style="height: 100vh;">
		<h5 class="pull-left">List Slider</h5>
        <button class="btn btn-primary btn-md pull-right" id="btn_tambah"><i class="fa fa-pencil"></i> Tambah Slider</button>
		<table class="table table-striped" id="table_slider" style="width: 100%;">
			<thead>
				<tr>
					<th width="5%">No</th>
					<th width="65%">Description</th>
					<th width="10%">urutan</th>
					<th width="10%">#</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>
</div>

<div class="modal fade model_slider" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myLargeModalLabel">Data Slider</h4>
            </div>

            <div class="modal-body">
            	<div class="form-group col-md-12">
            		<input type="text" class="form-control" name="description" id="description" required="" placeholder="Deskripsi">
            		<input type="hidden" name="id_slider" id="id_slider">
            		<input type="hidden" name="status_simpan" id="status_simpan" value="0">
            	</div>
            	<div class="form-group col-md-12">
            		<label>
            			Upload Banner&nbsp;&nbsp;&nbsp;
	            		<label style="padding-left: 10px;"><input type="radio" value="1" name="opt_img" id="opt_img"> Ya</label>
	            		<label style="padding-left: 10px;"><input type="radio" value="0" checked="" name="opt_img" id="opt_img" > Tidak</label>
            		</label>
            	</div>

            	<div class="form-group col-md-12 image-upload" style="display: none;">
            		<input type="file" name="slider" id="upload">

					<div class="demo-wrap upload-demo">
	            		<div class="upload-demo-wrap">
				            <div id="upload-demo"></div>
				        </div>
				    </div>
            	</div>

            	<button class="btn btn-primary btn-md" id="upload_foto"> Simpan Slider</button>

            	<div class="image-hasil"></div>
            	<div class="form-group col-md-12 image-uploaded" style="display: block; margin-top: 15px;">
            		<img src="" id="image_slide" name="image_slide" width="100%">
            	</div>

            	<div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
	var app_sys = "slider";

	$(document).ready(function(){
        uploadSlider();
    });


	get_slider();
	function get_slider() {
		$('#table_slider').dataTable({
			"processing": true,
	        "serverSide": true,
	        "scrollY":"200px",
	        "scrollCollapse": true,
	        paging: false,
	        responsive: true,
	        "bLengthChange": false,
	        ordering:false,
	        "searching":false,
	        "order": [],
	        "ajax": {
	            "url": getUri(app_sys,'get_slider'),
	            "type": "POST"
	        }
		});
	}

	$('input[name=opt_img]').click(function(){
        if($(this).val() == 1){
            $('.image-upload').slideDown(200);
            $('.image-uploaded').slideUp(200);
            $('#upload').attr("required",true);
        }else{
            $('.image-upload').slideUp(200);
            $('.image-uploaded').slideDown(200);
            $('#upload').attr("required",false);
        }
    })

	function refres_table() {
		var table = $('#table_slider').dataTable();
		table.api().ajax.reload();
	}

	function edit_data(item) {
		var elmt = $(item);
		$.ajax({
			url:getUri(app_sys,"get_data_slider"),
			data:{id_slide : elmt.attr("data-value")},
			type:"POST",
			dataType:"JSON",
            beforeSend:loading_screen,
			success:function(result) {
				$('#description').val(result.description);
				$('#id_slider').val(result.id);
				$('#status_simpan').val(1);
				$('#image_slide').attr("src",getUriOrigin('api/pictures/show_picture/slider/',result.ref_id));
				$('#image-uploaded').slideDown(200);
				$('.model_slider').modal({backdrop: 'static', keyboard: false});
                swal.close();
			}
		})
	}

    $('#btn_tambah').click(function() {
        clear_form();
        $('.model_slider').modal({backdrop: 'static', keyboard: false});
    })

	function up_button(item) {
		var elmt = $(item);
		$.ajax({
			url:getUri(app_sys,"up_slider"),
			data:{id_slide : elmt.attr("data-value")},
			type:"POST",
			dataType:"JSON",
            beforeSend:loading_screen,
			success:function(result) {
				console.log(result);
				refres_table();
                swal.close();
			}
		})
	}

	function down_button(item) {
		var elmt = $(item);
		$.ajax({
			url:getUri(app_sys,"down_slider"),
			data:{id_slide : elmt.attr("data-value")},
			type:"POST",
			dataType:"JSON",
            beforeSend:loading_screen,
			success:function(result) {
				console.log(result);
				refres_table();
                swal.close();
			}
		})
	}


    function uploadSlider() {
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
                width: 420,
                height: 158,
                type: 'square'
            },
            enableExif: true
        });

        $('#upload').on('change', function () { readFile(this); $('.custom-file-upload').addClass('ready')});
        $('#upload_foto').on('click', function (ev) {
            $uploadCrop.croppie('result', {
                type: 'base64',
                size: 'original',
                format: 'jpeg',
            }).then(function (resp) {
                var status = $('#status_simpan').val();
                var url = status == 1? "update_slider":"simpan_slide";
                var data = {};
                var file_name = $('#upload').val();
                var description = $('#description').val();
                var status_baner = $('input[name=opt_img]:checked').val();
                if(status_baner == 1){
                	data = {id:$('#id_slider').val(),image:resp,description:description,status_baner:status_baner}
                }else{
                    data = {id:$('#id_slider').val(),description:description,status_baner:status_baner}
                }
                $.ajax({
                    url:getUri(app_sys,url),
                    type:"post",
                    dataType:"JSON",
                    data:data,
                    beforeSend:function() {
                        if(status_baner == 1 && file_name == ''){
                            alert("Gambar Tidak Boleh Kosong.");
                            return false;
                        }else{
                            loading_screen();
                        }
                    },
                    success:function(result){
                        if(result.success){
                            $('.nav-list .active').click();
                            swal(" ","Banner Berhasil Disimpan.","success");
                        }
                        $('.model_slider').modal("hide");
                        refres_table();
                    },
                    error:function(x,y,z){

                    }
                });
            });
        });
    }

    function clear_form() {
        $('#description').val('');
        $('#upload').val('');
        $('#id_slider').val('');
        $('#status_simpan').val(0);
        $('#image_slide').attr("src",null);
        $('.demo-wrap.upload-demo').removeClass('ready');
        $('input[value=0]').click();
    }

    function hapus_data(item) {
        var elmt = $(item);

        swal({   
            title: "Anda Yakin?",   
            text: "Data Slider akan segera dihapus!",   
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
                url:getUri(app_sys,"hapus_banner"),
                data:{id_slide : elmt.attr("data-value")},
                type:"POST",
                dataType:"JSON",
                beforeSend:loading_screen,
                success:function(result) {
                    console.log(result);
                    refres_table();
                    swal("","Banner Berhasil dihapus.","success");
                },
                error:gagal_screen,
            })          
        }
        });
    }

    function toogle_data(item){
        var elmt = $(item);
        $.ajax({
            url:getUri(app_sys,"toogle_data_slider"),
            data:{id_slide : elmt.attr("data-value"),status:elmt.attr("data-status")},
            type:"POST",
            dataType:"JSON",
            beforeSend:loading_screen,
            success:function(result) {
                console.log(result);
                refres_table();
                swal.close();
            }
        })
    }
</script>