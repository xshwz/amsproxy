$('#edit-form').ajaxForm({
    success: function() {
         window.location.reload();
    }
});

$('#sendForm').ajaxForm({
    beforeSubmit: function() {
        if (!$('#send-msg').val()) {
            alert('请填写发送信息');
            return false;
        }
    },
    success: function() {
         window.location.reload();
    }
});

$('a.edit').each(function(){
    $(this).click(function(){
        $('#message-content').val($(this).prevAll().filter('p').text());
        $('#message-id').val($(this).attr('data-id'));
    });
});
