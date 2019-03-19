<div class="navbar navbar-default" role="navigation">
    <div class="container">
        <div class="">
            <div class="pull-left">
                <button class="button-menu-mobile open-left">
                    <i class="fa fa-bars"></i>
                </button>
                <span class="clearfix"></span>
            </div>
            <form class="navbar-form pull-left" role="search">
                <div class="form-group">
                    <input type="text" class="form-control search-bar" placeholder="Type here for search...">
                </div>
                <button type="submit" class="btn btn-search"><i class="fa fa-search"></i></button>
            </form>

            <ul class="nav navbar-nav navbar-right pull-right">
                <li class="dropdown hidden-xs">
                    <a href="#" data-target="#" class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="true">
                        <i class="md md-notifications"></i> <span class="badge badge-xs badge-danger" id="total_notif">0</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-lg">
                        <li class="text-center notifi-title">Notification</li>
                        <li class="list-group">
                           <!-- list item-->
                            <a href="javascript:void(0);" class="list-group-item" id="notifikasi_pesan_masuk">
                              <div class="media">
                                 <div class="pull-left">
                                    <em class="fa fa-envelope fa-2x text-primary"></em>
                                 </div>
                                 <div class="media-body clearfix">
                                    <div class="media-heading">Pesan Baru</div>
                                    <p class="m-0">
                                       <small><span class="text-primary" id="pesan_baru">0</span> Pesan Baru</small>
                                    </p>
                                 </div>
                              </div>
                            </a>
                            <!-- list item-->
                            <a href="javascript:void(0);" class="list-group-item">
                              <div class="media">
                                 <div class="pull-left">
                                    <em class="fa fa-comment fa-2x text-danger"></em>
                                 </div>
                                 <div class="media-body clearfix">
                                    <div class="media-heading">Komentar Baru</div>
                                    <p class="m-0">
                                       <small><span class="text-primary" id="komentar_baru">0</span> Komentar Baru</small>
                                    </p>
                                 </div>
                              </div>
                            </a>
                           <!-- last list item -->
                        </li>
                    </ul>
                </li>
                <li class="hidden-xs">
                    <a href="#" id="btn-fullscreen" class="waves-effect waves-light"><i class="md md-crop-free"></i></a>
                </li>
                <li class="dropdown">
                    <a href="" class="dropdown-toggle profile" data-toggle="dropdown" aria-expanded="true"><img src="<?=BASE?>api/pictures/show_picture/member_docs/foto_<?=$user->id?>" alt="user-img" class="img-circle center-cropped"> </a>
                    <ul class="dropdown-menu">
                        <li><a href="<?=BASEURL?>setting"><i class="md md-settings"></i> Settings</a></li>
                        <li><a href="<?=BASEURL?>logout"><i class="md md-settings-power"></i> Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <!--/.nav-collapse -->
    </div>
</div>

<script type="text/javascript">
    $('#notifikasi_pesan_masuk').click(function () {
        $('.menu-pesan').click();
    });
</script>