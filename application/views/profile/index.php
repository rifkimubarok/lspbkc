<div class="single-post-wrap">
	<!-- <div class="feature-img-thumb relative">
		<div class="overlay overlay-bg"></div>
		<img class="img-fluid" src="<?=IMAGES?>f1.jpg" alt="">
	</div> -->
	<div class="content-wrap">
	<!-- 	<ul class="tags mt-10">
			<li><a href="#">Food Habit</a></li>
		</ul> -->
		<a href="<?=BASEURL?>hal/<?=$profile->id_halaman?>/<?=$profile->judul_seo?>">
			<h3><?=$profile->judul?></h3>
			<hr>
		</a>
		<ul class="meta pb-20">
		</ul>
		<p align="justify">
			<?=htmlspecialchars_decode($profile->isi_halaman) ?>
		</p>
	<div class="clearfix"></div>
</div>
</div>