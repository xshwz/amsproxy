$('.courseTable .course > div').tooltip({'placement': 'auto'});

if ($.fn.datepicker) $('.date-picker').datepicker();

$('.wechat-qrcode').tooltip({
    html: true,
    placement: 'bottom'
});

$('#ajaxFeedbackForm').ajaxForm({
    beforeSubmit: function() {
        if (!$('#feedback-msg').val()) {
            alert('请填写反馈信息');
            return false;
        }
    },
    success: function() {
        alert('感谢你的反馈，我们会尽快回复的。');
        $('#feedbackModal').modal('hide');
    }
});


/** ajax send */

$('a.send').each(function(){
    $(this).click(function(){
        $('#send-form-sid').val($(this).attr('data-sid'));
        $('#reply-id').val($(this).attr('data-reply'));
    });
});

$('#ajaxSendForm').ajaxForm({
    beforeSubmit: function() {
        if (!$('#send-msg').val()) {
            alert('请填写发送信息');
            return false;
        }
    },
    success: function() {
        $('#send-modal').modal('hide');
    }
});


/** 响应式设计 */
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

    $.getScript('js/jquery.easing.js');
    var speed = 600;

    function hideSideNavbar() {
        $('#side').animate({left: -200}, speed, 'easeOutExpo');
        $('#sideMask').animate({opacity: 0}, speed, function(){
            $('#side-toggle').show();
            $(this).remove();
        });
    }

    function showSideNavBar() {
        $('#side-toggle').hide();
        $('#side').animate({left: 0}, speed, 'easeOutExpo');
        $('body').append('<div id="sideMask"></div>');
        $('#sideMask').animate({opacity: 0.5}, speed).click(function(){
            hideSideNavbar();
        });
    }

    $('#side-toggle').click(function(){
        showSideNavBar();
    });
})();


/** admin */

$('input.state').click(function(){
    $(this).parent().submit();
});

$('a.detail').each(function(){
    $(this).click(function(){
        var studentInfo = eval('(' + $(this).attr('data-json') + ')');
        var html = '<div class="form-horizontal">';
        for (var key in studentInfo) {
            html +=
                '<div class="form-group">' +
                    '<label class="col-sm-4 control-label">' +
                        key +
                    '</label>' +
                    '<div class="col-sm-8">' +
                        '<p class="form-control-static">' +
                            studentInfo[key] + 
                        '</p>' +
                    '</div>' +
                '</div>';
        }
        html += '</div>';
        $('#detail-modal .modal-body').html(html);
    });
});

/** lightbox */
$('a.lightbox').click(function(){
    $($(this).attr('href') + ' img.lightbox')
        .attr('src', $('img', this).attr('src'))
        .height($(window).height() - 60);
});
