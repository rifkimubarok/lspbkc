<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
        <meta name="author" content="Coderthemes">

        <link rel="shortcut icon" href="<?=IMAGES?>fav.png">

        <title>Login | LSP SMK BHAKTI KENCANA CIAMIS</title>

        <!-- Base Css Files -->
        <link href="<?=CSS?>bootstrap.min.css" rel="stylesheet" />

        <!-- Font Icons -->
        <link href="<?=ASSETS?>assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
        <link href="<?=ASSETS?>assets/ionicon/css/ionicons.min.css" rel="stylesheet" />
        <link href="<?=CSS?>material-design-iconic-font.min.css" rel="stylesheet">

        <!-- animate css -->
        <link href="<?=CSS?>animate.css" rel="stylesheet" />

        <!-- Waves-effect -->
        <link href="<?=CSS?>waves-effect.css" rel="stylesheet">

        <!-- Custom Files -->
        <link href="<?=CSS?>helper.css" rel="stylesheet" type="text/css" />
        <link href="<?=CSS?>style.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.<?=JS?>1.3.0/respond.min.js"></script>
        <![endif]-->

        <script src="<?=JS?>modernizr.min.js"></script>
        <style type="text/css">
            #captcha_box img{
                width: 100%;
            }
        </style>
        
    </head>
    <body>


        <div class="wrapper-page">
            <div class="panel panel-color panel-primary panel-pages">
                <div class="panel-heading bg-img"> 
                    <div class="bg-overlay"></div>
                    <h3 class="text-center m-t-10 text-white"> Log In to <strong>LSP SMK BHAKTI KENCANA CIAMIS</strong> </h3>
                </div> 


                <div class="panel-body">
                <form class="form-horizontal m-t-20" id="form_login">
                    
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control input-lg " id="username" type="text" required="" placeholder="Username">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control input-lg" id="password" type="password" required="" placeholder="Password">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-6" id="captcha_box">
                            <?=$captcha->image?>
                        </div>
                        <div class="col-xs-6">
                            <input class="form-control input-lg" type="text" required="" placeholder="Security Code" id="security_code">
                        </div>
                    </div>

                    <div class="form-group ">
                        <div class="col-xs-12">
                            <div class="checkbox checkbox-primary">
                                <input id="checkbox-signup" type="checkbox">
                                <label for="checkbox-signup">
                                    Remember me
                                </label>
                            </div>
                            
                        </div>
                    </div>
                    
                    <div class="form-group text-center m-t-40">
                        <div class="col-xs-12">
                            <button class="btn btn-primary btn-lg w-lg waves-effect waves-light" type="submit">Log In</button>
                        </div>
                    </div>

                    <!-- <div class="form-group m-t-30">
                        <div class="col-sm-7">
                            <a href="recoverpw.html"><i class="fa fa-lock m-r-5"></i> Forgot your password?</a>
                        </div>
                        <div class="col-sm-5 text-right">
                            <a href="register.html">Create an account</a>
                        </div>
                    </div> -->
                </form> 
                </div>                                 
                
            </div>
        </div>

        
    	<script>
            var resizefunc = [];
        </script>
    	<script src="<?=JS?>jquery.min.js"></script>
        <script src="<?=JS?>bootstrap.min.js"></script>
        <script src="<?=JS?>waves.js"></script>
        <script src="<?=JS?>wow.min.js"></script>
        <script src="<?=JS?>jquery.nicescroll.js" type="text/javascript"></script>
        <script src="<?=JS?>jquery.scrollTo.min.js"></script>
        <script src="<?=ASSETS?>assets/jquery-detectmobile/detect.js"></script>
        <script src="<?=ASSETS?>assets/fastclick/fastclick.js"></script>
        <script src="<?=ASSETS?>assets/jquery-slimscroll/jquery.slimscroll.js"></script>
        <script src="<?=ASSETS?>assets/jquery-blockui/jquery.blockUI.js"></script>
        <script src="<?=JS?>myScript.js"></script>


        <!-- CUSTOM JS -->
        <script src="<?=JS?>jquery.app.js"></script>
	    <script type="text/javascript">
            $(document).ready(function() {
                //refresh_captcha();
            })
            $('#form_login').submit(function() {
                var username = $('#username').val();
                var password = $('#password').val();
                var security_code = $('#security_code').val();
                var btn = $('button[type=submit]');
                var btnhtml = btn.html();
                $.ajax({
                    url:getUri("login","do_login"),
                    type:"post",
                    dataType:"JSON",
                    data:{username:username,password:password,security_code:security_code},
                    beforeSend:function(){
                        btn.html("<i class='fa fa-spin fa-spinner'></i> Loading ...");
                        btn.attr("disabled",true);
                    },
                    success:function(data) {
                        if(data.status){
                            window.location.href=getUri("",'');
                        }else{
                            alert(data.message);
                            refresh_captcha();
                            $('#password').val('');
                            $('#security_code').val('');
                            btn.html(btnhtml);
                            btn.attr("disabled",false);
                        }
                    },
                    error:function() {
                        alert("Terjadi Sebuh Kesalahan");
                        $('#password').val('');
                        $('#security_code').val('');
                        refresh_captcha();
                        btn.html(btnhtml);
                        btn.attr("disabled",false);
                    }
                });
                return false;
            })

            function refresh_captcha() {
                $.ajax({
                    url:getUri("login","refresh_captcha"),
                    type:"post",
                    dataType:"html",
                    success:function(data) {
                        $('#captcha_box').html(data);
                    }
                });
            }
        </script>
	</body>
</html>