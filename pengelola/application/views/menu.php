    <link rel="stylesheet" href="<?=VENDORS?>tui-tree/tui-tree.css">
    <style>
        .tui-tree-wrap{
            width:auto!important;
        }
    </style>
    <div class="row">
      <div class="col-sm-12">
            <ol class="breadcrumb pull-right">
                <li><a href="#">Dashboard</a></li>
                <li class="active">Menu</li>
            </ol>
        </div>
    </div>

    <div class="row" id="data_berita">
      <div class="col-md-12 bx-shadow mini-stat">
        <div class='col-md-12 col-xs-12 col-sm-12'><h5 class="pull-left">Management Menu</h5></div>
        
        <div class="col-md-4 col-xs-6 col-sm-6">
            <div id="tree" class="tui-tree-wrap"></div>
        </div>

        <div class="col-md-8 col-xs-6 col-sm-6 explain">
            <div class="col-md-12 action-button">
                <button disabled class='btn btn-xs btn-warning btn-edit' title="Edit Deskripsi Menu"><i class="fa fa-pencil"></i> Edit</button>
                <button disabled class='btn btn-xs btn-danger btn-hapus' title="Hapus Menu"><i class="fa fa-trash"></i> hapus</button>
                <button disabled class='btn btn-xs btn-primary btn-uplevel' title="Pindahkan Urutan Menu Keatas"><i class="fa fa-arrow-up"></i></button>
                <button disabled class='btn btn-xs btn-primary btn-downlevel' title="Pindahkan Urutan Menu Kebawah"><i class="fa fa-arrow-down"></i></button>
                <strong><span id="selectedValue" class="label label-success"></span></strong>
            </div>
            
            <div class="col-md-12 form-mainmenu" style="margin-top:20px;display:none;">
                <form id="menu">
                    <fieldset>
                        <legend>
                            Form Edit
                        </legend>
                        <div class="form-group col-md-6">
                            <input type="hidden" name="id_main" id="id_main">
                            <input type="hidden" name="isChild" id="isChild">
                            <label for="nama_menu">Nama Menu</label>
                            <input type="text" name="nama_menu" id="nama_menu" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <!-- <label for="link">Link Menu</label>
                            <input type="text" name="link" id="link" class="form-control">
                            <span class="input-group-btn">
                            <button type="button" class="btn waves-effect waves-light btn-primary">Submit</button>
                            </span> -->
                            <div class="input-group">
                                <label for="link">Link Menu</label>
                                <input type="text" name="link" id="link" class="form-control" readOnly="readOnly">
                                <span class="input-group-btn" style="vertical-align: bottom!important;">
                                <button type="button" class="btn waves-effect waves-light btn-primary btn-getlink">Pilih <span class="caret"></span></button>
                                </span>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="aktif">Status Menu</label>
                            <select name="aktif" id="aktif" class="form-control">
                                <option value="Y">Aktif</option>
                                <option value="N">Non Aktif</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6 parrent_id" style="display:none;">
                            <label for="parrent_id">Menu Induk</label>
                            <select name="parrent_id" id="parrent_id" class="form-control" >
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <button class="btn btn-success btn-md btn-save" type="submit"><i class="fa fa-save"></i> Simpan</button>
                            <button class="btn btn-warning btn-md btn-cancel" type="button"><i class="fa fa-times"></i> Batal</button>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
        
        <div class="clearfix"></div>
      </div>
    </div>

    <div id="modal_link" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Modal Header</h4>
            </div>
            <div class="modal-body">
                <p>Some text in the modal.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
        </div>

    <script type="text/javascript" src="<?=VENDORS?>tui-tree/tui-code-snippet.min.js"></script>
    <script type="text/javascript" src="<?=VENDORS?>tui-tree/tui-tree.js"></script>
    <script class="code-js">
        $(document).ready(function(){
            getMenu();
            getParrentMenu();
        })
        function getMenu(){
            $.ajax({
            url:getUri('menu','getmenu'),
            type:"post",
            dataType:"json",
            success:function(result){
            var util = {
                addEventListener: function(element, eventName, handler) {
                    if (element.addEventListener) {
                        element.addEventListener(eventName, handler, false);
                    } else {
                        element.attachEvent('on' + eventName, handler);
                    }
                }
            };
    
            var data = result;
            var tree = new tui.Tree('tree', {
                data: data,
                nodeDefaultState: 'opened'
            }).enableFeature('Selectable', {
                selectedClassName: 'tui-tree-selected',
            });
    
            // var selectedBtn = document.getElementById('selectedBtn');
            // var deselectedBtn = document.getElementById('deselectedBtn');
            var rootNodeId = tree.getRootNodeId();
            var firstChildId = tree.getChildIds(rootNodeId)[0];
            var selectedValue = $('#selectedValue');
    
            tree.on('select', function(eventData) {
                $('.action-button button').attr("disabled",false);
                var nodeData = tree.getNodeData(eventData.nodeId);
                selectedValue.text("Menu Terpilih : "+nodeData.text);
                if(nodeData.isChild == '1'){
                    $('#id_main').val(nodeData.id_sub);
                    $('#parrent_id').val(nodeData.id_main);
                    console.log(nodeData.id_main);
                    $('.parrent_id').slideDown(200);
                }else{
                    $('#id_main').val(nodeData.id_main);
                    $('.parrent_id').slideUp(200);
                }
                $('#isChild').val(nodeData.isChild);
                $('#nama_menu').val(nodeData.text);
                $('#link').val(nodeData.link);
                $('#aktif').val(nodeData.aktif);
                $('.form-mainmenu').slideUp(200);
            });
    
            tree.on('deselect', function(eventData) {
                var nodeData = tree.getNodeData(eventData.nodeId);
                selectedValue.value = 'deselected : ' + nodeData.text;
            });
    
            // util.addEventListener(selectedBtn, 'click', function() {
            //     tree.select(firstChildId);
            // });
    
            // util.addEventListener(deselectedBtn, 'click', function() {
            //     tree.deselect();
            // });
            }
        })
        }

        function getParrentMenu(){
            $.ajax({
                url:getUri("menu","getParrentMenu"),
                type:"post",
                dataType:"json",
                success:function(result){
                    var option = "<option value=''>Pilih Menu Induk</option>";
                    for(i=0;i<result.length;i++){
                        var id = result[i].id_main;
                        var nama_menu = result[i].nama_menu;
                        option += "<option value='"+id+"'>"+nama_menu+"</option>";
                    }
                    $('#parrent_id').html(option);
                }
            })
        }

        $('.btn-edit').click(function(){
            $('.form-mainmenu').slideDown(200);
        })

        $('.btn-hapus').click(function(){

        })

        $('.btn-uplevel').click(function(){

        })

        $('.btn-downlevel').click(function(){

        })

        $('.btn-cancel').click(function(){
            $('.form-mainmenu').slideUp(200);
            $('.action-button button').attr("disabled",true);
        })

        $('.btn-save').click(saveMenu);

        function saveMenu(){
            var isChild = $('#isChild').val();
            var data;
            var nama_menu = $('#nama_menu').val();
            var aktif = $('#aktif').val();
            var link = $('#link').val();
            var id_main = $('#id_main').val();
            var parrent_id = $('#parrent_id').val();
            var uri = '';
            if(isChild == "1"){
                data = {
                    id_sub : id_main,
                    nama_sub : nama_menu,
                    aktif: aktif,
                    link_sub: link,
                    id_main: parrent_id
                }
                uri = getUri("menu","save_submenu");
            }else{
                data = {
                    id_main : id_main,
                    nama_menu : nama_menu,
                    aktif: aktif,
                    link: link,
                }
                uri = getUri("menu","save_menu");
            }

            var btnsave = $('.btn-save');
            var btncancel = $('.btn-cancel');
            var btnhtml = btnsave.html();
            $.ajax({
                url:uri,
                type:"post",
                dataType:"json",
                data:data,
                beforeSend:function(){
                    loading_screen();
                    btnsave.attr("disabled",true).html("<i class='fa fa-spin fa-spinner'><i> Saving ..");
                    btncancel.attr("disabled",true);
                },
                success:function(result){
                    swal("Berhasil!","Data Berhasil di Simpan.","success");
                    btnsave.html(btnhtml).attr("disabled",false);
                    btncancel.attr("disabled",false);
                },
                error:function(x,y,z){
                    gagal_screen();
                    btnsave.html(btnhtml).attr("disabled",false);
                    btncancel.attr("disabled",false);
                }
            })
        }

        $('.btn-getlink').click(getLink);

        function getLink() {
            var btn = $('.btn-getlink');
            var btnhtml = btn.html();
            $.ajax({
                url:getUri("menu","getlink"),
                type:"post",
                dataType:"html",
                beforeSend:function(){
                    btn.html("<i class='fa fa-spin fa-spinner'></i>").attr("disabled",true);
                },
                success:function(result){
                    btn.html(btnhtml).attr("disabled",false);
                    $('#modal_link .modal-body').html(result);
                    $('#modal_link').modal("show");
                },
                error:function(){
                    gagal_screen();
                    btn.html(btnhtml).attr("disabled",false);

                }
            })
        }
    </script>
</body>
</html>