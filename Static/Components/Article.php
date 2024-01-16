<?php

    namespace Static\Components;

    final class Article {

        static function create($id, $image, $title, $content, $button = null, $link = null) {
            $id = (int)$id;
            $image = htmlspecialchars($image);
            $title = htmlspecialchars($title);
            $content = htmlspecialchars($content);
            $button = htmlspecialchars($button);
            $link = htmlspecialchars($link);

            ob_start();
            ?>

            <div class="row mx-0<?= $id % 2 ? " flex-row-reverse" : null; ?>">
                <?php if($id != 0) { ?>
                    <div class="d-md-none p-5">
                        <div class="line"> </div>
                    </div>
                <?php } ?>
                <div class="col-12 col-md-6 my-auto p-5 p<?= $id %2 ? "s" : "e"; ?>-md-0">
                    <img class="img-fluid article<?= !str_contains($image, ".PNG") && !str_contains($image, ".png") ? " shadow border rounded" : null; ?>" src="<?= $image; ?>" alt="<?= $title; ?>"/>
                </div>
                <div class="col-12 col-md-6 my-auto px-0">
                    <h3 class="px-5 pt-5 pb-4"> <?= $title; ?> </h3>
                    <p class="px-5 <?= !empty($button) && !empty($link) ? "py-4" : "pb-5 pt-4"; ?> text-justify"> <?= $content; ?> </p>
                    <?php if(!empty($button) && !empty($link)) { ?>
                        <div class="px-5 pb-5 pt-4">
                            <a class="w-100 btn rounded-pill button-outline" href="<?= $link; ?>"> <?= $button; ?> </a>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <?php
            $component = ob_get_contents();
            ob_end_clean();

            return $component;
        }

    }

?>