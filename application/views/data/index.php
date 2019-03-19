<div class="single-post-wrap">
	<!-- <div class="feature-img-thumb relative">
		<div class="overlay overlay-bg"></div>
		<img class="img-fluid" src="<?=IMAGES?>f1.jpg" alt="">
	</div> -->
	<div class="content-wrap">
	<!-- 	<ul class="tags mt-10">
			<li><a href="#">Food Habit</a></li>
		</ul> -->
		<a href="#">
			<h3>Data Purna Pasma</h3>
		</a>
		<ul class="meta pb-20">
			<!-- <li><a href="#"><span class="lnr lnr-user"></span>Mark wiens</a></li>
			<li><a href="#"><span class="lnr lnr-calendar-full"></span>28 January, 2016</a></li> -->
		</ul>
		<p align="justify">
			<div class="form-group col-md-6">
				<select class="form-control" id="tahun_krn">
				</select>
			</div>
			<table class="table table-striped" id="table-anggota" style="width: 100%;">
				<thead>
					<tr>
						<th>No</th>
						<th>Nama</th>
						<th>JK</th>
						<th>Daerah Asal KRN</th>
						<th>Daerah Tugas KRN</th>
						<th>Tahun KRN</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</p>
	<div class="clearfix"></div>
</div>
</div>
<script type="text/javascript">
	var app_member = 'data'
	get_angkatan();

	$('#tahun_krn').change(function() {
		var table = $('#table-anggota').dataTable().api();
		table.ajax.reload();
	});
	
	function get_anggota() {
		$('#table-anggota').dataTable({
			"processing": true,
	        "serverSide": true,
	        "scrollY":"200px",
	        "scrollCollapse": true,
	        paging: true,
	        responsive: true,
	        "order": [],
	        "ajax": {
	            "url": getUri(app_member,'get_member'),
	            "type": "POST",
	            data:function(data) {
	            	data.tahun_krn = get_tahunkrn();
	            },
	            complete:function() {
	            	$('#table-anggota_wrapper').removeClass('form-inline');
	            	$('#table-anggota_filter input').removeClass("form-control");
	            	$('#table-anggota_filter input').attr("style","width:200px;");
	            }           
	        }
		});
	}

	function get_angkatan() {
   		$.ajax({
   			url:getUri(app_member,"get_angkatan"),
   			type:"post",
   			dataType:"JSON",
   			success:function(result) {
   				var option ="<option value='' selected>- Semua Angkatan -</option>";
   				for(var i = 0; i < result.length;i++){
   					var text = result[i]['tahun_krn'];
   					option += "<option value='"+text+"'> Purna Pasma KRN "+text+" </option>";
   				}
   				$('#tahun_krn').html(option);

   			},
   			complete:function() {
   				get_anggota();
   			},
   			error:function() {
   				alert("gagal");
   			}
   		});
   	}

   	function get_tahunkrn() {
   		return $('#tahun_krn').val();
   	}
</script>