<div class="article stats">
    <div id="termStats"></div>
    <div id="scoreDict"></div>
</div>

<script src="js/highcharts.js"></script>
<script>
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
    }
});
$(function(){
    $('#termStats').highcharts({
        chart: {
            type: 'bar'
        },
        title: {
            text: '学期科目统计图'
        },
        xAxis: {
            categories: <?php echo json_encode($termNames); ?>
        },
        yAxis: {
            minTickInterval: 1
        },
        colors: ['#2ecc71', '#e74c3c'],
        series: [{
            name: '通过',
            data: <?php echo json_encode($termScoreStats[0]); ?>
        }, {
            name: '挂科',
            data: <?php echo json_encode($termScoreStats[1]); ?>
        }],
    });

    $('#scoreDict').highcharts({
        title: {
            text: '成绩分布图'
        },
        colors: ['#2ecc71', '#f1c40f', '#3498db', '#9b59b6', '#e74c3c'],
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer'
            }
        },
        series: [{
            type: 'pie',
            data: [
                ['[100, 90]', <?php echo $scoreDict[0]; ?>],
                ['(90, 80]',  <?php echo $scoreDict[1]; ?>],
                ['(80, 70]',  <?php echo $scoreDict[2]; ?>],
                ['(70, 60]',  <?php echo $scoreDict[3]; ?>],
                ['[60, 0]',   <?php echo $scoreDict[4]; ?>]
            ]
        }]
    });
});
</script>
