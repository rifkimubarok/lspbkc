<style type="text/css">
	#frm_login img{
		width: 100%;
		height: 100%;
	}
</style>
<div class="col-lg-4">
	<div class="sidebars-area">
		<div class="single-sidebar-widget editors-pick-widget" style="outline: 1px solid #fff; background: #f2f2f2;">
			<h6 class="title">Login Member</h6>
			<form style="padding-bottom: 2px;" id="frm_login">
				<div class="form-group col-md-12">
					<input type="text" class="form-control" name="username" id="username" placeholder="username">
				</div>
				<div class="form-group col-md-12">
					<input type="password" class="form-control" name="password" id="password" placeholder="Password">
				</div>
				<div class="form-group col-md-12">
					<div class="row">
						<div class="col-4" style="padding-right: 0 !important;">
							<?=$captcha->image?>
						</div>
						<div class="col-8">
							<input type="text" class="form-control" name="captha" id="captha" placeholder="Kode Keamanan">
						</div>
					</div>
				</div>
				<div class="form-group col-md-12" >
					<button class="btn btn-primary pull-right" ><i class="fa fa-sign"></i> Login</button>
				</div>
				<div class="clearfix" style="padding-bottom: 5px;"></div>
			</form>
		</div>


		<div class="single-sidebar-widget editors-pick-widget">
			<h6 class="title">Agenda Akan Datang</h6>
			<div class="editors-pick-post">

			<?php
			if(count($agenda)>0){
				$i =1;
				foreach ($agenda as $item) { 
					$summery = substr(strip_tags($item->isi_agenda), 0,150).' ...';
					$tgl_mulai = strtotime($item->tgl_mulai);
					$tgl_selesai = strtotime($item->tgl_selesai);
					$tgl_fix = diff_tg($tgl_mulai,$tgl_selesai);
					if($i == 1){
			?>
				<div class="feature-img-wrap relative">
					<div class="feature-img relative" style="max-height: 150px;">
						<div class="overlay overlay-bg"></div>
						<img class="img-fluid" src="<?=GAMBAR?>agenda/<?=$item->ref?>" alt="" style="width: 100%;">
					</div>
					<ul class="tags">
						<li><a href="#"><?=$tgl_fix?></a></li>
					</ul>
				</div>
				<div class="details">
					<a href="<?=BASEURL?>agenda/p/<?=$item->tema_seo?>">
						<h4 class="mt-20" style="text-align: justify;"><?=$item->tema?>.</h4>
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
				<div class="post-lists">
			<?php }else{ ?>
					<div class="single-post d-flex flex-row">
						<div style="max-width: 110px;">
							<img class="img-fluid" src="<?=GAMBAR?>agenda/<?=$item->ref?>" alt="" style="width: 100%;">
						</div>
						<div class="detail" style="width: 80%;">
							<a href="<?=BASEURL?>agenda/p/<?=$item->tema_seo?>"><h6><?=$item->tema?></h6></a>
							<ul class="meta">
								<li><a href="#"><span class="lnr lnr-calendar-full"></span><?=$tgl_fix?></a></li>

								<li><a href="#"><span class="lnr lnr-clock"></span><?=$item->jam?> </a></li>
							</ul>
						</div>
					</div>

			<?php 		}  $i++;
					} 
				} ?>
			</div>
			</div>

			<div class="form-group" style="padding-top: 15px;text-align: right;">
				<a href="<?=BASEURL?>agenda"><button class="btn btn-danger btn-sm" style="padding: 5px !important;font-size: 80%;">Muat Agenda Lainnya</button></a>
			</div>
		</div>
		
		<div class="single-sidebar-widget most-popular-widget">
			<h6 class="title">Most Popular</h6>
			<?php
				for ($i=1; $i < 5 ; $i++) { 
					$date = date("Y-m-d")." - ".$i." days";
					$tgl = date("d F, Y",strtotime($date));
			?>
			<div class="single-list flex-row d-flex">
				<div class="thumb">
					<img src="<?=IMAGES?>m<?=$i?>.jpg" alt="">
				</div>
				<div class="details">
					<a href="image-post.html">
						<h6>Help Finding Information
						Online is so easy</h6>
					</a>
					<ul class="meta">
						<li><a href="#"><span class="lnr lnr-calendar-full"></span><?=$tgl?></a></li>
						<li><a href="#"><span class="lnr lnr-bubble"></span><?=$i+2?></a></li>
					</ul>
				</div>
			</div>
			<?php } ?>
		</div>

		<div class="single-sidebar-widget social-network-widget" style="background: #f2f2f2;">
			<h6 class="title">Statistik Pengunjung</h6>
			<div class="box" style="padding: 5px;">
                <div>
                  <img src="<?=IMAGES?>user.png"> Pengunjung hari ini : <strong><?=$statistik->pengunjung?></strong> <br>
                  <img src="<?=IMAGES?>user.png"> Total pengunjung    : <strong><?=$statistik->totalpengunjung?></strong> <br><br>
                  
                  <img src="<?=IMAGES?>user.png"> Hits hari ini  :  <strong><?=$statistik->hits?></strong><br>
                  <img src="<?=IMAGES?>user.png"> Total hits     :  <strong><?=$statistik->totalhits?></strong><br><br> 
                  
                  <img src="<?=IMAGES?>user.png"> Pengunjung Online : <strong><?=$statistik->online?></strong>
                 </div>                          
            </div>
		</div>


		<div class="single-sidebar-widget social-network-widget">
			<h6 class="title">Social Networks</h6>
			<ul class="social-list">
				<li class="d-flex justify-content-between align-items-center fb">
					<div class="icons d-flex flex-row align-items-center">
						<i class="fa fa-facebook" aria-hidden="true"></i>
						<p>983 Likes</p>
					</div>
					<a href="#">Like our page</a>
				</li>
				<li class="d-flex justify-content-between align-items-center tw">
					<div class="icons d-flex flex-row align-items-center">
						<i class="fa fa-twitter" aria-hidden="true"></i>
						<p>983 Followers</p>
					</div>
					<a href="#">Follow Us</a>
				</li>
				<li class="d-flex justify-content-between align-items-center yt">
					<div class="icons d-flex flex-row align-items-center">
						<i class="fa fa-youtube-play" aria-hidden="true"></i>
						<p>983 Subscriber</p>
					</div>
					<a href="#">Subscribe</a>
				</li>
				<li class="d-flex justify-content-between align-items-center rs">
					<div class="icons d-flex flex-row align-items-center">
						<i class="fa fa-rss" aria-hidden="true"></i>
						<p>983 Subscribe</p>
					</div>
					<a href="#">Subscribe</a>
				</li>
			</ul>
		</div>
		
	</div>
</div>