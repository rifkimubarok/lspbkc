
<!DOCTYPE html>
<html lang="zxx" class="no-js">
	<head>
		<!-- Mobile Specific Meta -->
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!-- Favicon-->
		<link rel="shortcut icon" href="<?=IMAGES?>fav.png">
		<!-- Meta Keyword -->
		<meta name="keywords" content="LSP SMK BHAKTI KENCANA CIAMIS">
		<!-- meta character set -->
		<meta charset="UTF-8">
		<?php
			$title = $_title!= '' ? $_title.' | LSP SMK BHAKTI KENCANA CIAMIS' : 'LSP SMK BHAKTI KENCANA CIAMIS';
			$gambar = isset($image) == true ? $image:'';
			echo meta_tags($title,'',$gambar,current_url());
			$_statistik->count();
		?>
		<!-- Site Title -->
		<title><?=$title?></title>
		<link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet">
		<!--
		CSS
		============================================= -->
		<link rel="stylesheet" href="<?=CSS?>linearicons.css">
		<link rel="stylesheet" href="<?=VENDORS?>font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?=CSS?>bootstrap.css">
		<link rel="stylesheet" href="<?=CSS?>magnific-popup.css">
		<link rel="stylesheet" href="<?=CSS?>nice-select.css">
		<link rel="stylesheet" href="<?=CSS?>animate.min.css">
		<link rel="stylesheet" href="<?=CSS?>owl.carousel.css">
		<link rel="stylesheet" href="<?=CSS?>owl.theme.default.css">
		<link rel="stylesheet" href="<?=CSS?>jquery-ui.css">
		<link rel="stylesheet" href="<?=CSS?>main.css">
		<link rel="stylesheet" href="<?=VENDORS?>ResponsiveSlides/responsiveslides.css">
		<link rel="stylesheet" href="<?=VENDORS?>nanogallery/css/nanogallery2.min.css">
		<link rel="stylesheet" href="<?=VENDORS?>sweet-alert/sweet-alert.min.css">
    	<link rel="stylesheet" type="text/css" href="<?=VENDORS?>datatables/css/dataTables.bootstrap.css">
        <link href="<?=VENDORS?>summernote/dist/summernote.css" rel="stylesheet" />
    	<style type="text/css">
    		
		.profile-picture {
            position:relative;
            overflow:hidden;
            border-radius: 50%;
            height: 32px;
            width: 32px;
            float: left;
        }

        .profile-picture img {
            position:absolute;
            height: auto;
            width: auto;    
            max-width:100%;
        }

        .centered img {
            position:absolute;
            top:50%;
            transform:translateY(-50%);
        }

            .border-yellow{
                border-bottom-style: solid;
                border-bottom-color: #ffb607;
                box-shadow: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23);
            }
    	</style>

		<script>
			var sw = '/sw.js';
			if ('serviceWorker' in navigator) {
				window.addEventListener("load",function(){document.getElementById("output");navigator.serviceWorker.register(sw).then(function(e){}).catch(function(e){})});
			}
		</script>
	</head>
	<body>
		<header>
			
			<!-- <div class="header-top">
				<div class="container">
					<div class="row">
						<div class="col-lg-6  col-md-6 col-sm-6 col-6 header-top-left no-padding">
							<ul>
								<li><a href="#"><i class="fa fa-facebook"></i></a></li>
								<li><a href="#"><i class="fa fa-twitter"></i></a></li>
								<li><a href="#"><i class="fa fa-dribbble"></i></a></li>
								<li><a href="#"><i class="fa fa-behance"></i></a></li>
								<li><a href="tel:+440 012 3654 896"><span class="lnr lnr-phone-handset"></span><span>+440 012 3654 896</span></a></li>
								<li><a href="mailto:support@colorlib.com"><span class="lnr lnr-envelope"></span><span>support@colorlib.com</span></a></li>
							</ul>
						</div>

						
						<div class="col-lg-6 col-md-6 col-sm-6 col-6 header-top-right no-padding">
							<div class="navbar-right">
							<form class="Search">
								<input type="text" class="form-control Search-box" name="Search-box" id="Search-box" placeholder="Search">
								<label for="Search-box" class="Search-box-label">
									<span class="lnr lnr-magnifier"></span>
								</label>
								<span class="Search-close">
									<span class="lnr lnr-cross"></span>
								</span>
							</form>
							</div>
						</div>
					</div>
				</div>
			</div> -->
			<div class="container header-footer" style="background: #fff;box-shadow: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23);">
				<div class="row justify-content-between align-items-center">
					<div class="col-md-12 no-padding">
						<div class="row">
							<div class="col-md-8" >
								<div style="width: 80px;height: 80px;float: left; padding-left: 10px;margin-right:15px;">
								<img class="img-fluid" src="<?=IMAGES?>icon.png" style="width: 100%;">
								</div>
								<h4 style="margin: auto;">
									<p style="font-size: 100%;margin-top: 15px !important;">LEMBAGA SERTIFIKASI PROFESI
									<br><span style="font-size: 13px;font-weight: 500;">SMK BHAKTI KENCANA CIAMIS</span></p>
								</h4>
							</div>
							<div class="col-md-4" style="text-align:center;">
								<!-- <div style="background-position: bottom right; width: 100%;height: 100%;"></div> -->
								<p style="font-size: 100%;margin-top: 15px !important;">
                                    <span><i class="fa fa-phone" style="color:#ffc107; padding-right:5px;"></i> Hubungi Kami <a href="tel:0265771204" style="color:#444;">(0265) 771204</a></span><br>
                                    <span><i class="fa fa-envelope" style="color:#ffc107;padding-right:5px;"></i> <a href="mailto:surat@smkn1cms.net" style="color:#444;">surat@smkbhaktikencana.sch.id</a></span>
                                </p>
							</div>
						<!-- <div class="col-md-8">
							
						</div>
						<div class="col-md-2 pull-right" style="text-align: center;">
							<img class="img-fluid" src="<?=IMAGES?>logo.png" style="width: 50%;">
						</div> -->
						</div>
					</div>
				</div>
			</div>


			<script src="<?=JS?>vendor/jquery-2.2.4.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/lazyload@2.0.0-beta.2/lazyload.js"></script>
            <!--
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script> -->
			<script src="<?=JS?>popper.min.js"></script>
			<script src="<?=JS?>vendor/bootstrap.min.js"></script>
			<script src="<?=JS?>easing.min.js"></script>
			<script src="<?=JS?>hoverIntent.js"></script>
			<script src="<?=JS?>superfish.min.js"></script>
			<script src="<?=JS?>jquery.ajaxchimp.min.js"></script>
			<script src="<?=JS?>jquery.magnific-popup.min.js"></script>
			<script src="<?=JS?>mn-accordion.js"></script>
			<script src="<?=JS?>jquery-ui.js"></script>
			<script src="<?=JS?>jquery.nice-select.min.js"></script>
			<script src="<?=JS?>owl.carousel.min.js"></script>
			<script src="<?=JS?>mail-script.js"></script>
			<script src="<?=JS?>main.js"></script>
			<script src="<?=JS?>myScript.js"></script>
			<script src="<?=JS?>backtop.js"></script>
			<script src="<?=VENDORS?>ResponsiveSlides/responsiveslides.js"></script>
			<script src="<?=VENDORS?>nanogallery/jquery.nanogallery2.min.js"></script>
			<script src="<?=VENDORS?>sweet-alert/sweet-alert.min.js"></script>
			<script type="text/javascript" src="<?=VENDORS?>datatables/js/jquery.dataTables.js"></script>
			<script type="text/javascript" src="<?=VENDORS?>datatables/js/dataTables.bootstrap.js"></script>
			<script type="text/javascript" src="<?=VENDORS?>inputmask/jquery.inputmask.bundle.min.js"></script>
        	<script src="<?=VENDORS?>summernote/dist/summernote.js"></script>
