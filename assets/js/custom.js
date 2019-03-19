var app_sys = "home";
function loadModul(prnt){
    var modul = $(prnt).find('.show_page');
    $.each(modul, function(i, val){
        var name = $(val).attr('data-value');
        $.ajax({
            url: getUri(app_sys,'get_modul'),
            type: 'POST', dataType: 'html',
            data: {name: name},
            beforeSend: function(){
                /*var h = ($(val).height() / 2) - 10;
                html = '<p style="padding-top: '+h+'px;text-align: center;color: #aaa;"><i class="fa fa-spin fa-spinner fa-2x"></i></p>';
                $(val).html(html);*/
            },
            success: function(result){
                $(val).html(result)
            }
        })
    })
}