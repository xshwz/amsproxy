<div class="panel-group accordion">
    <?php
    $term_names = array_keys($score['tbody']);
    $last_term_name = $term_names[count($term_names) - 1];
    foreach ($score['tbody'] as $term_name => $term_score):
    ?>
    <div class="panel">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a
                    class="accordion-toggle
                        <?php if ($term_name != $last_term_name) echo 'collapsed'; ?>"
                    data-toggle="collapse"
                    data-parent=".panel-group"
                    href="#<?php echo $term_name; ?>">
                    <?php echo $term_name; ?>
                </a>
            </h4>
        </div>
        <div
            id="<?php echo $term_name; ?>"
            class="panel-collapse collapse
                <?php if ($term_name == $last_term_name) echo 'in'; ?>">
            <div class="panel-body table-responsive">
                <table class="table table-striped">
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
                        <tr
                            <?php if (!$row['state']) echo ' class="danger"'; ?>>
                            <?php
                            $row[0] = preg_replace('/\[.*?\]/', '', $row[0]);
                            foreach ($row as $key => $td) {
                                if (is_int($key))
                                    echo "<td>$td</td>";
                            }
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