<!-- <script type="text/javascript" src="<?=VENDORS?>datatables/js/dataTables.bootstrap.min.js"></script> -->

			<div class="container main-menu border-yellow" id="main-menu">
				<div class="row align-items-center justify-content-between">
						<nav id="nav-menu-container">
							<?=$_menu?>
						</nav><!-- #nav-menu-container -->
				</div>
			</div>
		</header>
		
		<div class="site-main-container" style="margin-top: 5px;" id="homepage">
			<!-- Start top-post Area -->
			<section class="top-post-area">
				<div class="container no-padding">
					<div class="row small-gutters" >
						<?php
							if ((is_null($_segment)) || $_segment == 'home') {
								?>
								<div class="show_page col-lg-12 top-post-left" data-value="_topnews">
									<p style="text-align: center; color: #AAAAAA;padding: 30px;"><i class="fa fa-spinner fa-spin fa-3x"></i><br />Loading Page</p>
								</div>
								<?php
							}
						?>
					</div>
				</div>
			</section>
			<!-- End top-post Area -->
			<!-- Start latest-post Area -->
			
			<?php if($_segment !=null && ($_segment == "kontak" || $_segment == "galeri")){?>
				<section class="contact-page-area pb-30">
					<div class="container">
							<?=$_content?>
					</div>
				</section>
						<?php } else {?>
				<section class="latest-post-area pb-30">
					<div class="container no-padding">
						<div class="row">
							<div class="col-lg-8 post-list">
								<!-- Start latest-post Area -->
								<?=$_content?>
								<!-- End latest-post Area -->
								
								<!-- Start banner-ads Area -->
								<!-- End banner-ads Area -->
								<!-- Start popular-post Area -->
								<!-- End popular-post Area -->
								<!-- Start relavent-story-post Area -->
								<!-- End relavent-story-post Area -->
								</div>
								
								<div class="show_page col-lg-4" data-value="_sidebar">
									<p style="text-align: center; color: #AAAAAA;padding: 30px;"><i class="fa fa-spinner fa-spin fa-3x"></i><br />Loading Page</p>
								</div>
							</div>
						</div>
					</section>
						<?php } ?>
			<!-- End latest-post Area -->
		</div>
		
		<!-- start footer Area -->
		<div class="container footer-area header-footer">
			<footer class="footer-area section-gap">
				<div class="row">
					<div class="col-lg-4 col-md-6 single-footer-widget">
						<h4>Akses Cepat</h4>
						<ul>
							<li><a href="<?=BASEURL?>berita">Berita Terbaru</a></li>
							<li><a href="<?=BASEURL?>agenda">Agenda Kegitan</a></li>
							<li><a href="<?=BASEURL?>forum">Forum Diskusi</a></li>
						</ul>
					</div>
					<div class="col-lg-4 col-md-6 single-footer-widget">
						<h4><?=$this->lang->line('bahasa');?></h4>
						<ul>
							<!-- <li><a href="<?=BASEURL?>setlanguage/set/indonesia">Indonesia</a></li>
							<li><a href="<?=BASEURL?>setlanguage/set/english"><?=$this->lang->line('english');?></a></li> -->
							<li id="gtranslate"></li>
						</ul>
					</div>
					<div class="col-lg-4 col-md-6 newsletter-widget single-footer-widget">
						<h4>Newsletter</h4>
						<div class="form-group d-flex flex-row">
							<div class="col-autos">
								<div class="input-group">
									<input class="form-control" placeholder="Email Address" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email Address'" type="text">
								</div>
							</div>
							<a href="#" class="bbtns">Subcribe</a>
						</div>
					</div>
				</div>
				<div class="footer-bottom row align-items-center">
					<p class="footer-text m-0 col-lg-8 col-md-12"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | <a href="<?=base()?>" target="_blank" style="color: white;">LSP SMK BHAKTI KENCANA CIAMIS</a>
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
					<div class="col-lg-4 col-md-12 footer-social">
						<a href="#"><i class="fa fa-facebook"></i></a>
						<a href="#"><i class="fa fa-twitter"></i></a>
						<a href="#"><i class="fa fa-dribbble"></i></a>
						<a href="#"><i class="fa fa-behance"></i></a>
					</div>
				</div>
			</div>
		</footer>
		<!-- End footer Area -->
		<script type="text/javascript">
			$(document).ready(function() {

				loadModul($('#homepage'));
 
			  $("#slider2").responsiveSlides({
		        auto: true,
		        pager: false,
		        speed: 300,
        		nav: true,
       			namespace: "callbacks",
		      });
			});
			

	    	function googleTranslateElementInit() {
			  new google.translate.TranslateElement({pageLanguage: 'id'}, 'gtranslate');
			}
			
		</script>
		
		<script type="text/javascript" src="<?=JS?>custom.js"></script>
		<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
	</body>
</html>