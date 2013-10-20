<div class="article stats">
    <div id="gradeStats"></div>
    <div id="genderStats"></div>
    <div id="nationStats"></div>
    <div id="collegeStats"></div>
    <div class="panel-group accordion" id="accordion"></div>
</div>
<script>
window.onload = function(){

Highcharts.setOptions({
    credits: {
        enabled: false
    },
    tooltip: {
        borderWidth: 0,
        shadow: false
    },
    yAxis: {
        title: {
            text: ''
        }
    },
    colors: [
        '#1abc9c',
        '#f1c40f',
        '#2ecc71',
        '#e67e22',
        '#3498db',
        '#e74c3c',
        '#9b59b6',
        '#ecf0f1',
        '#34495e',
        '#95a5a6',
        '#16a085',
        '#f39c12',
        '#27ae60',
        '#d35400',
        '#2980b9',
        '#c0392b',
        '#8e44ad',
        '#bdc3c7',
        '#2c3e50',
        '#7f8c8d'
    ],
    plotOptions: {
        pie: {
            allowPointSelect: true
        }
    }
});

$(function(){
    $('#genderStats').highcharts({
        title: {
            text: '性别'
        },
        colors: ['#3498db', '#e74c3c'],
        series: [{
            type: 'pie',
            name: '性别',
            data: [
                ['男', <?php echo $stats['gender']['男']; ?>],
                ['女',  <?php echo $stats['gender']['女']; ?>]
            ]
        }]
    });

    $('#collegeStats').highcharts({
        title: {
            text: '学院'
        },
        series: [{
            type: 'pie',
            name: '学院',
            data: [
                <?php
                foreach ($stats['college'] as $collegeName => $college)
                    echo "['{$collegeName}', {$college['count']}],";
                ?>
            ]
        }]
    });

    $('#gradeStats').highcharts({
        title: {
            text: '年级'
        },
        series: [{
            type: 'pie',
            name: '年级',
            data: [
                <?php
                foreach ($stats['grade'] as $gradeName => $grade)
                    echo "['{$gradeName}', {$grade}],";
                ?>
            ]
        }]
    });

    /*
    $('#nationStats').highcharts({
        title: {
            text: '民族'
        },
        series: [{
            type: 'pie',
            name: '民族',
            data: [
                <?php
                foreach ($stats['nation'] as $nationName => $nation)
                    echo "['{$nationName}', {$nation}],";
                ?>
            ]
        }]
    });
    */

    var colleges = <?php echo json_encode($stats['college']); ?>;
    for (var collegeName in colleges) {
        var college = colleges[collegeName];
        var disciplines = college['discipline'];
        $('#accordion').append(
            '<div class="panel">' +
                '<div class="panel-heading">' +
                    '<h4 class="panel-title">' +
                        '<a ' +
                            'class="accordion-toggle collapsed" ' +
                            'data-toggle="collapse" ' + 
                            'data-parent="#accordion" ' +
                            'href="#' + collegeName + '">' +
                            collegeName +
                            '<span class="badge pull-right">' +
                                college.count +
                            '</span>' +
                        '</a>' +
                    '</h4>' +
                '</div>' +
                '<div ' +
                    'id="' + collegeName + '" ' +
                    'class="panel-collapse collapse">' +
                    '<div class="panel-body">' +
                        '<div id="college-' + collegeName + '"></div>' +
                    '</div>' +
                '</div>' +
            '</div>');

        var data = [];
        for (var discipline in disciplines)
            data.push([discipline, disciplines[discipline]]);

        $('#college-' + collegeName).highcharts({
            chart: {
                backgroundColor: '#f9f9f9'
            },
            title: {
                text: ''
            },
            series: [{
                type: 'pie',
                name: '专业',
                data: data
            }]
        });
    }
});

}
</script>
