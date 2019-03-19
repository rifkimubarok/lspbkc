<style type="text/css">
	table tbody tr {
		cursor: pointer;
	}
</style>
<div class="row">
	<div class="col-sm-12">
        <ol class="breadcrumb pull-right">
            <li><a href="#">Dashboard</a></li>
            <li class="active">Kotak Masuk</li>
        </ol>
    </div>
</div>

<div class="row" id="data_berita">
	<div class="col-lg-3 col-md-4">
	    <div class="panel panel-default p-0  m-t-20">
	        <div class="panel-body p-0">
	            <div class="list-group mail-list menu_message">
	              <a href="#" class="list-group-item no-border active" data-value="kotak_masuk_data"><i class="fa fa-download m-r-5"></i>Pesan Masuk </a>
	              <a href="#" class="list-group-item no-border" data-value="kotak_keluar_data"><i class="fa fa-paper-plane-o m-r-5"></i>Pesan Keluar</a>
	            </div>
	        </div>
	    </div>
	</div>
	<div class="col-lg-9 col-md-8">
	    <div class="row">
	        <div class="col-lg-12">
	            <div class="btn-toolbar" role="toolbar">
	            </div>
	        </div>
	    </div> <!-- End row -->
	    
	    <div class="panel panel-default m-t-20">
	        <div class="panel-body">
	            <div class="table-responsive" id="content_">
	                
	            </div>
	            
	            <hr>
	            
	            <!-- <div class="row">
	                <div class="col-xs-7">
	                    Showing 1 - 20 of 289
	                </div>
	                <div class="col-xs-5">
	                    <div class="btn-group pull-right">
	                      <button type="button" class="btn btn-default waves-effect"><i class="fa fa-chevron-left"></i></button>
	                      <button type="button" class="btn btn-default waves-effect"><i class="fa fa-chevron-right"></i></button>
	                    </div>
	                </div>
	            </div> -->
	        
	        </div> <!-- panel body -->
	    </div> <!-- panel -->
	</div>
</div>
<script type="text/javascript">
	var app_message = "kontak";
	function get_data(page,data=null) {
		$.ajax({
			url:getUri(app_message,"get_content"),
			data:{page:page,data:data},
			dataType:"html",
			type:"POST",
			success:function(result) {
				$('#content_').html(result);
			}
		})
	}

	$('.menu_message a').click(function() {
		value = $(this).attr("data-value");
		$('.menu_message a').each(function(item) {
			$(this).removeClass('active');
		})
		$(this).addClass('active');
		get_data(value);
		return false;
	});
	$('.menu_message a.active').click();

	function read_message(item) {
		var i = $(item);
		var data = {data:i.attr("data-value"),type:i.attr("data-page")}
		get_data("detail_pesan",data);
	}

	function replay_message(item) {
		data = {id:$(item).attr("data-value")};
		$.ajax({
			url:getUri(app_message,"compose"),
			data:{data:data},
			dataType:"html",
			type:"POST",
			success:function(result) {
				$('#content_').html(result);
			}
		})
	}

	function delete_data() {
		return false;
	}
</script>