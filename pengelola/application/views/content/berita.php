<?php
	if(count($berita)>0){
		foreach ($berita as $item) {
			$summery = substr(strip_tags($item->isi_berita), 0,150).' ...';
?>
		<div class="single-latest-post row align-items-center">
			<div class="col-lg-5 post-left">
				<div class="feature-img relative">
					<div class="overlay overlay-bg"></div>
					<a href="<?=BASEURL?>berita/p/<?=$item->judul_seo?>" click='1'>
					<img class="img-fluid" src="<?=THUMB?>berita/<?=$item->ref?>" alt="" style="width: 100%;">
					</a>
				</div>
				<ul class="tags">
					<li><a href="#" click='1'><?=$item->nama_kategori?></a></li>
				</ul>
			</div>
			<div class="col-lg-7 post-right">
				<a href="<?=BASEURL?>berita/p/<?=$item->judul_seo?>" click='1'>
					<h4 style="text-align: justify;max-width: 100% !important;"><?=$item->judul?></h4>
				</a>
				<ul class="meta">
					<li><a href="#"><span class="lnr lnr-user"></span><?=$item->nama_lengkap?></a></li>
					<li><a href="#"><span class="lnr lnr-calendar-full"></span><?=date("d F, Y",strtotime($item->tanggal))?></a></li>
					<li><a href="#"><span class="lnr lnr-eye"></span><?=number_format($item->dibaca,0)?>x Dilihat</a></li>
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
<?php } ?>

<script type="text/javascript">
	$('.single-latest-post a').click(function() {
		console.log(parseInt($(this).attr('click')));
		if(parseInt($(this).attr('click')) != 1){
			return false;
		}
	});
</script>