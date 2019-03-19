<?php
	if(count($berita)>0){
		foreach ($berita as $item) {
			$summery = substr(strip_tags(htmlspecialchars_decode($item->isi_berita)), 0,150).' ...';
?>
		<div class="single-latest-post row align-items-center">
			<div class="col-lg-5 post-left">
				<div class="feature-img relative">
					<a href="<?=BASEURL?>artikel/p/<?=$item->judul_seo?>" click='1'>
						<div class="overlay overlay-bg"></div>
						<img class="img-fluid lazyload" data-src="<?=GAMBAR?>berita/<?=$item->ref?>" alt="" style="width: 100%;">
					</a>
				</div>
				<ul class="tags">
					<li><a href="#" click='1'><?=$item->nama_kategori?></a></li>
				</ul>
			</div>
			<div class="col-lg-7 post-right">
				<a href="<?=BASEURL?>artikel/p/<?=$item->judul_seo?>" click='1'>
					<h4 style="text-align: justify;max-width: 100% !important;"><?=$item->judul?></h4>
				</a>
				<ul class="meta">
					<li><a href="#"><span class="lnr lnr-user"></span><?=$item->nama_lengkap?></a></li>
					<li><a href="#"><span class="lnr lnr-calendar-full"></span><?=date("d F, Y",strtotime($item->tanggal))?></a></li>
					<li><a href="#"><span class="lnr lnr-eye"></span><?=number_format($item->dibaca,0)?>x <?=$this->lang->line('seen')?></a></li>
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
	$(document).ready(function () {
        lazyload();
    })
</script>