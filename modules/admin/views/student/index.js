$('#search-submit').click(function(){
    $('#search-form').attr('action',
        document.baseURI +
        'admin/student/index/keyword/' +
        $('#search-keyword').val());
})
