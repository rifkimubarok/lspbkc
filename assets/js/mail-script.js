    // -------   Mail Send ajax

     $(document).ready(function() {
        var form = $('#myForm'); // contact form
        var submit = $('.submit-btn'); // submit button
        var alert = $('.alert-msg'); // alert div for show alert message

        // form submit event
        form.on('submit', function(e) {
                e.preventDefault(); // prevent default form submit
                var nama = $('#nama').val();
                var email = $('#email').val();
                var subjek = $('#subjek').val();
                var pesan = $('#pesan').val();
                $.ajax({
                    url:getUri("kontak","kirim_pesan"),
                    type:"post",
                    dataType:"JSON",
                    data:{nama:nama,email:email,subjek:subjek,pesan:pesan},
                    beforeSend:loading_screen,
                    success:function(data) {
                        swal("Pesan Terkirim"," ","success");
                    },
                    error:gagal_screen,
                })
                return false;
        });
    })