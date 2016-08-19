<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-list"></i> ALBUM
    </a>
    <ul class="dropdown-menu">

        <?php
        $i = 1;
        foreach ($cates as $kk => $cate):
            if ($cate->cate_parent == 0) {
                if ($i != 1) {
                    echo "<li class='divider'></li>";
                }
                echo "<li>
                        <a href='" . url("chu-de/$cate->cate_title_slug/album") . "'>
                            <b>$cate->cate_title</b>
                        </a>
                    </li>";

                foreach ($cates as $sub_cate) {
                    if ($cate->id == $sub_cate->cate_parent) {
                        echo "<li>
                            <a href='" . url("chu-de/$sub_cate->cate_title_slug/album") . "'>$sub_cate->cate_title</a>
                        </li>";
                    }
                }
                $i++;
            }
        endforeach;
        ?>
    </ul>
</li>