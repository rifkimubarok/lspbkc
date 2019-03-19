<div class="row">
	<div class="col-sm-12">
        <ol class="breadcrumb pull-right">
            <li><a href="#">Dashboard</a></li>
            <li class="active">Berita</li>
        </ol>
    </div>
</div>

<div class="row" id="data_berita">
	<div class="col-md-12 bx-shadow mini-stat">
      <h5 class="pull-left">Management Users </h5>
      <div class="clearfix"></div>
      <hr>

      <table class="table table-striped table-bordered table-responsive" id="user">
        <thead>
          <tr>
            <th width="5%">No.</th>
            <th>Nama</th>
            <th>Username</th>
            <th>Email</th>
            <th>No. HP</th>
            <th>#</th>
          </tr>
        </thead>
        <tbody>
          <?php if(count($user) > 0){
            $no = 0;
            foreach ($user as $item) {
              $no++;
              $ban = $item->blokir == "N" ? "fa fa-ban" : "fa fa-check";
              ?>
              <tr>
                <td><?=$no?></td>
                <td><?=$item->nama?></td>
                <td><?=$item->username?></td>
                <td><?=$item->email?></td>
                <td><?=$item->no_hp?></td>
                <td>
                  <button class="btn btn-warning btn-xs btn-resetpw" data-value="<?=$item->id?>" data-nama="<?=$item->nama?>" title="Reset Kata Sandi" onclick="reset_pw(this)"><i class="fa fa-key"></i></button>
                  <button class="btn btn-danger btn-xs btn-nonaktif" data-nama="<?=$item->nama?>" data-value="<?=$item->id?>" title="Nonaktifkan Akun" data-status="<?=$item->blokir?>" onclick="blok_user(this)"><i class="<?=$ban?>"></i></button>
                </td>
              </tr>
              <?php
            }
          } ?>
        </tbody>
      </table>
  </div>
</div>

<script type="text/javascript">
  $('#user').dataTable();
  var app_user = "users";
  $(document).ready(function() {
    
  })

  function reset_pw(elm) {
      var elmt = $(elm);
      swal({   
            title: "Anda Yakin?",   
            text: "Akun "+elmt.attr('data-nama')+" akan di reset passwordnya!",   
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
              url:getUri(app_user,"reset_pw"),
              type:"post",
              dataType:"JSON",
              data:{member_id:elmt.attr("data-value")},
              beforeSend:loading_screen,
              success:function(result) {
                swal("Berhasil","Kata sandi berhasil dikembalikan ke default yaitu 12345","success");
              },
              error:gagal_screen
            })
          }
        });
    }

  function blok_user(elm) {
      var elmt = $(elm);
      var status = elmt.attr("data-status") == "Y" ? "N" : "Y";
      var message = elmt.attr("data-status") == "Y" ? "di Aktifkan" : "di Nonaktifkan";
      swal({   
            title: "Anda Yakin?",   
            text: "Akun "+elmt.attr('data-nama')+" akan "+message,   
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
              url:getUri(app_user,"blok_user"),
              type:"post",
              dataType:"JSON",
              data:{member_id:elmt.attr("data-value"),status:status},
              beforeSend:loading_screen,
              success:function(result) {
                if(status == "N"){
                  swal("Berhasil","Akun "+elmt.attr('data-nama')+" berhasil di Aktifkan","success");
                  elmt.attr("status",status).html("<i class='fa fa-ban'></i>").attr("title","Nonaktifkan Akun");
                }else{
                  swal("Berhasil","Akun "+elmt.attr('data-nama')+" berhasil di Nonaktifkan","success");
                  elmt.attr("status",status).html("<i class='fa fa-check'></i>").attr("title","Aktifkan Akun");
                }
              },
              error:gagal_screen
            })
          }
        });
    }
</script>