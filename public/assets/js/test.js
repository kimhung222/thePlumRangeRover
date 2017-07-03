function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires + "; path=/local";
    document.cookie = cname + "=" + cvalue + "; " + expires + "; path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}


$(document).ready(function() {
    $('.add').on('click', function(ev) {
        var current_id = $(this).attr("data-id");
        var cart = getCookie('cart');
        if (typeof(cart) === 'undefined') {
            setCookie('cart', current_id, 3);

        } else {
            console.log(cart);
            cart = cart + ' ' + current_id;
            console.log(cart);
            setCookie('cart', cart, 3);

        }
        //
        $('.alert').css({
            'visibility': 'visible'
        });
        $(".alert").fadeOut(4000);
        ev.stopPropagation();
    });

    $('.del').on('click', function(ev) {
        var val = $(this).data('id').toString();
        var cart = getCookie('cart');
        var items = cart.split(' ');
        if (items.length === 1) {
            setCookie('cart', '', 3);
            window.location.href = "/local";
        } else {
            var res = '';
            var flag = 1;
            for (var i = 0; i < items.length; i++) {
                if (items[i] === val && flag === 1) {
                    flag = 0;
                    continue;
                }
                res = res + ' ' + items[i];
            }
            setCookie('cart', res, 3);
            window.location.href = "/local";
        }
        ev.stopPropagation();
    });
    // $('.linh').on('click',function(ev){
    // 	$('#myModal').show();
    // 	setTimeout(function(){
    // 		$("#myModal").hide();
    // 	}, 3000);
    // });

    $('.cancel').on('click', function(ev) {
        setCookie('cart', '', 1);
        window.location.href = "/listgames";
        ev.stopPropagation();
    });

    // Modal FullScreen

    $(".modal-fullscreen").on('show.bs.modal', function() {
        setTimeout(function() {
            $(".modal-backdrop").addClass("modal-backdrop-fullscreen");
        }, 0);
    });
    $(".modal-fullscreen").on('hidden.bs.modal', function() {
        $(".modal-backdrop").addClass("modal-backdrop-fullscreen");
    });


});