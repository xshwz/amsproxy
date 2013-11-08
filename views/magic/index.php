<div class="form-horizontal scoreList">
    <?php foreach ($specialized as $scoreName => $score): ?>
    <div class="form-group">
        <label for="<?php echo $scoreName; ?>" class="col-sm-4 control-label">
            <?php echo $scoreName; ?>
        </label>
        <div class="col-sm-4">
            <input
                type="text"
                class="form-control"
                data-credit="<?php echo $score['credit']; ?>"
                value="<?php echo $score['score']; ?>">
        </div>
    </div>
    <?php endforeach; ?>
    <div class="form-group">
        <div class="col-sm-offset-4 col-sm-8">
            <button type="button" id="btn-calc" class="btn">
                <span class="glyphicon glyphicon-play"></span> 计算
            </button>
        </div>
    </div>
</div>

<hr>
<div class="result form-horizontal">
    <div class="form-group">
        <label class="col-sm-4 control-label">平均分：</label>
        <div class="col-sm-4">
            <p id="averageScore" class="form-control-static"></p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">总学分绩点：</label>
        <div class="col-sm-4">
            <p id="sumGPA" class="form-control-static"></p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">总学分：</label>
        <div class="col-sm-4">
            <p id="sumCredit" class="form-control-static"></p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">平均学分绩点：</label>
        <div class="col-sm-4">
            <p id="averageGPA" class="form-control-static"></p>
        </div>
    </div>
</div>

<script>
window.onload = function(){
    $('#btn-calc').click(function(){
        var sumCredit = 0;
        var sumGPA = 0;
        var sumScore = 0;
        var total = $('.scoreList input').length;

        $('.scoreList input').each(function(){
            var credit = parseFloat($(this).attr('data-credit'));
            var score = parseFloat($(this).val());

            sumCredit += credit;
            sumScore += score;
            sumGPA += GPA(score, credit);
        });

        $('#averageScore').text((sumScore / total).toFixed(2));
        $('#sumGPA').text(sumGPA);
        $('#sumCredit').text(sumCredit);
        $('#averageGPA').text((sumGPA / sumCredit).toFixed(2));
    });

    function GPA(score, credit) {
        if (score < 60)
            return 0;
        else
            return GP(score) * credit;
    }

    function GP(score) {
        if (score < 60)
            return 0;
        else
            return parseFloat((score / 10 - 5).toFixed(1));
    }
};
</script>
