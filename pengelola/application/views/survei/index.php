<div class="row">
	<div class="col-sm-12">
        <ol class="breadcrumb pull-right">
            <li><a href="#">Dashboard</a></li>
            <li class="active">Survei</li>
        </ol>
    </div>
</div>

<div class="row" id="data_berita">
	<div class="col-md-12 bx-shadow mini-stat">
		<h5 class="pull-left">Hasil Polling Kepuasan Pengguna</h5>
        <div class="clearfix"></div>
        <div id="pie_survei" style="text-align: center;">
            
        </div>
    </div>
</div>


<script type="text/javascript">
var app_survei = 'survei';
$(document).ready(function() {
    get_pie_survei();    
})


function get_pie_survei() {
    $.ajax({
        url:getUri(app_survei,"get_pie_survei"),
        type:"post",
        dataType:"JSON",
        beforeSend:function() {
            $('#pie_survei').html("<span><i class='fa fa-spinner fa-spin'></i></span> Memuat Data");
        },
        success:function(result) {
            Highcharts.chart('pie_survei', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                colors:["#0e840b","#e2df06","#ff0000"],
                credits: {
                    enabled: false
                },
                title: {
                    text: 'Hasil Poling Kepuasan'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                            style: {
                                color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                            }
                        },
                        showInLegend: true
                    }
                },
                series: [{
                    name: 'Persentasi',
                    colorByPoint: true,
                    data: result.data
                }]
            });
        },
        error:function(x,y,z) {
            console.log(x,y,z);
        }
    })
}
</script>