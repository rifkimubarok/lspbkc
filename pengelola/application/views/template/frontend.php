<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
        <meta name="author" content="Coderthemes">

        <link rel="shortcut icon" href="<?=IMAGES?>fav.png">

		<title>LSP SMK BHAKTI KENCANA CIAMIS</title>

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

        <!-- sweet alerts -->
        <link href="<?=ASSETS?>assets/sweet-alert/sweet-alert.min.css" rel="stylesheet">

        <!-- Custom Files -->
        <link href="<?=CSS?>helper.css" rel="stylesheet" type="text/css" />
        <link href="<?=CSS?>style.css" rel="stylesheet" type="text/css" />

        <link href="<?=ASSETS?>assets/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />

        <link href="<?=ASSETS?>assets/modal-effect/css/component.css" rel="stylesheet">

        <link href="<?=VENDORS?>croppie/croppie.css" rel="stylesheet">


        <link href="<?=VENDORS?>summernote/dist/summernote.css" rel="stylesheet" />


        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <script src="<?=JS?>modernizr.min.js"></script>

        <style type="text/css">
            .center-cropped {
              object-fit: cover;
            }
        </style>
        
    </head>



    <body class="fixed-left">
        
        <script src="<?=JS?>jquery.min.js"></script>
        <script src="<?=ASSETS?>assets/datatables/jquery.dataTables.min.js"></script>
        <script src="<?=ASSETS?>assets/datatables/dataTables.bootstrap.js"></script>
        <script src="<?=JS?>myScript.js"></script>
        <!-- <script type="text/javascript" src="<?=VENDORS?>ckeditor/ckeditor.js"></script> -->
        <script type="text/javascript" src="<?=VENDORS?>inputmask/jquery.inputmask.bundle.min.js"></script>
        <script src="<?=VENDORS?>summernote/dist/summernote.js"></script>
        <script src="<?=JS?>bootstrap.min.js"></script>
        <!-- Begin page -->
        <div id="wrapper">
        
            <!-- Top Bar Start -->
            <div class="topbar">
                <!-- LOGO -->
                <div class="topbar-left">
                    <div class="">
                        <a href="<?=BASEURL?>" class="logo" style=""><img src="<?=IMAGES?>icon.png" style="width: 56px;"> <span style="font-size:90%">LSP BKC</span></a>
                    </div>
                </div>
                <!-- Button mobile view to collapse sidebar menu -->
                <?=$_topnews?>
            </div>
            <!-- Top Bar End -->


            <!-- ========== Left Sidebar Start ========== -->

            <?=$_menu?>
            <!-- Left Sidebar End --> 



            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->                      
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container">

                        <?=$_content?>

                    </div> <!-- container -->
                               
                </div> <!-- content -->

                <footer class="footer text-right">
                </footer>
                2018 © LSP SMK BHAKTI KENCANA CIAMIS.

            </div>
            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->



        </div>
        <!-- END wrapper -->


    
        <script>
            var resizefunc = [];
        </script>

        <!-- jQuery  -->
        <script src="<?=JS?>waves.js"></script>
        <script src="<?=JS?>wow.min.js"></script>
        <script src="<?=JS?>jquery.nicescroll.js" type="text/javascript"></script>
        <script src="<?=JS?>jquery.scrollTo.min.js"></script>
        <script src="<?=ASSETS?>assets/chat/moment-2.2.1.js"></script>
        <script src="<?=ASSETS?>assets/jquery-sparkline/jquery.sparkline.min.js"></script>
        <script src="<?=ASSETS?>assets/jquery-detectmobile/detect.js"></script>
        <script src="<?=ASSETS?>assets/fastclick/fastclick.js"></script>
        <script src="<?=ASSETS?>assets/jquery-slimscroll/jquery.slimscroll.js"></script>
        <script src="<?=ASSETS?>assets/jquery-blockui/jquery.blockUI.js"></script>
        <script src="<?=VENDORS?>hightchart/code/highcharts.js"></script>
        <script src="<?=VENDORS?>hightchart/code/modules/exporting.js"></script>
        <script src="<?=VENDORS?>hightchart/code/modules/export-data.js"></script>

        <!-- sweet alerts -->
        <script src="<?=ASSETS?>assets/sweet-alert/sweet-alert.min.js"></script>
        <script src="<?=ASSETS?>assets/sweet-alert/sweet-alert.init.js"></script>

        <!-- flot Chart -->
        <!-- <script src="<?=ASSETS?>assets/flot-chart/jquery.flot.js"></script>
        <script src="<?=ASSETS?>assets/flot-chart/jquery.flot.time.js"></script>
        <script src="<?=ASSETS?>assets/flot-chart/jquery.flot.tooltip.min.js"></script>
        <script src="<?=ASSETS?>assets/flot-chart/jquery.flot.resize.js"></script>
        <script src="<?=ASSETS?>assets/flot-chart/jquery.flot.pie.js"></script>
        <script src="<?=ASSETS?>assets/flot-chart/jquery.flot.selection.js"></script>
        <script src="<?=ASSETS?>assets/flot-chart/jquery.flot.stack.js"></script>
        <script src="<?=ASSETS?>assets/flot-chart/jquery.flot.crosshair.js"></script> -->

        <script src="<?=ASSETS?>assets/modal-effect/js/classie.js"></script>
        <script src="<?=ASSETS?>assets/modal-effect/js/modalEffects.js"></script>


        <script src="<?=VENDORS?>croppie/croppie.js"></script>
        
        <!-- CUSTOM JS -->
        <script src="<?=JS?>jquery.app.js"></script>

        <!-- Dashboard -->

        <!-- Chat -->
        <script src="<?=JS?>jquery.chat.js"></script>

        <!-- Todo -->
        <script src="<?=JS?>jquery.todo.js"></script>

        

        <script type="text/javascript">
            var app_home = "home";
            $(document).ready(function() {
                get_notification();
                setInterval(get_notification, 3000);
            })

            function get_notification() {
                $.ajax({
                    url:getUri(app_home,"get_notification"),
                    type:"post",
                    dataType:"JSON",
                    success:function(result) {

                        var total = parseInt(result.jml_pesan) + parseInt(result.jml_komentar);

                        $('#pesan_baru').text(result.jml_pesan);
                        $('#pesan_total').text(result.jml_pesan);
                        $('#total_notif').text(total);

                    }
                })
            }
        </script>
    
    </body>
</html>