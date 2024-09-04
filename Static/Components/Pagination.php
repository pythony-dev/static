<?php

    namespace Static\Components;

    final class Pagination {

        static function create($page, $limit, $path) {
            $page = (int)$page;
            $limit = (int)$limit;
            $path = strval($path);

            if($limit < 2) return null;

            $previous = $page - 1;
            $next = $page + 1;

            $id = end(explode("/", $path));

            ob_start();
            ?>

            <div class="p-5">
                <ul class="pagination mb-0">
                    <?php if($page >= 3) { ?>
                        <li class="w-100 page-item">
                            <a id="<?= $id; ?>-start" class="page-link" href="<?= $path; ?>/1"> 1 </a>
                        </li>
                    <?php } if($page >= 4) { ?>
                        <li class="w-100 page-item disabled">
                            <a class="page-link" href="#"> … </a>
                        </li>
                    <?php } if($page >= 2) { ?>
                        <li class="w-100 page-item">
                            <a id="<?= $id; ?>-previous" class="page-link" href="<?= $path . "/" . $previous; ?>"> <?= $previous; ?> </a>
                        </li>
                    <?php } ?>
                    <li class="w-100 page-item active">
                        <div class="page-link"> <?= $page; ?> </div>
                    </li>
                    <?php if($page <= $limit - 1) { ?>
                        <li class="w-100 page-item">
                            <a id="<?= $id; ?>-next" class="page-link" href="<?= $path . "/" . $next; ?>"> <?= $next; ?> </a>
                        </li>
                    <?php } if($page <= $limit - 3) { ?>
                        <li class="w-100 page-item disabled">
                            <a class="page-link" href="#"> … </a>
                        </li>
                    <?php } if($page <= $limit - 2) { ?>
                        <li class="w-100 page-item">
                            <a id="<?= $id; ?>-end" class="page-link" href="<?= $path . "/" . $limit; ?>"> <?= $limit; ?> </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>

            <?php
            $component = ob_get_contents();
            ob_end_clean();

            return $component;
        }

    }

?>