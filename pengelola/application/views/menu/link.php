<div id="linkcontent">
    <table class="table table-striped table-bordered" id="tbl_link">
        <thead>
            <tr>
                <td width="10px;">No.</td>
                <td>Halaman</td>
                <td width="50px">#</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td width="10px;">1</td>
                <td>Beranda</td>
                <td width="50px">
                    <a href="<?=BASE?>" target="_blank"><button class="btn btn-default btn-xs"><i class="fa fa-link"></i></button></a>
                    <button class="btn btn-primary btn-xs check-btn" data-value=""><i class="fa fa-check"></i></button>
                </td>
            </tr>
            <tr>
                <td width="10px;">2</td>
                <td>Agenda</td>
                <td width="50px">
                    <a href="<?=BASE?>agenda/" target="_blank"><button class="btn btn-default btn-xs"><i class="fa fa-link"></i></button></a>
                    <button class="btn btn-primary btn-xs check-btn" data-value="agenda/"><i class="fa fa-check"></i></button>
                </td>
            </tr>
            <?php
                $no = 3;
                foreach ($link as $item) {
                ?>
                    <tr>
                        <td><?=$no?></td>
                        <td><?=$item->name_page?></td>
                        <td>
                            <a href="<?=BASE.$item->url?>" target="_blank"><button class="btn btn-default btn-xs"><i class="fa fa-link"></i></button></a>
                            <button class="btn btn-primary btn-xs check-btn" data-value="<?=$item->url?>"><i class="fa fa-check"></i></button>
                        </td>
                    </tr>
                <?php
                    $no++;
                }
            ?>
        </tbody>
    </table>
</div>
<script>
    $('#tbl_link').DataTable();
    $('#linkcontent').on("click",".check-btn",function(){
        $('#link').val($(this).attr("data-value"));
        $('#modal_link').modal("hide");
    });
</script>