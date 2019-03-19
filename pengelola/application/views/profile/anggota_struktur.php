<style type="text/css">
	.image,.middle{transition:.5s ease;width:100%}.middle,.middle a,.text{color:#fff}.image{opacity:1;display:block;height:auto;backface-visibility:hidden}.middle{opacity:0;position:absolute;left:50%;bottom:0;margin-top:10px;padding:10px;background-color:rgba(00,00,00,.6);transform:translate(-50%,-50%);-ms-transform:translate(-50%,-50%);text-align:center}.imagecontent{position:relative;width:100%}.imagecontent:hover .image{opacity:.3}.imagecontent:hover .middle{opacity:1}.text{background-color:#4CAF50;font-size:16px;padding:16px 32px}
	.middle i {
		padding-left: 10px;
		padding-right: 10px;
		margin: auto;
		cursor: pointer;
	}
</style>
<div class="row">
	<?php
		if(count($data)>0){
			$no = 0;
			foreach ($data as $item) {
				$no++;
				if($item->urutan == 1){
	?>
			<div class="col-md-12" style="padding-bottom: 15px;text-align: center;">
				<center>
					<div class="imagecontent" style="max-width: 250px;">
						<img src="<?=GAMBAR?>struktur/<?=sha1($item->id)?>" style="max-width: 250px;padding: 20px;border: solid 1px #ccc;border-radius: 5px;" class="image">
						<span class="middle">
							<button class="btn btn-default btn-xs" data-value="<?=$item->id?>" onclick=updatephoto(this)><i class="fa fa-camera white" title="Update Photo Profile"></i></button>
							<button class="btn btn-primary btn-xs" data-value="<?=$item->id?>" onclick=updatedata(this)><i class="fa fa-pencil white" title="Update Data"></i></button>
							<button class="btn btn-danger btn-xs" data-value="<?=$item->id?>" onclick=hapusdata(this)><i class="fa fa-trash white" title="Hapus Data"></i></button>
						</span>
					</div>
				</center>
				<span ><?=$item->nama?></span><br>
				<span class="label label-primary"><?=$item->nama_struktur?></span>
			</div>
			<br>
	<?php
				}else{
					?>
			<div class="col-md-6" style="padding-bottom: 15px;text-align: center;">
				<center>
					<div class="imagecontent" style="max-width: 250px;">
						<img src="<?=GAMBAR?>struktur/<?=sha1($item->id)?>" style="max-width: 250px;padding: 20px;border: solid 1px #ccc;border-radius: 5px;" class="image">
						<span class="middle">
							<button class="btn btn-default btn-xs" data-value="<?=$item->id?>" onclick=updatephoto(this)><i class="fa fa-camera white" title="Update Photo Profile"></i></button>
							<button class="btn btn-primary btn-xs" data-value="<?=$item->id?>" onclick=updatedata(this)><i class="fa fa-pencil white" title="Update Data"></i></button>
							<button class="btn btn-danger btn-xs" data-value="<?=$item->id?>" onclick=hapusdata(this)><i class="fa fa-trash white" title="Hapus Data"></i></button>
						</span>
					</div>
				</center>
				<span ><?=$item->nama?></span><br>
				<span class="label label-primary"><?=$item->nama_jabatan?></span>
			</div>
					<?php
				}
			}
		}else{
			?>
			<div class="col-md-12" style="padding-bottom: 15px;text-align: center;">
				<h3 style="text-align: center;display: flex;vertical-align: middle;">Data Tidak Tersedia!</h3>
			</div>
			<?php
		}
	?>
</div>