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
        $('#side>ul').css('height',
            $(window).height() - $('.side-header').height());
    }

    $(window).load(resize).resize(resize);

    $.getScript('js/libs/jquery.easing.js');
    var speed = 600;

    function hideSideNavbar() {
        $('#main').css('left', 0);
        $('#side').css('left', -200);
    }

    function showSideNavBar() {
        $('#main').css('left', 200);
        $('#side').css('left', 0);
        $('#side>ul').focus();
    }

    $('#side-toggle').click(function(){
        if ($(this).hasClass('on')) {
            hideSideNavbar();
            $(this).removeClass('on');
        } else {
            showSideNavBar();
            $(this).addClass('on');
        }
    });
})();
