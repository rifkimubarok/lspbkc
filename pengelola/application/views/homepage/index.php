<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12">
        <h4 class="pull-left page-title">Welcome !</h4>
        <ol class="breadcrumb pull-right">
            <li><a href="#">TEFA</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </div>
</div>

<!-- Start Widget -->
<!-- <div class="row">
    <div class="col-md-6 col-sm-6 col-lg-3">
        <div class="mini-stat clearfix bx-shadow">
            <span class="mini-stat-icon bg-info"><i class="ion-android-contacts"></i></span>
            <div class="mini-stat-info text-right text-muted">
                <span class="counter"><?=number_format($statistik->jml_pendaftar,0)?></span>
                Pendaftar Hari Ini
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-6 col-lg-3">
        <div class="mini-stat clearfix bx-shadow">
            <span class="mini-stat-icon bg-purple"><i class="fa fa-envelope-o"></i></span>
            <div class="mini-stat-info text-right text-muted">
                <span class="counter"><?=number_format($statistik->jml_pesan,0)?></span>
                Pesan Masuk
            </div>
        </div>
    </div> -->
    
    <div class="col-md-6 col-sm-6 col-lg-3">
        <div class="mini-stat clearfix bx-shadow">
            <span class="mini-stat-icon bg-success"><i class="ion-eye"></i></span>
            <div class="mini-stat-info text-right text-muted">
                <span class="counter"><?=number_format($statistik1->pengunjung,0)?></span>
                Pengunjung Hari Ini
            </div>
        </div>
    </div>

    <div class="col-md-6 col-sm-6 col-lg-3">
        <div class="mini-stat clearfix bx-shadow">
            <span class="mini-stat-icon bg-primary"><i class="ion-android-contacts"></i></span>
            <div class="mini-stat-info text-right text-muted">
                <span class="counter"><?=number_format($statistik1->online,0)?></span>
                Pengunjung Online
            </div>
        </div>
    </div>
</div> 

<div class="row" id="data_berita">
    <div class="col-md-12 bx-shadow mini-stat">
        <h5 class="pull-left">Statistik Pengunjung</h5>
        <div id="container" style="width: 100%;"></div>
        <div class="clearfix"></div>
    </div>
</div>
<!-- End row-->

<script type="text/javascript">
    $(document).ready(function() {
        $.getJSON(
            getUri("home","get_json_total_pengunjung"),
            function (data) {

                Highcharts.chart('container', {
                    chart: {
                        zoomType: 'x'
                    },
                    title: {
                        text: 'Grafik Pengunjung'
                    },
                    subtitle: {
                        text: '1 Bulan Terakhir'
                    },
                    xAxis: {
                        type: 'datetime'
                    },
                    yAxis: {
                        title: {
                            text: 'Total Pengunjung'
                        }
                    },
                    legend: {
                        enabled: false
                    },
                    plotOptions: {
                        area: {
                            fillColor: {
                                linearGradient: {
                                    x1: 0,
                                    y1: 0,
                                    x2: 0,
                                    y2: 1
                                },
                                stops: [
                                    [0, Highcharts.getOptions().colors[0]],
                                    [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                                ]
                            },
                            marker: {
                                radius: 2
                            },
                            lineWidth: 1,
                            states: {
                                hover: {
                                    lineWidth: 1
                                }
                            },
                            threshold: null
                        }
                    },

                    series: [{
                        type: 'area',
                        name: 'Pengunjung',
                        data: data
                    }]
                });
            }
        );
    })
</script>