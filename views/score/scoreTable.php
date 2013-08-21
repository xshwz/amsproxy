<div class="panel-group accordion">
    <?php foreach ($score['tbody'] as $term_name => $term_score): ?>
    <div class="panel">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a
                    class="accordion-toggle collapsed"
                    data-toggle="collapse"
                    data-parent=".panel-group"
                    href="#<?php echo $term_name; ?>">
                    <?php echo $term_name; ?>
                </a>
            </h4>
        </div>
        <div
            id="<?php echo $term_name; ?>"
            class="panel-collapse collapse">
            <div class="panel-body">
                <table class="table">
                    <thead>
                        <tr>
                            <?php
                            foreach ($score['thead'] as $th)
                                echo "<th>$th</th>";
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($term_score as $row): ?>
                        <tr>
                            <?php
                            $row[0] = preg_replace('/\[.*?\]/', '', $row[0]);
                            foreach ($row as $td)
                                echo "<td>$td</td>";
                            ?>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
