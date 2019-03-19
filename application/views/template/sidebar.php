<style type="text/css">
	#frm_login img{
		width: 100%;
		height: 100%;
	}
	.fa-frown-o:hover{
		color: red;
		cursor: pointer;
	}
	.fa-meh-o:hover{
		color: #95ad20;
		cursor: pointer;
	}
	.fa-smile-o:hover{
		color: #00cc00;
		cursor: pointer;
	}
	.gsc-search-button-v2{
		padding: 5px 5px 0px !important;
		font-size: 1px !important;
	}
</style>
<?php $member = get_session("user"); ?>
	<div class="sidebars-area">
		<div class="single-sidebar-widget" style="outline: 1px solid #fff; background: #f2f2f2;padding-bottom: 10px;">
			<h6 class="title">Pencarian</h6>
				<form style="padding: 0 10px;" class="">
				    <div class="">
				      <!-- <input id="search" type="text" class="form-control" name="search" placeholder="Pencarian">
				      <span class="input-group-addon" style="padding: 10px; background-color: #ced4da;"><i class="fa fa-search"></i></span> -->
				      <gcse:search></gcse:search>
				    </div>
				</form>
		</div>


		<div class="single-sidebar-widget editors-pick-widget" style="outline: 1px solid #fff; background: #f2f2f2;">
			<?php 
				if(isset($member->islogin) && $member->islogin){
					?>
					<div class="title">
						<div class="profile-picture">
                            <img src="<?=BASEURL?>api/pictures/show_picture/member_docs/thumb_foto_<?=$member->id?>">
                        </div>
                        <div class="dropdown" style="margin-left: 10px;float: left;">
						    <a href="#" class="sf-with-ul" data-toggle="dropdown" style="color: #000!important; font-weight: bold;"><?=$member->nama?>
						    <i class="fa fa-angle-down"></i></a>
						    <div class="nav-menu">
						    	<ul class="dropdown-menu">
							      <li><a href="<?=BASEURL?>member">Profile</a></li>
							      <li><a href="<?=BASEURL?>logout">Logout</a></li>
							    </ul>
						    </div>
						  </div>
                        <div class="clearfix"></div>
					</div>
					<?php
				}else{
			 ?>

			 <h6 class="title">Login Member</h6>
			<form style="padding-bottom: 2px;" id="frm_login">
				<div class="form-group col-md-12">
					<input type="text" class="form-control" name="username" id="username" placeholder="username" required="">
				</div>
				<div class="form-group col-md-12">
					<input type="password" class="form-control" name="password" id="password" placeholder="Password" required="">
				</div>
				<div class="form-group col-md-12">
					<div class="row">
						<div class="col-4" style="padding-right: 0 !important;">
							<?=$captcha->image?>
						</div>
						<div class="col-8">
							<input type="text" class="form-control" name="captha" id="captha" placeholder="Kode Keamanan" required="">
						</div>
					</div>
				</div>
				<div class="form-group col-md-12" >
					<button class="btn btn-primary pull-right" ><i class="fa fa-sign"></i> Login</button>
				</div>
				<div class="clearfix" style="padding-bottom: 5px;"></div>
			</form>

			<?php } ?>
		</div>


        <div class="single-sidebar-widget editors-pick-widget">
            <h6 class="title"><?=$this->lang->line('agenda');?></h6>
            <div class="editors-pick-post">

                <?php
                if(count($agenda)>0){
                $i =1;
                foreach ($agenda as $item) {
                $summery = substr(strip_tags(htmlspecialchars_decode($item->isi_agenda)), 0,150).' ...';
                $tgl_mulai = strtotime($item->tgl_mulai);
                $tgl_selesai = strtotime($item->tgl_selesai);
                $tgl_fix = diff_tg($tgl_mulai,$tgl_selesai);
                if($i == 1){
                ?>
                <div class="feature-img-wrap relative">
                    <div class="feature-img relative" style="max-height: 150px;">
                        <div class="overlay overlay-bg"></div>
                        <img class="img-fluid lazyload" data-src="<?=GAMBAR?>agenda/<?=$item->ref?>" alt="" style="width: 100%;">
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
                                <img class="img-fluid lazyload" data-src="<?=GAMBAR?>agenda/<?=$item->ref?>" alt="" style="width: 100%;">
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
                <a href="<?=BASEURL?>agenda"><button class="btn btn-danger btn-sm" style="padding: 5px !important;font-size: 80%;"><?=$this->lang->line('agenda_lainnya');?></button></a>
            </div>
        </div>


        <script type="text/javascript">
	$(document).ready(function() {
        lazyload();
		/*var url = document.URL;
		var segment = url.split('/');
		if(segment[3] == '' || segment[3] == 'home'){
			var audio = document.getElementById("backsong");
			audio.play();
		}*/
		/*var myAudio = document.getElementById('my-audio');

		var bufferedTimeRanges = myAudio.buffered;*/

		// load_audio();
		action_polling();

		$('#frm_login').submit(function() {
			$.ajax({
		        url:getUri("auth","verifikasi"),
		        type:"post",
		        dataType:"JSON",
		        data:$('#frm_login').serialize(),
		        beforeSend:loading_screen,
		        success:function(result) {
		            if(result.status){
		                window.location.reload();
		            }else{
		            	swal({
		            		title:"",
		            		text:result.message,
		            		type:"warning"
		            	},function() {
		            		window.location.reload();
		            	});
		            }
		        },
		        complete:function() {
		        },
		        error:function() {
		        	gagal_screen();
		        }
		    });
	    	return false;
		})
	})

	function save_polling(item) {
		var kepuasan = $(item).attr("data-value");
		$.ajax({
			url:getUri("home","save_polling"),
			type:"post",
			dataType:"JSON",
			data:{kepuasan:kepuasan},
			beforeSend:loading_screen,
			success:function(result) {
				$('#btn_save_poling').fadeOut();
				swal.close();
			},
			error:gagal_screen
		})
	}

	function load_audio() {
		var url = document.URL;
		var segment = url.split('/');
		if(segment[3] == '' || segment[3] == 'home'){
			var audio_html = '<audio controls autoplay><source src="'+getUri('assets','backsong/marskirab.mp3')+'" type="audio/mpeg">Your browser does not support the audio element.</audio>';
		}else{
			var audio_html = '<audio controls><source src="'+getUri('assets','backsong/marskirab.mp3')+'" type="audio/mpeg">Your browser does not support the audio element.</audio>';
		}
		$('#mars_audio').html(audio_html);
	}

	function action_polling() {
		$.ajax({
			url:getUri("home","get_status_poll"),
			type:"POST",
			dataType:"JSON",
			success:function(result) {
				if(result.waspoll == 0){
					$('.fa-frown-o').click(function() {
					$('#txt_kepuasan').text("Tidak Puas");
					$('.fa-frown-o').css("color","#ff0000");
					$('.fa-meh-o').css("color","#000");
					$('.fa-smile-o').css("color","#000");
					$('#btn_save_poling').attr("data-value","3");
					$('#btn_save_poling').fadeIn(200);
					})
					$('.fa-meh-o').click(function() {
						$('#txt_kepuasan').text("Netral");
						$('.fa-frown-o').css("color","#000");
						$('.fa-meh-o').css("color","#95ad20");
						$('.fa-smile-o').css("color","#000");
						$('#btn_save_poling').attr("data-value","2");
						$('#btn_save_poling').fadeIn(200);
					})
					$('.fa-smile-o').click(function() {
						$('#txt_kepuasan').text("Puas");
						$('.fa-frown-o').css("color","#000");
						$('.fa-meh-o').css("color","#000");
						$('.fa-smile-o').css("color","#00cc00");
						$('#btn_save_poling').attr("data-value","1");
						$('#btn_save_poling').fadeIn(200);
					})
				}else{
					if(result.kepuasan == 1){
						$('#txt_kepuasan').text("Puas");
						$('.fa-smile-o').css("color","#00cc00");
					}
					if(result.kepuasan == 2){
						$('#txt_kepuasan').text("Netral");
						$('.fa-meh-o').css("color","#95ad20");
					}
					if(result.kepuasan == 3){
						$('#txt_kepuasan').text("Tidak Puas");
						$('.fa-frown-o').css("color","#ff0000");
					}
				}
			}
		})
		
	}
</script>
<script>
  (function() {
    var cx = '009583725241159662257:gudg3gcjs3a';
    var gcse = document.createElement('script');
    gcse.type = 'text/javascript';
    gcse.async = true;
    gcse.src = 'https://cse.google.com/cse.js?cx=' + cx;
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(gcse, s);
  })();
</script>