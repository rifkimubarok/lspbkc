<style type="text/css">
	
  .widget{

  }

  .widget .nav-list{
  		padding-left: 0px;
  }

  .widget .nav-list li{
    padding: 5px 10px;
    margin-bottom: 5px;
    cursor: pointer;
    list-style: none;
    border: 1px solid #ccc;
  }

  .widget .nav-list .active{
    background: none;
    color: #f6214b;
    font-weight: bold;
    border-left: 5px solid #f6214b;
  }
</style>
<div class="row">
	<div class="col-sm-12">
        <ol class="breadcrumb pull-right">
            <li><a href="#">Dashboard</a></li>
            <li class="active">Struktur</li>
        </ol>
    </div>
</div>

<div class="row bx-shadow mini-stat">
	<div class="col-md-12"><h5 class="pull-left">Struktur Organisasi </h5></div>
	<div class="clearfix"></div>
	<div class="col-md-4">
		<section class="widget">
			<ul class="nav-list">
			</ul>
		</section>
	</div>
	<div class="col-md-8 box-wrap pb-10" style="background: #f2f2f2;padding-top: 10px;min-height: 100px;">
		<h5 class="judul-struktur pull-left"></h5>
		<button class="btn btn-primary btn-md pull-right photo" id="btn_tambah" struktur=''><i class="fa fa-pencil"></i> Tambah Data</button>
    	<div class="clearfix"></div>
		<div class="content isi-struktur" style="padding-top: 20px;">
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

<script type="text/javascript">
	app_struktur = "profile";

	$(document).ready(function() {
		
		get_struktur();
	})

	function get_struktur() {
		$.ajax({
			url:getUri(app_struktur,'get_struktur'),
			type:"post",
			dataType:"json",
			success:function(data) {
				var list = "";
				for (var i = 0; i < data.length; i++) {
					var nama = data[i]['nama_struktur'];
					var nama_seo = data[i]['nama_seo'];
					var id = data[i]['id'];
					if(i==0){
						list += '<li class="active" data-value="'+nama_seo+'" struktur="'+id+'"><a href="#"></a> '+nama+'</li>';
					}else{
						list += '<li data-value="'+nama_seo+'" struktur="'+id+'"><a href="#"></a> '+nama+'</li>';
					}
				}
				$('.nav-list').html(list);
			},
			complete:function() {
				$('.nav-list li').click(function() {
					console.log($(this).attr('data-value'));
					$('.nav-list li').each(function(item) {
						$(this).removeClass('active');
					})
					$(this).addClass('active');
					var judul = $(this).text();
					var id = $(this).attr('struktur');
					$('.judul-struktur').html(judul.toUpperCase());
					get_anggota_struktur(id);
					$('#btn_tambah').attr("struktur",$(this).attr('struktur'));
				})
				$('.nav-list .active').click();
			},
			error:function() {
				console.log("Terjadi Kesalahan");
			}
		});
	}

	function get_anggota_struktur(id) {
		$.ajax({
			url:getUri(app_struktur,'get_anggota_struktur'),
			data:{id:id},
			dataType:"html",
			type:"post",
			beforeSend:function() {
				$('.isi-struktur').html("<span style='margin:auto;'><i class='fa fa-spin fa-spinner'></i> Memuat Data ...</span>");
			},
			success:function(data) {
				$('.isi-struktur').html(data);
			}
		});
	}

	$('#btn_tambah').click(function() {
		var item = $(this).attr("struktur");
		$.ajax({
			url:getUri(app_struktur,"get_form_update"),
			type:"post",
			dataType:"html",
			data:{id:$(item).attr("data-value"),page:"tambah_data"},
			success:function(data) {
				$('.modal-body').html(data);
				showModal();
			}
		})
	})

	function updatephoto(item) {
		$.ajax({
			url:getUri(app_struktur,"get_form_update"),
			type:"post",
			dataType:"html",
			data:{id:$(item).attr("data-value"),page:"photo_update"},
			success:function(data) {
				$('.modal-body').html(data);
				showModal();
			}
		})
	}

	function updatedata(item) {
		$.ajax({
			url:getUri(app_struktur,"get_form_update"),
			type:"post",
			dataType:"html",
			data:{id:$(item).attr("data-value"),page:"data_update"},
			success:function(data) {
				$('.modal-body').html(data);
				showModal();
			}
		})
	}

	function hapusdata(item) {
		swal({   
            title: "Anda Yakin?",   
            text: "Data akan segera dihapus!",   
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
              url:getUri(app_struktur,'delete_profile'),
              type:"post",
              data:{id:$(item).attr('data-value')},
              dataType:"JSON",
              beforeSend:function() {
                loading_screen();
              },
              success:function(result) {
                swal("BERHASIL!", "Data Berhasil dihapus.",'success');
                $('.nav-list .active').click();
              },
              error:function() {
                gagal_screen();
              }
            });
          }
        });
	}

	function showModal() {
		$('#updatemodal').modal({backdrop: 'static', keyboard: false});
	}

	function closeModal() {
        $('#updatemodal').modal("toggle");
	}
</script>