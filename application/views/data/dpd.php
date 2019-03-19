<style type="text/css">
	.middle-search{
		position: absolute;
	}
</style>
<div class="single-post-wrap">
	<!-- <div class="feature-img-thumb relative">
		<div class="overlay overlay-bg"></div>
		<img class="img-fluid" src="<?=IMAGES?>f1.jpg" alt="">
	</div> -->
	<div class="content">
	<!-- 	<ul class="tags mt-10">
			<li><a href="#">Food Habit</a></li>
		</ul> -->
		<a href="#">
			<h3>Data Pengurus DPD</h3>
		</a>
		<ul class="meta pb-20">
			<!-- <li><a href="#"><span class="lnr lnr-user"></span>Mark wiens</a></li>
			<li><a href="#"><span class="lnr lnr-calendar-full"></span>28 January, 2016</a></li> -->
		</ul>
			<div class="form-group col-md-4">
				<select class="form-control" id="provinsi">
				</select>
			</div>
			<div class="col-md-12">
				<table class="table" id="table-anggota" style="width: 100%!important;">
					<thead>
						<tr>
							<th>No.</th>
							<th>No KTA</th>
							<th>Nama Lengkap</th>
							<th>Jabatan</th>
							<th>Alamat</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
	<div class="clearfix"></div>
</div>
</div>
<script type="text/javascript">
	var app_dpd = 'dpd';
	var table ;
	
	get_refprovinsi();

	$('#provinsi').change(function() {
		table = $('#table-anggota').dataTable().api();
		table.ajax.reload();
	});
	
	function get_refprovinsi() {
   		$.ajax({
   			url:getUri(app_dpd,"ref_provinsi"),
   			type:"post",
   			dataType:"JSON",
   			success:function(result) {
   				var option ='';
   				for(var i = 0; i<result.length;i++){
   					var isi = result[i]['kode'];
   					var text = result[i]['name'];
   					option += "<option value='"+isi+"'> "+text+" </option>";
   				}
   				$('#provinsi').html(option);
   				$('#provinsi').val('11');

   			},
   			complete:function() {
   				get_dpd();
   			},
   			error:function() {
   				alert("gagal");
   			}
   		});
   	}

   	function get_provinsi() {
   		return $('#provinsi').val();
   	}

   	function get_dpd() {
   		table = $('#table-anggota').dataTable({
			"processing": true,
	        "serverSide": true,
	        "scrollY":"200px",
	        "scrollCollapse": true,
	        paging: true,
	        responsive: true,
	        "order": [],
	        "ajax": {
	            "url": getUri(app_dpd,'get_dpd'),
	            "type": "POST",
	            data:function(data) {
	            	data.provinsi = get_provinsi();
	            },
	            complete:function() {
	            	$('#table-anggota_wrapper').removeClass("form-inline");
	            	$('.dataTables_scrollHeadInner').css("width","100%");
	            	$('table').removeAttr("style");
	            	$('#table-anggota_filter input').removeClass("form-control");
	            	$('#table-anggota_filter input').attr("style","width:200px;");
	            }           
	        }
		});
   	}
</script>