<?php
	if(count($agenda)>0){
		foreach ($agenda as $item) {
			$summery = substr(strip_tags(htmlspecialchars_decode($item->isi_agenda)), 0,150).' ...';
			$tgl_mulai = strtotime($item->tgl_mulai);
			$tgl_selesai = strtotime($item->tgl_selesai);
			$tgl_fix = diff_tg($tgl_mulai,$tgl_selesai);
?>
		<div class="single-latest-post row align-items-center">
			<div class="col-lg-5 post-left">
				<div class="feature-img relative">
					<div class="overlay overlay-bg"></div>
					<a href="<?=BASEURL?>agenda/p/<?=$item->tema_seo?>" click='1'>
					<img class="img-fluid" src="<?=GAMBAR?>agenda/<?=$item->ref?>" alt="" style="width: 100%;">
					</a>
				</div>
				<ul class="tags">
					<li><a href="#" click='1'><?=$tgl_fix?></a></li>
				</ul>
			</div>
			<div class="col-lg-7 post-right">
				<a href="<?=BASEURL?>agenda/p/<?=$item->tema_seo?>" click='1'>
					<h4 style="text-align: justify;max-width: 100% !important;"><?=$item->tema?></h4>
				</a>
				<ul class="meta">
					<li><a href="#"><span class="lnr lnr-user"></span><?=$item->pengirim?></a></li>
					<li><a href="#"><span class="lnr lnr-calendar-full"></span><?=$tgl_fix?></a></li>
					<li><a href="#"><span class="lnr lnr-clock"></span><?=$item->jam?> </a></li>
				</ul>
				<p class="excert" style="text-align: justify;">
					<?=$summery?>
				</p>
			</div>
		</div>
<?php
		}
	}
	if(isset($links)){
?>


	<div class="load-more">
		<!-- <a href="#" class="primary-btn">Load More Posts</a> -->
		<div class="pagination">
	    <?php
		        echo "<li class='pagination-id'>". $links."</li>";
	    ?>
    	</div>
    	<div class="clearfix"></div>
	</div>
	<?php
	}
	?>

<script type="text/javascript">
	$('.single-latest-post a').click(function() {
		console.log(parseInt($(this).attr('click')));
		if(parseInt($(this).attr('click')) != 1){
			return false;
		}
	});
</script>