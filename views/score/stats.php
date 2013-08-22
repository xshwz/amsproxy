<canvas id="termStats" width="760" height="760"></canvas>
<script>
$(document).ready(function(){
    new Chart(document.getElementById('termStats').getContext('2d')).Bar(
        {
            labels : <?php echo json_encode($termNames);?>,
            datasets : [
                {
                    fillColor : 'rgba(46, 204, 113,1.0)',
                    data : <?php echo json_encode($termScoreStats[0]);?>
                },
                {
                    fillColor : 'rgba(231, 76, 60,1.0)',
                    data : <?php echo json_encode($termScoreStats[1]);?>
                }
            ]
        },
        {
            scaleOverride : true,
            scaleSteps : 10,
            scaleStepWidth : 1,
            scaleStartValue : 0
        }
    );
    document.getElementById('termStats').style.width = '100%';
    document.getElementById('termStats').style.height = 'auto';
});
</script>
