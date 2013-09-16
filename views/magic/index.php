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
            <button type="button" id="btn-calc" class="btn">计算平均学分绩点</button>
        </div>
    </div>
</div>
<script>
(function(){
    $('#btn-calc').click(function(){
        var sumCredit = 0;
        var sumGPA = 0;

        $('.scoreList input').each(function(){
            var credit = parseFloat($(this).attr('data-credit'));
            sumCredit += credit;
            sumGPA += GPA(parseFloat($(this).val()), credit);
        });

        alert((sumGPA / sumCredit).toFixed(2));
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
})();
</script>
