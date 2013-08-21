<?php
class menu extends CWidget {
    public $items = array();

    public function run() {
        echo '<ul class="nav navbar-nav">';

        foreach ($this->items as $item) {
            if ($this->getController()->id == explode('/', $item['url'][0])[0])
                $class = ' class="active"';
            else
                $class = '';

            echo "<li{$class}>";
            echo CHtml::link($item['label'], array($item['url'][0]));
            echo '</li>';
        }

        echo "</ul>";
    }
}
