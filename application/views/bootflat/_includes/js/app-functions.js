/**
* redirect()
* Redireciona página para url encaminhada.
* @param string url
* @return void
*/
function redirect (url) {
    window.location.href = url;
}

function enable_loading () {
    $(".loading-layer").hide().show();
    $(".loading-box").hide().show();
}

function disable_loading () {
    $(".loading-layer").hide();
    $(".loading-box").hide();
}

$.create_cookie = function (name, value, days) {
    var expires;

    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toGMTString();
    } else {
        expires = "";
    }
    document.cookie = escape(name) + "=" + escape(value) + expires + "; path=/";
};

$.read_cookie = function (name) {
    var nameEQ = escape(name) + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) === ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) === 0) return unescape(c.substring(nameEQ.length, c.length));
    }
    return null;
};

$.erase_cookie = function(name) {
    $.create_cookie(name, "", -1);
};

$.container_html = function () {

    // put all content inside the container
    if($('.module-header .container').length <= 0) {
        $('.module-header').wrapInner('<div class="container"></div>');
        $('.module-body').wrapInner('<div class="container"></div>');
        $('.navbar-fixed-top').wrapInner('<div class="container"></div>');
        
        // set cookie for this shit (365 days)
        $.create_cookie('container-html', true, 365);
    } else {
        $('.module-header .container > *').unwrap();
        $('.module-body .container > *').unwrap();
        $('.navbar-fixed-top .container > *').unwrap();
    
        // destroy the cookie
        $.erase_cookie('container-html');
    }
};

//Loads the correct sidebar on window load
$(function() {

    $(window).bind("load", function() {
        console.log($(this).width())
        if ($(this).width() < 768) {
            $('div.sidebar-collapse').addClass('collapse')
        } else {
            $('div.sidebar-collapse').removeClass('collapse')
        }
    })
})

//Collapses the sidebar on window resize
$(function() {

    $(window).bind("resize", function() {
        console.log($(this).width())
        if ($(this).width() < 768) {
            $('div.sidebar-collapse').addClass('collapse')
        } else {
            $('div.sidebar-collapse').removeClass('collapse')
        }
    })
})



