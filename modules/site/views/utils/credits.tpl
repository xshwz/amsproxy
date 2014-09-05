<script src="http://cdn.staticfile.org/angular.js/1.2.0rc3/angular.min.js"></script>
<script>
var creditsCtrl = function ($scope) {
  $scope.scores = [{score: 0, credit: 0}]

  $scope.score_delete = function (index) {
    if ($scope.scores.length > 1) {
      $scope.scores.splice(index, 1)
    }
  }

  $scope.score_add = function () {
    $scope.scores.push({score: null, credit: null})
  }

  $scope.$watch('scores', function () {
    $scope.sumCredit = 0
    $scope.sumGPA = 0
    $scope.sumScore = 0

    $.each($scope.scores, function(i, item) {
      item.credit = Number(item.credit)
      item.score = Number(item.score)

      if (item.credit && item.score) {
        $scope.sumCredit += item.credit
        $scope.sumScore += item.score
        $scope.sumGPA += GPA(item.score, item.credit)
      }
    })

    $scope.average = ($scope.sumScore / $scope.scores.length).toFixed(2)
    $scope.averageGPA = ($scope.sumGPA / $scope.sumCredit).toFixed(2)
  }, true)

  function GPA(score, credit) {
    if (score < 60) {
      return 0
    } else {
      return parseFloat((GP(score) * credit).toFixed(2))
    }
  }

  function GP(score) {
    if (score < 60) {
      return 0
    } else {
      return parseFloat((score / 10 - 5).toFixed(1))
    }
  }
}

angular.element(document).ready(function() {
  angular.bootstrap(document)
})
</script>
<style>
.table {
  width: auto;
}
</style>
<div ng-controller="creditsCtrl">
  <div class="page-header">
    <h3>平均学分绩点计算</h3>
  </div>
  <table class="table">
    <thead>
      <tr>
        <th>学分</th>
        <th>成绩</th>
        <th>操作</th>
      </tr>
    </thead>
    <tbody>
      <tr ng-repeat="score in scores">
        <td>
          <input type="text" ng-model="score.credit" class="form-control">
        </td>
        <td>
          <input type="text" ng-model="score.score" class="form-control">
        </td>
        <td>
          <button ng-click="score_delete($index)" class="btn btn-danger">
            <span class="glyphicon glyphicon-remove"></span>
          </button>
        </td>
      </tr>
      <tr>
        <td colspan="3">
          <button ng-click="score_add()" class="btn btn-primary btn-block">
            <span class="glyphicon glyphicon-plus"></span>
          </button>
        </td>
      </tr>
      <tr>
        <td colspan="3">
          <label class="control-label">总分：</label>
          <span class="form-control-static">{{sumScore}}</span>
        </td>
      </tr>
      <tr>
        <td colspan="3">
          <label class="control-label">平均分：</label>
          <span class="form-control-static">{{average}}</span>
        </td>
      </tr>
      <tr>
        <td colspan="3">
          <label class="control-label">总学分：</label>
          <span class="form-control-static">{{sumCredit}}</span>
        </td>
      </tr>
      <tr>
        <td colspan="3">
          <label class="control-label">总学分绩点：</label>
          <span class="form-control-static">{{sumGPA}}</span>
        </td>
      </tr>
      <tr>
        <td colspan="3">
          <label class="control-label">平均学分绩点：</label>
          <span class="form-control-static">{{averageGPA}}</span>
        </td>
      </tr>
    </tbody>
  </table>
</div>
