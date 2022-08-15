<?php

    namespace Static\Components;

    final class Card {

        static function create($image, $title, $subtitle, $content) {
            $image = htmlspecialchars($image);
            $title = htmlspecialchars($title);
            $subtitle = htmlspecialchars($subtitle);
            $content = htmlspecialchars($content);

            ob_start();
            ?>

            <div class="card">
                <?php if(!empty($image)) { ?>
                    <img class="card-img-top" src="<?= $image; ?>" alt="<?= $title; ?>"/>
                <?php } ?>
                <div class="card-body">
                    <p class="px-4 pt-4 h3"> <?= $title; ?> </p>
                    <p class="px-4 pb-4 card-subtitle text-muted"> <?= $subtitle; ?> </p>
                    <p class="p-4 card-text text-justify"> <?= $content; ?> </p>
                </div>
            </div>

            <?php
            $component = ob_get_contents();
            ob_end_clean();

            return $component;
        }

    }

?>