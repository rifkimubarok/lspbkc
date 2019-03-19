<div class="left side-menu">
    <div class="sidebar-inner slimscrollleft">
        <div class="user-details">
            <div class="pull-left">
                <img src="<?=BASE?>api/pictures/show_picture/member_docs/foto_<?=$user->id?>" alt="" class="thumb-md img-circle center-cropped">
            </div>
            <div class="user-info">
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><?=$user->nama?> <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?=BASEURL?>setting"><i class="md md-settings"></i> Settings</a></li>
                        <li><a href="<?=BASEURL?>logout"><i class="md md-settings-power"></i> Logout</a></li>
                    </ul>
                </div>
                
                <p class="text-muted m-0">Administrator</p>
            </div>
        </div>
        <!--- Divider -->
        <div id="sidebar-menu">
            <ul>
                <li>
                    <a href="<?=BASEURL?>" class="waves-effect"><i class="md md-home"></i><span> Dashboard </span></a>
                </li>
                <li>
                    <a href="<?=BASEURL?>static_page" class="waves-effect"><i class="fa fa-file-text-o"></i><span> Halaman Statis </span></a>
                </li>

                <!-- <li class="has_sub">
                    <a href="#" class="waves-effect"><i class="md md-account-circle"></i><span> Profile </span><span class="pull-right"><i class="md md-add"></i></span></a>
                    <ul class="list-unstyled">
                        <li><a href="<?=BASEURL?>profile/p/sambutan-ketua-umum">Sambutan Ketua Umum</a></li>
                        <li><a href="<?=BASEURL?>profile/p/sejarah">Sejarah</a></li>
                        <li><a href="<?=BASEURL?>profile/p/logo">Logo</a></li>
                        <li><a href="<?=BASEURL?>profile/p/visi-misi">Visi & Misi</a></li>
                        <li><a href="<?=BASEURL?>profile/p/struktur-organisasi">Struktur Organisasi</a></li>
                        <li><a href="<?=BASEURL?>profile/p/legalitas-organisasi">Legalitas Organisasi</a></li>
                        <li><a href="<?=BASEURL?>kontak">Kontak</a></li>
                    </ul>
                </li> -->

                <!-- <li>
                    <a href="<?=BASEURL?>data/purnapasma" class="waves-effect"><i class="md md-account-child"></i><span> Data Purna Pasma </span></a>
                </li> -->

                <!-- <li class="has_sub">
                    <a href="#" class="waves-effect"><i class="md md-account-child"></i> <span> Data </span><span class="badge badge-xs badge-danger" id="total_daftar">0</span> <span class="pull-right"><i class="md md-add"></i></span></a>
                    <ul class="list-unstyled">
                        <li><a href="<?=BASEURL?>data/purnapasma">DPP PPUKRN</a></li>
                        <li><a href="<?=BASEURL?>data/pasukaninti">Pasma Teregistrasi <span class="badge badge-xs badge-danger pull-right" id="total_inti_utama">0</span></a></li>
                        <li><a href="<?=BASEURL?>data/sahabatkrn">Sahabat KRN <span class="badge badge-xs badge-danger pull-right" id="total_sahabat">0</span></a></li>
                        <li><a href="<?=BASEURL?>data/calon_pasma">Calon Pasma <span class="badge badge-xs badge-danger pull-right" id="total_pasma">0</span></a></li>
                        <li><a href="<?=BASEURL?>data/datadpd">Data Dpd</a></li>
                    </ul>
                </li> -->

                <li class="has_sub">
                    <a href="#" class="waves-effect"><i class="fa fa-newspaper-o"></i> <span> News </span> <span class="pull-right"><i class="md md-add"></i></span></a>
                    <ul class="list-unstyled">
                        <li><a href="<?=BASEURL?>agenda">Agenda</a></li>
                        <li><a href="<?=BASEURL?>posting">Posting</a></li>
                    </ul>
                </li>

                <!--<li>
                    <a href="<?/*=BASEURL*/?>forum" class="waves-effect"><i class="fa fa-newspaper-o"></i><span> Management Forum </span></a>
                </li>-->

                <li>
                    <a href="<?=BASEURL?>kontak/kotak_masuk" class="waves-effect menu-pesan"><i class="fa fa-envelope-o"></i><span> Pesan Pengunjung </span> <span class="badge badge-xs badge-danger pull-right" id="pesan_total">0</span></a>
                </li>

                <li>
                    <a href="<?=BASEURL?>slider" class="waves-effect"><i class="fa fa-gear"></i><span> Slider </span></a>
                </li>

                <li>
                    <a href="<?=BASEURL?>survei" class="waves-effect"><i class="fa fa-list-alt"></i><span> Hasil Polling </span></a>
                </li>

                <li class="has_sub">
                    <a href="#" class="waves-effect"><i class="fa fa-gear"></i> <span> Setting </span> <span class="pull-right"><i class="md md-add"></i></span></a>
                    <ul class="list-unstyled">
                        <li><a href="<?=BASEURL?>menu" class="waves-effect"><i class="fa fa-gear"></i><span> Management Menu </span></a></li>
                        <li><a href="<?=BASEURL?>kategori" class="waves-effect"><i class="fa fa-gear"></i><span> Kategori </span></a></li>
                        <li><a href="<?=BASEURL?>users" class="waves-effect"><i class="md md-account-child"></i><span> User Management </span></a></li>
                    </ul>
                </li>
                
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>