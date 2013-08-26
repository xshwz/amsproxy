$('.courseTable .course > div').tooltip();

$('#ajaxFeedbackForm').ajaxForm({
    beforeSubmit: function() {
        if (!$('#feedback-msg').val()) {
            alert('请填写反馈信息');
            return false;
        }
    },
    success: function() {
        alert('感谢你的反馈，我们会尽快回复。');
        $('#feedbackModal').modal('hide');
    }
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

$('a.send').each(function(){
    $(this).click(function(){
        $('#send-form-sid').val($(this).attr('data-sid'));
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

$('input.state').click(function(){
    $(this).parent().submit();
});
