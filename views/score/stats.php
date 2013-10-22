<div class="stats">
    <div id="termStats"></div>
    <div id="scoreDict"></div>
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
});

$(function(){
    $('#termStats').highcharts({
        chart: {
            type: 'bar'
        },
        title: {
            text: ''
        },
        xAxis: {
            categories: <?php echo json_encode($termNames); ?>
        },
        yAxis: {
            minTickInterval: 1
        },
        colors: ['#1abc9c', '#f1c40f'],
        series: [{
            name: '通过',
            data: <?php echo json_encode($termScoreStats[0]); ?>
        }, {
            name: '挂科',
            data: <?php echo json_encode($termScoreStats[1]); ?>
        }],
    });

    var scoreDict = eval(<?php echo json_encode($scoreDict); ?>);
    var scoreDictLabels = ['', '', '', '', ''];

    for (var i in scoreDict) {
        for (var score in scoreDict[i]) {
            scoreDictLabels[i] +=
                scoreDict[i][score][0] + '：' +
                '<b>' + scoreDict[i][score][1] + '</b><br>';
        }
    }

    $('#scoreDict').highcharts({
        title: {
            text: '成绩分布'
        },
        colors: ['#2ecc71', '#f1c40f', '#3498db', '#9b59b6', '#e74c3c'],
        tooltip: {
            formatter: function() {
                return scoreDictLabels[this.point.x];
            }
        },
        plotOptions: {
            pie: {
                allowPointSelect: true
            }
        },
        series: [{
            type: 'pie',
            showInLegend: false,
            name: 'test',
            data: [
                ['[90, 100]', len(scoreDict[0])],
                ['(80, 90]',  len(scoreDict[1])],
                ['(70, 80]',  len(scoreDict[2])],
                ['(60, 70]',  len(scoreDict[3])],
                ['[0, 60]',   len(scoreDict[4])]
            ]
        }]
    });

    function len(a) {
        return typeof(a) == 'undefined' ? 0 : a.length;
    }
});

};
</script>
