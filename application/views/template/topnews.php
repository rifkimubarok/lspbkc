<style type="text/css">
	.item{
		max-height: 430px;
	}
	.item img{
		width: 100%;
		background-position: center center;
		background-repeat: no-repeat;
	}
	.centered_text{
	      background: rgba(0,0,0,0.5); 
	      padding: 5px;
	      text-align: center;
	      margin: auto;
	}
</style>
	<div class="single-top-post">
		<div class="owl-carousel owl-theme active-gallery-carusel1" id="slider-image">
			<?php 
			foreach($slider as $item){?>
				<div class="item">
					<div class="feature-image-thumb relative">
						<div class="overlay overlay-bg"></div>
						<img class="img-fluid" src="<?=GAMBAR.'slider/'.$item->ref?>" alt="" style="width: 100%">
					</div>
					<div class="top-post-details">
						<!-- <ul class="tags">
							<li><a href="#">Food Habit</a></li>
						</ul> -->
						<a>
							<h3 class="centered_text"><?=$item->description?></h3>
						</a><!-- 
						<ul class="meta">
							<li><a href="#"><span class="lnr lnr-user"></span>Keterangan</a></li>
						</ul> -->
					</div>
				</div>
			<?php } ?>
		</div>
</div>
<!-- 
<div class="col-lg-4 top-post-right">
	<div class="single-top-post">
		<div class="feature-image-thumb relative">
			<div class="overlay overlay-bg"></div>
			<img class="img-fluid" src="<?=IMAGES?>top-post2.jpg" alt="">
		</div>
		<div class="top-post-details">
			<ul class="tags">
				<li><a href="#">Food Habit</a></li>
			</ul>
			<a href="image-post.html">
				<h4>A Discount Toner Cartridge Is Better Than Ever.</h4>
			</a>
			<ul class="meta">
				<li><a href="#"><span class="lnr lnr-user"></span>Mark wiens</a></li>
				<li><a href="#"><span class="lnr lnr-calendar-full"></span>03 April, 2018</a></li>
				<li><a href="#"><span class="lnr lnr-bubble"></span>06 Comments</a></li>
			</ul>
		</div>
	</div>
	<div class="single-top-post mt-10">
		<div class="feature-image-thumb relative">
			<div class="overlay overlay-bg"></div>
			<img class="img-fluid" src="<?=IMAGES?>top-post3.jpg" alt="">
		</div>
		<div class="top-post-details">
			<ul class="tags">
				<li><a href="#">Food Habit</a></li>
			</ul>
			<a href="image-post.html">
				<h4>A Discount Toner Cartridge Is Better</h4>
			</a>
			<ul class="meta">
				<li><a href="#"><span class="lnr lnr-user"></span>Mark wiens</a></li>
				<li><a href="#"><span class="lnr lnr-calendar-full"></span>03 April, 2018</a></li>
				<li><a href="#"><span class="lnr lnr-bubble"></span>06 Comments</a></li>
			</ul>
		</div>
	</div>
</div> -->

<!-- <script type="text/javascript">
	$(document).ready(function() {
		var app_sys = 'home';
		$.ajax({
			url:getUri(app_sys,'get_slider'),
			type:"post",
			dataType:"html",
			success:function(result){
				$('#slider-image').html(result);
			}
		});
	})
</script> -->

<script type="text/javascript">
	$('.active-gallery-carusel1').owlCarousel({
        items:1,
        loop:true,
        nav:true,
        autoplayHoverPause: true,
        autoplay: true,
        singleItem:true,
        navText: ["<div class='centered'><span class='fa fa-arrow-left'></span></div>",
        "<div class='centered'><span class='fa fa-arrow-right'></span></div>"],  
        smartSpeed:650,           
    });
</script>