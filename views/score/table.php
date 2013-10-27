<?php foreach ($scoreTable['tbody'] as $termName => $termScore): ?>
<table class="score-table">
    <caption><?php echo $termName; ?></caption>
    <thead>
        <tr>
            <th>课程</th>
            <th>学分</th>
            <th>成绩</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($termScore as $score): ?>
        <tr>
            <td><?php echo $score[0]; ?></td>
            <td class="credit"><?php echo $score[1]; ?></td>
            <td class="score"><?php echo $score[6]; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php endforeach; ?>
