<?php
	if(count($forum)>0){
		foreach ($forum as $item) {
			$summery = substr(strip_tags(htmlspecialchars_decode($item->content)), 0,150).' ...';
?>
		<div class="single-latest-post row align-items-center">
			<div class="col-lg-12 post-right" style="margin: auto 20px;">
				<a href="<?=BASEURL?>forum/detail/<?=$item->seo_judul?>" click='1'>
					<h4 style="text-align: justify;max-width: 100% !important;"><?=$item->judul_forum?></h4>
				</a>
				<ul class="meta" style="margin: 0px !important;">
					<li><a href="#"><span class="lnr lnr-user"></span><?=$item->nama_pengirim?></a></li>
					<li><a href="#"><span class="lnr lnr-calendar-full"></span><?=date("d F, Y",strtotime($item->date_insert))?></a></li>
					<li><a href="#"><span class="lnr lnr-eye"></span><?=number_format($item->view_counter,0)?>x dilihat</a></li>
				</ul>
				<p class="excert" style="text-align: justify;padding-right:25px;">
					<?=$summery?>
				</p>
			</div>
		</div>
<?php
		}
	}else{
		?>
		<p style="text-align: center;">Belum Ada Konten Forum Diskusi</p>
		<?php
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