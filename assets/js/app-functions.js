/**
 * Redirects the page to the given URL.
 *
 * @param string url
 * @return void
 */
$.redirect = function (url) {
    window.location.href = url;
};

/**
 * Shows the loading layer. Recommended for ajax calls.
 *
 * @return void
 */
$.enable_loading = function() {
    $(".loading-layer").hide().show();
    $(".loading-box").hide().show();
};

/**
 * Hides the loading layer.
 *
 * @return void
 */
$.disable_loading = function () {
    $(".loading-layer").hide();
    $(".loading-box").hide();
};

/**
 * Creates a cookie.
 *
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
 * Returns a cookie value.
 *
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
 * Erase a cookie.
 *
 * @param string name
 * @return void
 */
$.erase_cookie = function(name) {
    $.create_cookie(name, "", -1);
};

/**
 * Puts all app content inside a html container.
 *
 * @return void
 */
$.container_html = function () {

    // Put all content inside the container
    if ($('.module-header .container').length <= 0) {
        $('.module-header').wrapInner('<div class="container"></div>');
        $('.module-body').wrapInner('<div class="container"></div>');
        $('.navbar-fixed-top').wrapInner('<div class="container"></div>');

        // Set cookie for this shit (365 days)
        $.create_cookie('container-html', true, 365);
    } else {
        $('.module-header .container > *').unwrap();
        $('.module-body .container > *').unwrap();
        $('.navbar-fixed-top .container > *').unwrap();

        // Destroy the cookie
        $.erase_cookie('container-html');
    }
};

/**
 * Toggle all app content inside a box container. Only used on
 * template AdminLTE.
 *
 * @return void
 */
$.layout_boxed = function () {

    var cookie;

    // Put all content inside the container
    if ($('body').hasClass('fixed')) {

        // Boxed layout
        $('body').removeClass('fixed').addClass('layout-boxed');

        // Set cookie value (class name)
        cookie = 'layout-boxed';

    } else {

        // Fixed layout
        $('body').removeClass('layout-boxed').addClass('fixed');

        // Set cookie value (class name)
        cookie = 'fixed';
    }

    // Set cookie for this layout mode
    $.create_cookie('body-layout', cookie, 365);
};

/**
 * Send an ajax call to controller app_access requesting to change language.
 * After complete, automatically reloads page.
 *
 * @param string language    // en_US, pt_BR, es_ES ...
 * @return void
 */
$.change_language = function (language) {

    $.enable_loading();

    $.ajax({
        url: $('#URL_ROOT').val() + '/app-login/change-language/' + language,
        context: document.body,
        dataType : 'json',
        cache: false,
        type: 'POST',
        complete : function (data) {
            window.location.reload();
        }
    });
};




