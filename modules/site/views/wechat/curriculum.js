$('.courseTable .course > div').popover({
    'placement': 'auto'
}).on('shown.bs.popover', function () {
    $('abbr').tooltip({placement: 'auto', html: true});
})
