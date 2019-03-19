<style type="text/css">
	.daftar{
		top: 0;
		height: 100%;
	}
	.reg_cl{
		color:#f2c707!important;font-weight: bold !important;
	}
	.was-login{
		display: none;
	}
</style>
<ul class="nav-menu">
	<?php
	$user = get_session("user");
	$root = '';
	$nav = '';
		foreach ($menu->data as $item) {
			if($item->submenu->status){
				$menu = null;
					$isi = $menu == null ? $item->nama_menu : $menu;
					$clreg = '';
					$waslogin = '';
					if($item->nama_menu == "Registrasi"){
						$clreg = 'reg_cl';
						if(isset($user->islogin) && $user->islogin){
							$waslogin = 'was-login';
						}
					}
				$nav .= '<li class="menu-has-children '.$waslogin.'"><a href="'.$item->link.'" class="'.$clreg.'">'.$isi.'</a><ul>';
				foreach ($item->submenu->data as $submenu) {
					$menu = null;
					$isi = $menu == null ? $submenu->nama_sub : $menu;
					$nav .= '<li><a href="'.base($submenu->link_sub).'">'.$isi.'</a></li>';
					//echo $submenu->nama_sub;
				}
				$nav .= '</ul></li>';
			}else{

				$menu = null;
				$isi = $menu == null ? $item->nama_menu : $menu;
				if($item->nama_menu == "Registrasi"){
					$nav .= '<li class=""><strong><a style="color:#f2c707!important;font-weight: bold;
" href="'.base($item->link).'">'.$isi.'</a></strong></li>';
				}else{
					$nav .= '<li class=""><a href="'.base($item->link).'">'.$isi.'</a></li>';
				}
			}
		}
		//$nav .= '<li class="daftar"><a href="'.base("registrasi").'">Daftar</a></li>';
		echo $nav;
	?>
</ul>