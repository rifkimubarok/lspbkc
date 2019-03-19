<?php
	if(count($forum)<1){
		redirect("404");
	}
	$item = '';
	foreach ($forum as $it) {
		$item = $it;
	}
	$sosmed = new myObject();
	$sosmed->facebook = "MyWindow=window.open('".share_url("facebook",array("url"=>BASEURL."forum/detail/".$item->seo_judul,"text"=>$item->judul_forum))."',          'MyWindow','width=600,height=300'); return false;";
	$sosmed->twitter =  "MyWindow=window.open('".share_url("twitter",array("url"=>BASEURL."forum/detail/".$item->seo_judul,"text"=>$item->judul_forum))."',          'MyWindow','width=600,height=300'); return false;";
	$sosmed->gplus = "MyWindow=window.open('".share_url("google-plus",array("url"=>BASEURL."forum/detail/".$item->seo_judul,"text"=>$item->judul_forum))."','MyWindow','width=600,height=300'); return false;";
	$sosmed->whatsapp = "MyWindow=window.open('".share_url("whatsapp",array("url"=>BASEURL."forum/detail/".$item->seo_judul,"text"=>$item->judul_forum))."','MyWindow','width=600,height=300'); return false;";
?>
<style type="text/css">
	.btn-primary{
		border-color : #fff !important;
	}
</style>
<div class="single-post-wrap">
	<div class="content-wrap">
		<a href="#">
			<h3><?=$item->judul_forum?></h3>
		</a>
		<ul class="meta pb-20">
			<li><a href="#"><span class="lnr lnr-user"></span><?=$item->nama_pengirim?></a></li>
			<li><a href="#"><span class="lnr lnr-calendar-full"></span><?=date("d F, Y",strtotime($item->date_insert))?></a></li>
			<li><a href="#"><span class="lnr lnr-eye"></span><?=number_format($item->view_counter,0)?>x dilihat</a></li>
		</ul>
		<p>
			<?=htmlspecialchars_decode($item->content)?>
		</p>
	<div class="clearfix"></div>
	<div class="d-flex" style="padding-top: 60px;">
		<i class="fa fa-share-alt" style="font-size: 2em;padding: 5px 7px;"></i>
		<a class="btn btn-primary btn-sm" href="#" onclick="<?=$sosmed->facebook?>" style="background: #4c63a2 !important;"><i class="fa fa-facebook" style="width: 25px;padding: 5px 7px;"></i></a>&nbsp;
		<a class="btn btn-primary btn-sm" href="#" onclick="<?=$sosmed->twitter?>" style="background: #69c9ff !important;"><i class="fa fa-twitter" style="width: 25px;padding: 5px 7px;"></i></a> &nbsp;
		<a class="btn btn-primary btn-sm" href="#" onclick="<?=$sosmed->gplus?>" style="background: #db4437 !important;"><i class="fa fa-google-plus" style="width: 25px;padding: 5px 7px;"></i></a>&nbsp;
		<a class="btn btn-primary btn-sm" href="#" onclick="<?=$sosmed->whatsapp?>" style="background: #01E675 !important;"><i class="fa fa-whatsapp" style="width: 25px;padding: 5px 7px;"></i></a>
	</div>

	<input type="hidden" name="forum_id" id="forum_id" value="<?=$item->id?>">
	
	<?=$_komentar?>
</div>
<?php 
	if(isset(get_session("user")->islogin) && get_session("user")->islogin){
		?>
		<div class="comment-form">
			<h4><?=$this->lang->line('post_comment');?></h4>
			<form id="komentar">
				<div class="form-group">
					<input type="hidden" name="forum_id" id="forum_id" value="<?=$item->id?>">
					<textarea class="form-control mb-10" rows="5" name="message" placeholder="<?=$this->lang->line('comment');?>" onfocus="this.placeholder = ''" onblur="this.placeholder = '<?=$this->lang->line('comment');?>'" required=""></textarea>
				</div>
				<button class="primary-btn text-uppercase" id="btn_kirim"><?=$this->lang->line('post_comment');?></button>
			</form>
		</div>

		<script type="text/javascript">
			var app_forum = "forum";
			$(document).ready(function() {
				$('#komentar').submit(function() {
					var txt_btn = $('#btn_kirim').text();
					$.ajax({
						url:getUri(app_forum,'post_komentar'),
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