<li class="dropdown dropdown-large">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-list"></i> ALBUM</a>
    <ul class="dropdown-menu dropdown-menu-large row">

        <?php foreach ($cates as $kk => $cate): ?>
        <?php
            if ($cate->cate_parent == 0) {
                echo '<li class="col-sm-6">';
                echo '<ul>';
                echo "<li class='dropdown-header'>$cate->cate_title</li>";
                echo "<li class='divider'></li>";
                foreach ($cates as $sub_cate) {
                    if ($cate->id == $sub_cate->cate_parent) {
                        echo "<li><a href='" . url("chu-de/$sub_cate->cate_title_slug/album") . "'>$sub_cate->cate_title</a></li>";
                    }
                }
                echo '</ul>';
                echo '</li>';
            }
            ?>

        <?php
//        $cates->splice($kk);
        endforeach
        ?>
    </ul>
</li>