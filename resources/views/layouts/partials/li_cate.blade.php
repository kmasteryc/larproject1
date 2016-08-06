@inject('menu','Tools\Menu')
<?php
$nav_type = isset($nav_type) ? $nav_type : 'nav2';
echo $menu->make($cates,$nav_type);
