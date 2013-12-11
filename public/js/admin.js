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

$('a.send').each(function(){
    $(this).click(function(){
        $('#send-form-sid').val($(this).attr('data-sid'));
        $('#reply-id').val($(this).attr('data-reply'));
    });
});

$('a.edit').each(function(){
    $(this).click(function(){
        $('#message-content').val($(this).prevAll().filter('p').text());
        $('#message-id').val($(this).attr('data-id'));
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

$('#edit-form').ajaxForm({
    success: function() {
        $('#edit-modal').modal('hide');
    }
});

$('a.detail').each(function(){
    $(this).click(function(){
        var studentInfo = eval('(' + $(this).attr('data-json') + ')');
        var html = '<div class="form-horizontal">';
        for (var key in studentInfo) {
            html +=
                '<div class="form-group">' +
                    '<label class="col-xs-5 control-label">' +
                        key +
                    '</label>' +
                    '<div class="col-xs-7">' +
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
