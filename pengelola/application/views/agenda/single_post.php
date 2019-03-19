<?php
	$item = '';
	foreach ($agenda as $it) {
		$item = $it;
	}
	$tgl_mulai = strtotime($item->tgl_mulai);
	$tgl_selesai = strtotime($item->tgl_selesai);
	$tgl_fix = diff_tg($tgl_mulai,$tgl_selesai);
	$sosmed = new myObject();
	$sosmed->facebook = "MyWindow=window.open('".share_url("facebook",array("url"=>BASEURL."agenda/p/".$item->tema_seo,"text"=>$item->tema))."',          'MyWindow','width=600,height=300'); return false;";
	$sosmed->twitter =  "MyWindow=window.open('".share_url("twitter",array("url"=>BASEURL."agenda/p/".$item->tema_seo,"text"=>$item->tema))."',          'MyWindow','width=600,height=300'); return false;";
	$sosmed->gplus = "MyWindow=window.open('".share_url("google-plus",array("url"=>BASEURL."agenda/p/".$item->tema_seo,"text"=>$item->tema))."','MyWindow','width=600,height=300'); return false;";
	$sosmed->whatsapp = "MyWindow=window.open('".share_url("whatsapp",array("url"=>BASEURL."agenda/p/".$item->tema_seo,"text"=>$item->tema))."','MyWindow','width=600,height=300'); return false;";
?>
<style type="text/css">
	.btn-primary{
		border-color : #fff !important;
	}
</style>
<div class="single-post-wrap">
	<div class="feature-img-thumb relative">
		<div class="overlay overlay-bg"></div>
		<img class="img-fluid" src="<?=GAMBAR?>agenda/<?=$item->ref?>" alt="">
	</div>
	<div class="content-wrap">
		<ul class="tags mt-10">
			<li><a href="#"><?=$tgl_fix?></a></li>
		</ul> 
		<a href="#">
			<h3><?=$item->tema?></h3>
		</a>
		<ul class="meta pb-20">
			<li><a href="#"><span class="lnr lnr-user"></span><?=$item->pengirim?></a></li>
			<li><a href="#"><span class="lnr lnr-calendar-full"></span><?=$tgl_fix?></a></li>
			<li><a href="#"><span class="lnr lnr-clock"></span><?=$item->jam?> </a></li>
		</ul>
		<p>
			<?=htmlspecialchars_decode($item->isi_agenda)?>
		</p>
	
	<div class="d-flex">
		<i class="fa fa-share-alt" style="font-size: 2em;padding: 5px 7px;"></i>
		<a class="btn btn-primary btn-sm" href="#" onclick="<?=$sosmed->facebook?>" style="background: #4c63a2 !important;"><i class="fa fa-facebook" style="width: 25px;padding: 5px 7px;"></i></a>&nbsp;
		<a class="btn btn-primary btn-sm" href="#" onclick="<?=$sosmed->twitter?>" style="background: #69c9ff !important;"><i class="fa fa-twitter" style="width: 25px;padding: 5px 7px;"></i></a> &nbsp;
		<a class="btn btn-primary btn-sm" href="#" onclick="<?=$sosmed->gplus?>" style="background: #db4437 !important;"><i class="fa fa-google-plus" style="width: 25px;padding: 5px 7px;"></i></a>&nbsp;
		<a class="btn btn-primary btn-sm" href="#" onclick="<?=$sosmed->whatsapp?>" style="background: #01E675 !important;"><i class="fa fa-whatsapp" style="width: 25px;padding: 5px 7px;"></i></a>
	</div>
	
	<div class="comment-sec-area">
		<div class="container">
			<div class="row flex-column">
				<h6>05 Comments</h6>
				<div class="comment-list">
					<div class="single-comment justify-content-between d-flex">
						<div class="user justify-content-between d-flex">
							<div class="thumb">
								<img src="<?=IMAGES?>blog/c1.jpg" alt="">
							</div>
							<div class="desc">
								<h5><a href="#">Emilly Blunt</a></h5>
								<p class="date">December 4, 2017 at 3:12 pm </p>
								<p class="comment">
									Never say goodbye till the end comes!
								</p>
							</div>
						</div>
						<div class="reply-btn">
							<a href="" class="btn-reply text-uppercase">reply</a>
						</div>
					</div>
				</div>
				<div class="comment-list left-padding">
					<div class="single-comment justify-content-between d-flex">
						<div class="user justify-content-between d-flex">
							<div class="thumb">
								<img src="<?=IMAGES?>blog/c2.jpg" alt="">
							</div>
							<div class="desc">
								<h5><a href="#">Emilly Blunt</a></h5>
								<p class="date">December 4, 2017 at 3:12 pm </p>
								<p class="comment">
									Never say goodbye till the end comes!
								</p>
							</div>
						</div>
						<div class="reply-btn">
							<a href="" class="btn-reply text-uppercase">reply</a>
						</div>
					</div>
				</div>
				<div class="comment-list">
					<div class="single-comment justify-content-between d-flex">
						<div class="user justify-content-between d-flex">
							<div class="thumb">
								<img src="<?=IMAGES?>blog/c3.jpg" alt="">
							</div>
							<div class="desc">
								<h5><a href="#">Emilly Blunt</a></h5>
								<p class="date">December 4, 2017 at 3:12 pm </p>
								<p class="comment">
									Never say goodbye till the end comes!
								</p>
							</div>
						</div>
						<div class="reply-btn">
							<a href="" class="btn-reply text-uppercase">reply</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="comment-form">
	<h4>Post Comment</h4>
	<form>
		<div class="form-group form-inline">
			<div class="form-group col-lg-6 col-md-12 name">
				<input type="text" class="form-control" id="name" placeholder="Enter Name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Name'">
			</div>
			<div class="form-group col-lg-6 col-md-12 email">
				<input type="email" class="form-control" id="email" placeholder="Enter email address" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter email address'">
			</div>
		</div>
		<div class="form-group">
			<input type="text" class="form-control" id="subject" placeholder="Subject" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Subject'">
		</div>
		<div class="form-group">
			<textarea class="form-control mb-10" rows="5" name="message" placeholder="Messege" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Messege'" required=""></textarea>
		</div>
		<a href="#" class="primary-btn text-uppercase">Post Comment</a>
	</form>
</div>
</div>