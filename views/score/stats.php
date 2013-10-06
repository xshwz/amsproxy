<div class="stats">
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
    },
});
$(function(){
    $('#termStats').highcharts({
        chart: {
            type: 'bar'
        },
        title: {
            text: '学期科目统计'
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
            text: '成绩分布'
        },
        colors: ['#2ecc71', '#f1c40f', '#3498db', '#9b59b6', '#e74c3c'],
        plotOptions: {
            pie: {
                allowPointSelect: true
            }
        },
        series: [{
            type: 'pie',
            name: '分数段',
            data: [
                ['[90, 100]', <?php echo $scoreDict[0]; ?>],
                ['(80, 90]',  <?php echo $scoreDict[1]; ?>],
                ['(70, 80]',  <?php echo $scoreDict[2]; ?>],
                ['(60, 70]',  <?php echo $scoreDict[3]; ?>],
                ['[0, 60]',   <?php echo $scoreDict[4]; ?>]
            ]
        }]
    });
});
</script>
