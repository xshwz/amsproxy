<?php
/**
 * 菜单部件，controller active
 */
class menu extends CWidget {
    /**
     * @var array 菜单
     */
    public $items = array();

    public function run() {
        echo '<ul class="nav navbar-nav">';

        foreach ($this->items as $item) {
            $url = explode('/', $item['url']);
            if ($this->getController()->id == $url[0])
                $class = ' class="active"';
            else
                $class = '';

            $link = Yii::app()->createUrl($item['url']);
            echo "<li{$class}>";
            echo "<a href='{$link}'>";
            echo $item['label'];
            if (isset($item['badge']) && $item['badge'] > 0)
                echo "<span class='badge'>{$item['badge']}</span>";
            echo '</a>';
            echo '</li>';
        }

        echo "</ul>";
    }
}
