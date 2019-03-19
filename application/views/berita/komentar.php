<style type="text/css">
	.date{
		margin-bottom: 5px;
	}
</style>
<div class="comment-sec-area">
		<div class="container">
			<div class="row flex-column">
				<h6><?=$komentar->total_komentar?> <?=$this->lang->line('comment');?></h6>
				<?php 
					$user = get_session("user");
					$user_id = isset($user->islogin) == 1 ? $user->id : 0 ;
					$islogin = isset($user->islogin) == 1 ? $user->islogin : 0 ;
					foreach ($komentar->data as $item) {
						?>
						<div class="comment-list">
						<div class="single-comment justify-content-between d-flex">
							<div class="user justify-content-between d-flex">
								<div class="thumb">
									<img src="<?=THUMB?>users/<?=sha1($item['komentar']->user_id)?>" alt="" style="width: 100%;">
								</div>
								<div class="desc">
									<h5><a href="#"><?=$item['komentar']->nama_komentar?></a></h5>
									<p class="date"><?=date("d F,Y H:i",strtotime($item['komentar']->tgl))?> </p>
									<p class="comment">
										<?=$item['komentar']->isi_komentar?>
									</p>
								</div>
							</div>
							<?php if($islogin){
								?>
								<div class="reply-btn">
									<a href="#" class="btn-reply text-uppercase" data-value="<?=$item['komentar']->id_komentar?>" onclick="return reply(this)"><?=$this->lang->line('reply');?></a>
								</div>
								<?php
							} ?>
						</div>
						<?php
						if($item['reply_komentar']->status){
							foreach ($item['reply_komentar']->data as $reply) {
								?>
										<div class="single-comment left-padding justify-content-between d-flex">
											<div class="user justify-content-between d-flex">
												<div class="thumb">
													<img src="<?=THUMB?>users/<?=sha1($reply->user_id)?>" alt="" style="width: 100%;">
												</div>
												<div class="desc">
													<h5><a href="#"><?=$reply->nama_komentar?></a></h5>
													<p class="date"><?=date("d F,Y H:i",strtotime($reply->tgl))?> </p>
													<p class="comment">
														<?=$reply->isi_komentar?>
													</p>
												</div>
											</div>
										</div>
								<?php
							}
						}
						?>
						</div>
						<?php
					}
				 ?>
			</div>
		</div>
	</div>

<?php if ($islogin) {
	?>

	<div style="display: none;">
		<div class="single-comment left-padding justify-content-between d-flex kolom_komentar" id="">
			<div class="user justify-content-between d-flex">
				<div class="thumb">
					<img src="<?=THUMB?>users/<?=sha1($user_id)?>" alt="" style="width: 100%;">
				</div>
				<div class="desc">
					<div class="form-group">
						<textarea class="form-control" style="width: 400px;font-size: 13px;" id="reply_comment"></textarea>
					</div>
				</div>
			</div>
				<div class="reply-btn">
					<a href="#" class="btn-reply text-uppercase" onclick="return reply_comment(this);"><?=$this->lang->line('post_comment');?></a>
				</div>
		</div>
	</div>
	<?php
} ?>

<script type="text/javascript">
	var komentar_id = '';
	function reply(item) {
		komentar_id = $(item).attr("data-value");
		$('#kolom_komentar').remove();
		var kolom_komentar = $('.kolom_komentar').clone().prop({
			id:"kolom_komentar"
		});
		var par = $(item).parent('div').parent('div').parent('div');
		$(par).append(kolom_komentar);
		return false;
	}

	function reply_comment(item) {
		var txt_btn = $(item).text();
		var btn = $(item);
		$.ajax({
			url:getUri(app_berita,'reply_comment'),
			type:"post",
			data:{id_komentar:komentar_id,isi_komentar:$('#reply_comment').val()},
			dataType:"json",
			beforeSend:function() {
				btn.html("<i class='fa fa-spin fa-spinner'></i> "+txt_btn).attr("disabled",true);
			},
			success:function(data) {
				if (!data.status) {session_gone_screen();}else{
					window.location.reload()
				}
				btn.html(txt_btn).attr("disabled",false);
			},
			error:function() {
				btn.html(txt_btn).attr("disabled",false);
			}
		})
		return false;
	}
</script>