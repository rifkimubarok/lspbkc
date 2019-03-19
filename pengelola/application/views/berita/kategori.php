<div class="row">
    <div class="col-sm-12">
        <ol class="breadcrumb pull-right">
            <li><a href="#">Dashboard</a></li>
            <li class="active">Berita</li>
        </ol>
    </div>
</div>

<div class="row" >
    <div class="col-md-12 bx-shadow mini-stat" id="data_kategori">
        <h5 class="pull-left">Management Kategori Posting </h5>
        <button class="btn btn-primary btn-md pull-right" id="btn_add"><i class="fa fa-pencil"></i> Tambah Kategori</button>
        <div class="clearfix"></div>
        <hr>
        <table class="table table-striped table-bordered table-responsive" id="tbl_kategori">
            <thead>
            <tr>
                <th width="10px">No</th>
                <th>Kategori</th>
                <th>#</th>
            </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

    <div class="col-md-12 bx-shadow mini-stat" style="display: none;" id="editor_kategori">
        <h5 class="pull-left">Tambah Kategori</h5>
        <hr>
        <form id="frm_kategori">
            <div class="form-group col-md-6">
                <label for="nama_kategori">Nama Kategori</label>
                <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" required>
                <input type="hidden" name="id_kategori" id="id_kategori">
                <input type="hidden" name="status_save" id="status_save">
            </div>
            <div class="form-group col-md-12">
                <button class="btn btn-success btn-save" type="submit"><i class="fa fa-save"></i> Simpan data</button>
                <button class="btn btn-warning btn-cancel" type="button"><i class="fa fa-arrow-circle-o-left"></i> batal</button>
            </div>
        </form>
    </div>
</div>

<script>
    var app_ = "kategori";

    $(document).ready(function () {
        load_kategori();
    });

    function load_kategori() {
        table =   $('#tbl_kategori').DataTable({
            "processing": true,
            "serverSide": true,
            "pagingType": "full_numbers",
            "scrollY":"500px",
            "scrollCollapse": true,
            paging: true,
            responsive: true,
            "order": [],
            "ajax": {
                "url": getUri(app_,'get_data_kategori'),
                "type": "POST"
            }
        });
    }

    $('#tbl_kategori').on("click",".btn-edit",function () {
        var elmt = $(this);

        var id = elmt.attr("data-value");
        var btn = elmt.html();
        $.ajax({
            url:getUri(app_,"get_kategori"),
            method:"post",
            dataType:"json",
            data:{id_kategori:id},
            beforeSend:function(){
                elmt.html("<i class='fa fa-spinner fa-spin'><i>");
                elmt.attr("disabled",true);
            },
            success:function (result) {
                show_form();
                console.log(result.nama_kategori);
                $('#id_kategori').val(result.id_kategori);
                $('#nama_kategori').val(result.nama_kategori);
                $('#status_save').val(1);
                elmt.html(btn);
                elmt.attr("disabled",false);
            },
            error:function (x, y, z) {
                gagal_screen();
                elmt.html(btn);
                elmt.attr("disabled",false);
            }
        })
    })

    $('#btn_add').click(function () {
        show_form();
        clear_form();
    });

    $('.btn-cancel').click(function () {
        close_form();
        clear_form();
    });

    function show_form() {
        $('#data_kategori').slideUp(200);
        $('#editor_kategori').slideDown(200);
    }

    function close_form() {
        $('#data_kategori').slideDown(200);
        $('#editor_kategori').slideUp(200);
    }

    function reload_data(){
        var table = $('#tbl_kategori').DataTable();
        table.ajax.reload();
    }


    function clear_form(){
        var form = document.getElementById("frm_kategori");
        form.reset();
        $('#status_save').val(0);
    }

    $('#frm_kategori').submit(function () {
        var status = parseInt($('#status_save').val());
        var id_kategori = $('#id_kategori').val();
        var nama_kategori = $('#nama_kategori').val();
        var url = "";
        var data = {};
        var btn_save = $('.btn-save').html();
        if(status == 1){
            url = getUri(app_,"update_kategori");
            data = {id_kategori:id_kategori,nama_kategori:nama_kategori}
        }else{
            url = getUri(app_,"save_kategori");
            data = {nama_kategori:nama_kategori};
        }

        $.ajax({
            url:url,
            data:data,
            type:"post",
            dataType: "json",
            beforeSend:function () {
                loading_screen();
            },
            success:function (result) {
                swal("","Data Berhasil disimpan.","success");
                close_form();
                reload_data();
            },
            error:function (x, y, z) {
                gagal_screen();
            }
        });

        return false;
    })
</script>