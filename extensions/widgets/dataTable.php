<?php
/**
 * collapse表格部件
 */
class dataTable extends CWidget {
    /**
     * @var array 显示的表格数组
     */
    public $data = array();

    protected $thead = array();
    protected $tbody = array();

    /**
     * @var int 对该列去除[]标签的内容
     */
    public $cutSquareBracketNum;

    /**
     * 显示的类型
     * @var int 0: Collapses 1: A table without title
     */
    public $type = 0;

    public function run() {
        $this->thead = $this->data['thead'];
        $this->tbody = $this->data['tbody'];

        switch ( $this->type ) {
            case 0 : $this->echoPanel(); break;
            case 1 : $this->echoTable(); break;
            default: break;
        }
    }

    protected function echoTable() {
        echo '<div class="content table-responsive">';
        $this->openTable();
        $this->echoThead();
        echo '<tbody>';
        foreach ( $this->tbody as $tbody ) {
            $this->echoTrs($tbody);
        }
        echo '</tbody>';
        $this->closeTable();
        echo '</div>';

    }

    protected function echoPanel() {
        echo '<div class="panel-group accordion">';
        $tbodys = array_keys($this->tbody);
        $last_collapse_name = $tbodys[count($tbodys) - 1];
        foreach ($this->tbody as $title => $tbody) {

            $this->openPanel(
                $title,
                $last_collapse_name == $title
            );

            $this->openTable();
            $this->echoThead();
            $this->echoTbody($tbody);
            $this->closeTable();

            $this->closePanel();
        }
        echo '</div>';
    }

    protected function openPanel($title, $is_last) {
        echo '<div class="panel">';
        // title
        echo '<div class="panel-heading">';
        echo '<h4 class="panel-title">';
        echo CHtml::link($title, "#{$title}", array(
            'class' => 'accordion-toggle '
                . (!$is_last ? 'collapse' : ''),
            'data-toggle' => 'collapse',
            'data-parent' => '.panel-group',
        ));
        echo '</h4>';
        echo '</div>';
        // endtitle

        // body
        echo CHtml::openTag('div', array(
            'id' => $title,
            'class' => 'panel-collapse collapse '
                . ($is_last ? 'in' : ''),
        ));
        echo '<div class="panel-body table-responsive">';
    }

    protected function closePanel() {
        echo '</div>';
        echo '</div>';
        // endbody

        echo '</div>';
    }

    protected function openTable() {
        echo '<table class="table table-striped table-hover">';
    }

    protected function closeTable() {
        echo '</table>';
    }

    protected function echoThead() {
        echo '<thead>';
        echo '<tr>';
        foreach ($this->thead as $th)
            echo "<th>{$th}</th>";
        echo '</tr>';
        echo '</thead>';
    }

    protected function echoTbody($tbody) {
        echo '<tbody>';
        $this->echoTrs($tbody);
        echo '</tbody>';
    }

    protected function echoTrs($trs) {
        foreach ($trs as $row) {
            echo CHtml::openTag('tr', 
                isset($row['state']) && $row['state'] == false ?
                array('class' => 'danger') : array()
            );

            $n = &$this->cutSquareBracketNum;
            if ( $n !== null)
                $row[$n] = $this->cutSquareBrackets($row[$n]);
            foreach ($row as $key => $td) {
                if (is_int($key))
                    echo "<td>$td</td>";
            }
            echo CHtml::closeTag('tr');
        }
    }

    protected function cutSquareBrackets($str) {
        return preg_replace('/\[.*?\]/', '', $str);
    }
}
