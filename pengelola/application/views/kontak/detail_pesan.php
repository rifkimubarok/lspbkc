<style type="text/css">
	table tr td {
		padding: 3px;
	}
</style>
<?php 
	$item = '';
	foreach ($data as $a) {
		$item = $a;
	}
 ?>
<div class="col-md-12">
	<table>
		<tr>
			<td><?=$item->inbox == 1 ? 'Dari':'Kepada'?></td>
			<td>:</td>
			<td><?=$item->nama.' <span><</span>'.$item->email.'<span>></span>'?></td>
		</tr>
		<tr>
			<td>Subject</td>
			<td>:</td>
			<td><?=$item->subjek?></td>
		</tr>
		<tr>
			<td><strong>Pesan</strong></td>
			<td>:</td>
			<td></td>
		</tr>
	</table>
	<div class="row" style="padding: 10px;border:solid 1px #ccc; margin: 20px;">
		<?=nl2br(htmlspecialchars_decode($item->pesan))?>
	</div>
	<!-- <div class="form-group">
		<textarea class="form-control" readonly="" rows="7"><?=htmlspecialchars_decode($item->pesan)?></textarea>
	</div> -->
	<?php if($item->inbox){ ?>
		<br>
		<button class="btn btn-primary" onclick='replay_message(this)' data-value="<?=$item->id_hubungi?>"><i class="fa fa-reply"></i> Balas Pesan</button>
	<?php } ?>
</div>