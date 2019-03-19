<table class="table table-hover mails" id="mail_table">
	<thead>
		<tr>
			<th width="100px"></th>
			<th></th>
			<th></th>
			<th></th>
		</tr>
	</thead>
    <tbody>
    	<?php if(count($data)>0){ 
    		foreach ($data as $item) {
    			$date = '';
				$tgl = strtotime($item->tanggal);
				if(date('Y-m-d') == date('Y-m-d',$tgl)){
			        $date = date('H:i',$tgl);
			    }else if(date('Y') == date('Y',$tgl)){
			    	$date = date('d M',$tgl);
			    }else{
			    	$date = date('d/m/y',$tgl);
			    }
    		?>
        <tr>
            <td width="150px" onclick="read_message(this)" data-value="<?=$item->id_hubungi?>" data-page="inbox">
                <?=$item->nama ?>
            </td>
            <td onclick="read_message(this)" data-value="<?=$item->id_hubungi?>" data-page="inbox">
                <?=substring_text($item->subjek,100)?>
            </td>
            <td class="text-right" width="100px" onclick="read_message(this)" data-value="<?=$item->id_hubungi?>" data-page="inbox">
                <?=$date?>
            </td>
            <td width="50px"><button class="btn btn-danger btn-xs" data-value="<?=$item->id_hubungi?>" onclick="delete_data(this)"><i class="fa fa-trash"></i></button></td>
        </tr>	   
        <?php }
    		} ?>                 
    </tbody>
</table>


<script type="text/javascript">
	$('#mail_table').dataTable({
		order:[],
		"drawCallback": function( settings ) {
    		$("#mail_table thead").remove(); 
    	}
	});
</script>