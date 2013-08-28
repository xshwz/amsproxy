<?php
/**
 * SQL 查询结果表格
 */
class queryTable extends CWidget {
    /**
     * @var string
     */
    public $sql;

    public function run() {
        $results = Yii::app()->db->createCommand($_POST['sql'])->queryAll();

        echo '<div class="content table-responsive">';
        echo '<table class="table ellipsis queryTable table-striped">';
        echo '<thead>';
        echo '<tr>';
        foreach (array_keys($results[0]) as $th)
            echo "<th>{$th}</th>";
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        foreach ($results as $row) {
            echo '<tr>';
            foreach ($row as $td)
                echo '<td title="' . $td . '">' . CHtml::encode($td) . '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo "</table>";
        echo '</div>';
    }
}
