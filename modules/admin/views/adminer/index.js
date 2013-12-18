$('a.remove').each(function(){
    $(this).click(function(){
        $('#sid').val($(this).attr('data-sid'));
    });
});

$('#remove-modal form').ajaxForm({
    success: function() {
         window.location.reload();
    }
});
