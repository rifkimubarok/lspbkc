<div class="single-post-wrap">
	<!-- <div class="feature-img-thumb relative">
		<div class="overlay overlay-bg"></div>
		<img class="img-fluid" src="<?=IMAGES?>f1.jpg" alt="">
	</div> -->
	<div class="content-wrap">
	<!-- 	<ul class="tags mt-10">
			<li><a href="#">Food Habit</a></li>
		</ul> -->
		<a href="#">
			<?php 
				$jdl = $this->lang->line("struktur_menu");
				$judul = $jdl == null ? "Struktur Organisasi" : $jdl;
			 ?>
			<h3><?=$judul?></h3>
		</a>
		<ul class="meta pb-20">
			<!-- <li><a href="#"><span class="lnr lnr-user"></span>Mark wiens</a></li>
			<li><a href="#"><span class="lnr lnr-calendar-full"></span>28 January, 2016</a></li> -->
		</ul>
		<div class="row">
			<div class="col-md-4">
				<section class="widget">
					<ul class="nav-list">
					</ul>
				</section>
			</div>
			<div class="col-md-8 box-wrap pb-10" style="background: #f2f2f2;padding-top: 10px;min-height: 100px;">
				<h5 class="judul-struktur"></h5>
				<div class="content isi-struktur">
				</div>
			</div>
		</div>
	<div class="clearfix"></div>
</div>
</div>

<script type="text/javascript">
	app_struktur = "profile";

	$(document).ready(function() {
		
		get_struktur();
	})

	function get_struktur() {
		$.ajax({
			url:getUri(app_struktur,"get_struktur"),
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
			url:getUri(app_struktur,"get_anggota_struktur"),
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
</script>