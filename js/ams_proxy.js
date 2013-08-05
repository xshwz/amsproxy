(function(){
    var oldPageX, oldPageY, scrollLeft;
    $('.accordion-inner').on('touchstart', function(e){
        startPageX = e.originalEvent.changedTouches[0].pageX;
        oldPageX = e.originalEvent.changedTouches[0].pageX;
        oldPageY = e.originalEvent.changedTouches[0].pageY;
        scrollLeft = $(this).scrollLeft();
    }).on('touchmove', function(e) {
        if (e.originalEvent.changedTouches.length == 1) {
            var nowPageX = e.originalEvent.changedTouches[0].pageX;
            var nowPageY = e.originalEvent.changedTouches[0].pageY;
            if (Math.abs(nowPageY - oldPageY) < 10) {
                e.preventDefault();
                scrollLeft += (oldPageX - nowPageX) * 3;
                $(this).scrollLeft(scrollLeft);
                oldPageX = nowPageX;
            }
        }
    });
})();
