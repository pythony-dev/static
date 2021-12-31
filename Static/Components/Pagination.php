<?php

    namespace Static\Components;

    final class Pagination {

        static function create($page, $limit, $path) {
            $page = (int)$page;
            $limit = (int)$limit;
            $path = htmlspecialchars($path);

            if($page < 1 || $limit < 2 || $limit < $page) return null;

            $previous = $page - 1;
            $next = $page + 1;

            ob_start();
            ?>

            <nav class="p-5">
                <ul class="pagination">
                    <?php if($previous >= 2) { ?>
                        <li class="w-100 page-item">
                            <a class="page-link" href="<?= $path; ?>/1"> 1 </a>
                        </li>
                    <?php } ?>
                    <?php if($previous >= 3) { ?>
                        <li class="w-100 page-item disabled">
                            <a class="page-link"> ... </a>
                        </li>
                    <?php } ?>
                    <?php if($previous >= 1) { ?>
                        <li class="w-100 page-item">
                            <a class="page-link" href="<?= $path . "/" . $previous; ?>"> <?= $previous ?> </a>
                        </li>
                    <?php } ?>
                    <li class="w-100 page-item active">
                        <a class="page-link"> <?= $page; ?> </a>
                    </li>
                    <?php if($page <= $limit - 1) { ?>
                        <li class="w-100 page-item">
                            <a class="page-link" href="<?= $path . "/" . $next; ?>"> <?= $next; ?> </a>
                        </li>
                    <?php } ?>
                    <?php if($page <= $limit - 3) { ?>
                        <li class="w-100 page-item disabled">
                            <a class="page-link"> ... </a>
                        </li>
                    <?php } ?>
                    <?php if($page <= $limit - 2) { ?>
                        <li class="w-100 page-item">
                            <a class="page-link" href="<?= $path . "/" . $limit; ?>"> <?= $limit; ?> </a>
                        </li>
                    <?php } ?>
                </ul>
            </nav>

            <?php
            $component = ob_get_contents();
            ob_end_clean();

            return $component;
        }

    }

?>