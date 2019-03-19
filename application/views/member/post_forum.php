<?php
	if(count($forum)>0){
		foreach ($forum as $item) {
			$summery = substr(strip_tags(htmlspecialchars_decode($item->content)), 0,150).' ...';
?>
		<div class="single-latest-post row align-items-center">
			<div class="col-lg-12 post-right" style="margin: auto 20px;">
				<a href="<?=BASEURL?>forum/detail/<?=$item->seo_judul?>" click='1'>
					<h4 style="text-align: justify;max-width: 100% !important;"><?=$item->judul_forum?></h4>
				</a>
				<ul class="meta" style="margin: 0px !important;">
					<li><a href="#"><span class="lnr lnr-user"></span><?=$item->nama_pengirim?></a></li>
					<li><a href="#"><span class="lnr lnr-calendar-full"></span><?=date("d F, Y",strtotime($item->date_insert))?></a></li>
					<li><a href="#"><span class="lnr lnr-eye"></span><?=number_format($item->view_counter,0)?>x dilihat</a></li>
				</ul>
				<p class="excert" style="text-align: justify;padding-right:25px;">
					<?=$summery?>
				</p>
				<p><a href="" data-value="<?=$item->id?>" onclick="edit_forum(this)">Edit</a>&nbsp;&nbsp; <a href="" data-value="<?=$item->id?>" onclick="hapus_forum(this)">Hapus</a> &nbsp;&nbsp; <a href="" data-value="<?=$item->id?>" data-status="<?=$item->status?>" onclick="status_forum(this)"><?=$item->status == 1 ? "Sembunyikan":"Tampilkan"?></a></p>
			</div>
		</div>
<?php
		}
	}

	if(isset($links)){
?>
<div class="load-more">
		<!-- <a href="#" class="primary-btn">Load More Posts</a> -->
		<div class="pagination">
	    <?php
		        echo "<li class='pagination-id'>". $links."</li>";
	    ?>
    	</div>
    	<div class="clearfix"></div>
	</div>
<?php } ?>

<script type="text/javascript">
	$('.single-latest-post a').click(function() {
		if(parseInt($(this).attr('click')) != 1){
			return false;
		}
	});

	function edit_forum(item) {
		var elm = $(item);
		$.ajax({
			url:getUri(app_member,"get_single_forum"),
			type:"POST",
			dataType:"JSON",
			data:{forum_id:elm.attr("data-value")},
			beforeSend:loading_screen,
			success:function(result) {
				swal.close();
				$('.forum-content').slideDown();
				$('#judul_forum').val(result.judul_forum);
				$('#summernote').summernote('code', result.content);
				$('#forum_id').val(result.id);
				$('#status_save').val(1);
			},
			error:gagal_screen
		})
	}

	function hapus_forum(item) {
		var elm = $(item);
		swal({   
            title: "Anda Yakin?",   
            text: "Forum diskusi ini akan segera dihapus!",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "Ya!",  
            cancelButtonText:"Tidak",
            closeOnConfirm: false, 
      showLoaderOnConfirm: true,
        }, function(data) {
          if (data) {
            $.ajax({
				url:getUri(app_member,"hapus_forum"),
				type:"POST",
				dataType:"JSON",
				data:{forum_id:elm.attr("data-value")},
				beforeSend:loading_screen,
				success:function(result) {
					swal("","Forum diskusi berhasil dihapus","success");
					get_forum_detail();
				},
				error:gagal_screen
			})
          }
        });
	}

	function status_forum(item) {
		var elm = $(item);
		var message = elm.attr("data-status") == 1 ? "disembunyikan" : "ditampilkan";
		var status = elm.attr("data-status") == 1 ? 0 : 1;
		swal({   
            title: "Anda Yakin?",   
            text: "Forum diskusi ini "+message,   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "Ya!",  
            cancelButtonText:"Tidak",
            closeOnConfirm: false, 
      showLoaderOnConfirm: true,
        }, function(data) {
          if (data) {
            $.ajax({
				url:getUri(app_member,"status_forum"),
				type:"POST",
				dataType:"JSON",
				data:{forum_id:elm.attr("data-value"),status:status},
				beforeSend:loading_screen,
				success:function(result) {
					swal("","Forum diskusi berhasil "+message,"success");
					get_forum_detail();
				},
				error:gagal_screen
			})
          }
        });
	}
</script>