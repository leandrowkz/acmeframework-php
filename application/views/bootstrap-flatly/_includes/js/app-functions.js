/**
* redirect()
* Redireciona página para url encaminhada.
* @param string url
* @return void
*/
function redirect (url) {
    window.location.href = url;
}

function $.enable_loading () {
    $(".loading-layer").hide().show();
    $(".loading-box").hide().show();
}

function $.disable_loading () {
    $(".loading-layer").hide();
    $(".loading-box").hide();
}

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



