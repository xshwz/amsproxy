$('.wechat-qrcode').tooltip({
    html: true,
    placement: 'auto'
});

$('a.thumbnail').click(function(){
    $('#lightbox img')
        .attr('src', $(this).attr('data-image'))
        .height($(window).height() - 60);
});
