<?php if (!isset($message)): ?>
  Highcharts.setOptions({
    credits: {
      enabled: false
    },
    tooltip: {
      borderWidth: 0,
      shadow: false,
      backgroundColor: 'rgba(44, 62, 80, 0.96)',
      style: {
        color: '#ecf0f1'
      }
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
        text: ''
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

    var credits = eval(<?php echo json_encode($credits); ?>); 

    $('#credits').highcharts({
      chart: {
        type: 'column'
      },
      title: {
        text: ''
      },
      xAxis: {
        categories: ['']
      },
      colors: ['#1abc9c', '#f1c40f', '#2ecc71', '#e67e22', '#3498db', '#e74c3c', '#9b59b6', '#16a085', '#f39c12', '#27ae60', '#d35400', '#2980b9', '#c0392b', '#8e44ad', '#bdc3c7', '#2c3e50', '#7f8c8d'],
      tooltip: {
        formatter: function() {
          var courses = ''
          $.each(credits.credits[this.series.name].courses, function (i, course) {
            if ($.isPlainObject(course)) {
              courses += course.name + ' <b>' + course.credit + '</b><br>';
            }
          })
          return '<tspan style="font-size: 14px; fill: ' + this.series.color + ';">' + this.series.name + '</tspan><br>' + courses;
        }
      },
      series: [
        <?php foreach ($credits['credits'] as $name => $item): ?>
        {
          name: '<?php echo $name ?>',
          data: [<?php echo $item['count'] ?>],
          dataLabels: {
            enabled: true,
          }
        },
        <?php endforeach ?>
      ]
    });

    function len(a) {
      return typeof(a) == 'undefined' ? 0 : a.length;
    }
  });
  <?php endif; ?>
