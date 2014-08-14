/**
* $.redirect()
* Redireciona página para url encaminhada.
* @param string url
* @return void
*/
$.redirect = function (url) {
    window.location.href = url;
};

/**
* $.enable_loading()
* Show loading layer.
* @return void
*/
$.enable_loading = function() {
    $(".loading-layer").hide().show();
    $(".loading-box").hide().show();
};

/**
* $.disable_loading()
* Hide loading layer.
* @return void
*/
$.disable_loading = function () {
    $(".loading-layer").hide();
    $(".loading-box").hide();
};

/**
* $.disable_loading()
* Create a cookie.
* @param string name
* @param mixed value
* @param int days
* @return void
*/
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

/**
* $.read_cookie()
* Return a cookie value.
* @param string name
* @return mixed value
*/
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

/**
* $.erase_cookie()
* @param string name
* @return void
*/
$.erase_cookie = function(name) {
    $.create_cookie(name, "", -1);
};

/**
* $.container_html()
* Put all app content inside a html container.
* @return void
*/
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

/**
* $.change_language()
* Send an ajax call to controller app_access requesting to change language.
* After complete, automatically reload page.
* @param string language    // en_US, pt_BR, es_ES ...
* @return void
*/
$.change_language = function (language) {

    $.enable_loading();

    $.ajax({
        url: $('#URL_ROOT').val() + '/app_access/change_language/' + language,
        context: document.body,
        dataType : 'json',
        cache: false,
        type: 'POST',
        complete : function (data) {
            
            window.location.reload();

        }
    });
};




