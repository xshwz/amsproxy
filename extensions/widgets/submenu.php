<?php
/**
 * 子菜单部件，controller active
 */
class submenu extends CWidget {
    /**
     * @var array 菜单
     */
    public $items = array();

    public function run() {
        echo '<div class="list-group">';

        foreach ($this->items as $item) {
            if ($this->getController()->getAction()->id == $item['action'][0])
                $class = 'list-group-item active';
            else
                $class = 'list-group-item';

            echo CHtml::link(
                $item['label'],
                array($this->getController()->id . '/' . $item['action'][0]),
                array('class' => $class));
        }

        echo "</div>";
    }
}
