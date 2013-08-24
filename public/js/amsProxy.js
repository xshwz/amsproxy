$('.courseTable .course > div').tooltip();

$('#ajaxFeedbackForm').ajaxForm({
    success: function() {
        alert('感谢你的反馈，我们会尽快处理。');
        $('#feedbackModal').modal('hide');
    }
});

$('a.detail').each(function(){
    var $this = $(this);
    $this.click(function(){
        var studentInfo = eval('(' + $this.attr('data-json') + ')');
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
