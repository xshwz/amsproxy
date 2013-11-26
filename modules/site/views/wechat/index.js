$('.wechat-qrcode').tooltip({
    html: true,
    placement: 'auto'
});

$('a.lightbox').click(function(){
    $($(this).attr('href') + ' img.lightbox')
        .attr('src', $('img', this).attr('src'))
        .height($(window).height() - 60);
});
