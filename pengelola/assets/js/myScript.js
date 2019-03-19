/**
 * Created by Dodi Ariyanto on 4/20/18.
 */

function getUri(controller, function_name, alias){return document.location.origin+ '/pengelola' + (alias != null ? '/' + alias : '') + (controller != null ? '/' + controller : '') + (function_name != null ? '/' + function_name : '')}

function validateEmail(email)
{
    var re = /\S+@\S+\.\S+/;
    return re.test(email);
}

function URLToArray(url) {
    var request = {};
    var pairs = url.substring(url.indexOf('?') + 1).split('&');
    for (var i = 0; i < pairs.length; i++) {
        if(!pairs[i])
            continue;
        var pair = pairs[i].split('=');
        request[decodeURIComponent(pair[0])] = decodeURIComponent(pair[1]);
    }
    return request;
}

function loading_screen() {
    swal({   
        title: "Mohon Tunggu!",   
        text: "Sedang Memproses.",   
        imageUrl: getUri("assets","images/loading.gif"), 
        showConfirmButton:false
    });
}

function gagal_screen() {
    swal("GAGAL!", "Terjadi Kesalahan.\nSilahkan Coba Lagi.",'error');
}

function getUriOrigin(controller, function_name, alias){return document.location.origin+ (alias != null ? '/' + alias : '') + (controller != null ? '/' + controller : '') + (function_name != null ? '/' + function_name : '')}