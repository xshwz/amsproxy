Highcharts.setOptions({
    credits: {
        enabled: false
    },
    tooltip: {
        borderWidth: 0,
        shadow: false,
        backgroundColor: 'rgba(44, 62, 80, 0.96)',
        style: {
            color: '#ecf0f1'
        }
    },
    yAxis: {
        title: {
            text: ''
        }
    },
});

/** 响应式布局 */
(function(){
    function resize() {
        $('#main').css('height', $(document).height());
        if ($(window).width() < 768) {
            $('#side').css('height', $(window).height());
        } else {
            $('#side').css('height', $(document).height());
        }
    }

    $(window).load(resize).resize(resize);

    $.getScript('js/libs/jquery.easing.js');
    var speed = 600;

    function hideSideNavbar() {
        $('#side').animate({left: -200}, speed, 'easeOutExpo');
        $('#side-mask').animate({opacity: 0}, speed, function(){
            $('#side-toggle').show();
            $(this).remove();
        });
    }

    function showSideNavBar() {
        $('#side-toggle').hide();
        $('#side').animate({left: 0}, speed, 'easeOutExpo');
        $('body').append('<div id="side-mask"></div>');
        $('#side-mask').animate({opacity: 0.5}, speed).click(function(){
            hideSideNavbar();
        });
    }

    $('#side-toggle').click(function(){
        showSideNavBar();
    });
})();
