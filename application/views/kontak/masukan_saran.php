<div class="row contact-wrap">
	<div class="col-lg-12">
		<h3>Masukan dan Saran</h3>
		<br>
		<form class="form-area contact-form text-right" id="myForm" method="post">
			<div class="row">
				<div class="col-lg-6">
					<input name="name" id="nama" placeholder="Nama Lengkap" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Nama Lengkap'" class="common-input mb-20 form-control" required="" type="text">
					
					<input name="email" id="email" placeholder="Alamat Email" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Alamat Email'" class="common-input mb-20 form-control" required="" type="email">
					<input name="subject" id="subjek" placeholder="Subjek" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Subjek'" class="common-input mb-20 form-control" required="" type="text">
				</div>
				<div class="col-lg-6">
					<textarea class="common-textarea form-control" id="pesan" name="message" placeholder="Masukan dan Saran" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Masukan dan Saran'" required=""></textarea>
				</div>
				<div class="col-lg-12">
					<div class="alert-msg" style="text-align: left;"></div>
					<button class="primary-btn primary" style="float: right;">Send Message</button>
				</div>
			</div>
		</form>
	</div>
</div>