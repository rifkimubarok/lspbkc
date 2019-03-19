<?php 
echo json_encode($slider);
foreach($slider as $item){?>
	<div class="item">
		<div class="feature-image-thumb relative">
			<div class="overlay overlay-bg"></div>
			<img class="img-fluid" src="<?=$item->image_path?>" alt="" style="width: 100%">
		</div>
		<div class="top-post-details">
			<!-- <ul class="tags">
				<li><a href="#">Food Habit</a></li>
			</ul> -->
			<a href="image-post.html">
				<h3 class="centered_text"><?=$item->description?></h3>
			</a><!-- 
			<ul class="meta">
				<li><a href="#"><span class="lnr lnr-user"></span>Keterangan</a></li>
			</ul> -->
		</div>
	</div>
<?php } ?>