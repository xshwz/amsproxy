$('.courseTable .course > div').tooltip();

$('#ajaxFeedbackForm').ajaxForm({
    success: function() {
        alert('感谢你的反馈，我们会尽快处理。');
        $('#feedbackModal').modal('hide');
    }
});
