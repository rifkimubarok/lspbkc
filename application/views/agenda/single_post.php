<?php
	if(count($agenda)<1){
		redirect("404");
	}
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
	
	<div class="clearfix"></div>
	<div class="d-flex" style="padding-top: 60px;">
		<i class="fa fa-share-alt" style="font-size: 2em;padding: 5px 7px;"></i>
		<a class="btn btn-primary btn-sm" href="#" onclick="<?=$sosmed->facebook?>" style="background: #4c63a2 !important;"><i class="fa fa-facebook" style="width: 25px;padding: 5px 7px;"></i></a>&nbsp;
		<a class="btn btn-primary btn-sm" href="#" onclick="<?=$sosmed->twitter?>" style="background: #69c9ff !important;"><i class="fa fa-twitter" style="width: 25px;padding: 5px 7px;"></i></a> &nbsp;
		<a class="btn btn-primary btn-sm" href="#" onclick="<?=$sosmed->gplus?>" style="background: #db4437 !important;"><i class="fa fa-google-plus" style="width: 25px;padding: 5px 7px;"></i></a>&nbsp;
		<a class="btn btn-primary btn-sm" href="#" onclick="<?=$sosmed->whatsapp?>" style="background: #01E675 !important;"><i class="fa fa-whatsapp" style="width: 25px;padding: 5px 7px;"></i></a>
	</div>
	
	<?=$_komentar?>
</div>
<?php 
	if(isset(get_session("user")->islogin) && get_session("user")->islogin){
		?>
		<div class="comment-form">
			<h4><?=$this->lang->line('post_comment');?></h4>
			<form id="komentar">
				<div class="form-group">
					<input type="hidden" name="id_agenda" id="id_agenda" value="<?=$item->id_agenda?>">
					<textarea class="form-control mb-10" rows="5" name="message" placeholder="<?=$this->lang->line('comment');?>" onfocus="this.placeholder = ''" onblur="this.placeholder = '<?=$this->lang->line('comment');?>'" required=""></textarea>
				</div>
				<button class="primary-btn text-uppercase" id="btn_kirim"><?=$this->lang->line('post_comment');?></button>
			</form>
		</div>

		<script type="text/javascript">
			var app_agenda = "agenda";
			$(document).ready(function() {
				$('#komentar').submit(function() {
					var txt_btn = $('#btn_kirim').text();
					$.ajax({
						url:getUri(app_agenda,'post_komentar'),
						type:"post",
						data:$('#komentar').serialize(),
						dataType:"json",
						beforeSend:function() {
							$('#btn_kirim').html("<i class='fa fa-spin fa-spinner'></i> "+txt_btn).attr("disabled",true);
						},
						success:function(data) {
							if (!data.status) {session_gone_screen();}else{
								window.location.reload()
							}
							$('#btn_kirim').html(txt_btn).attr("disabled",false);
						},
						error:function() {
							$('#btn_kirim').html(txt_btn).attr("disabled",false);
						}
					})
					return false;
				})
			})
		</script>
		<?php
	}
 ?>
</div>