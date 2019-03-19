<div class="row">
	<?php
		if(count($data)>0){
			foreach ($data as $item) {
				if($item->urutan == 1){
	?>
			<div class="col-md-12" style="padding-bottom: 15px;text-align: center;">
				<center><img src="<?=GAMBAR?>struktur/<?=sha1($item->id)?>" style="width:100%;max-width: 205px;padding: 20px;border: solid 1px #ccc;border-radius: 5px;"></center>
				<span ><?=$item->nama?></span><br>
				<span class="label label-primary"><?=$item->nama_struktur?></span>
			</div>
			<br>
	<?php
				}else{
					?>
			<div class="col-md-6" style="padding-bottom: 15px;text-align: center;">
				<div style="padding: 20px;border: solid 1px #ccc;border-radius: 5px; "><img src="<?=GAMBAR?>struktur/<?=sha1($item->id)?>" style="width:100%;max-width: 250px;"></div>
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