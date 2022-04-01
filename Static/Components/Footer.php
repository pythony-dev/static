<?php

    namespace Static\Components;

    final class Footer {

        static function create() {
            $getText = \Static\Kernel::getParameters()["getText"];
            $getSettings = \Static\Kernel::getParameters()["getSettings"];
            $getPath = \Static\Kernel::getParameters()["getPath"];

            ob_start();
            ?>

            <footer class="bg-dark shadow border border-dark">
                <article class="col-12 col-md-10 col-xl-8 offset-md-1 offset-xl-2">
                    <div class="row m-0">
                        <div class="col-8 col-md-4 offset-2 offset-md-0 d-flex p-5 pb-2 pb-md-5">
                            <div class="m-auto bg-light shadow border border-dark rounded-circle">
                                <img class="img-fluid p-4" src="<?= $getPath("/Public/Images/Index/Icon.png"); ?>" alt="<?= $getSettings("project-name"); ?>"/>
                            </div>
                        </div>
                        <div class="col-12 col-md-8 p-5 pt-2 pt-md-5">
                            <div class="d-flex flex-column justify-content-center h-100">
                                <p class="pt-4 text-center text-light"> Copyright © <?= date("Y") . " " . $getSettings("project-name") . " - " . $getText("footer-rights") . " - " . $getSettings("project-version"); ?> </p>
                                <div class="d-flex flex-column flex-md-row justify-content-between pb-4">
                                    <a class="text-decoration-none link-light" href="<?= $getPath("/contact"); ?>"> <?= $getText("footer-contact"); ?> </a>
                                    <a class="text-decoration-none link-light" href="<?= $getPath("/terms"); ?>"> <?= $getText("footer-terms"); ?> </a>
                                    <a class="text-decoration-none link-light" href="<?= $getPath("/privacy"); ?>"> <?= $getText("footer-privacy"); ?> </a>
                                </div>
                                <div class="d-flex justify-content-between py-4">
                                    <?php foreach(array("Facebook", "YouTube", "Instagram", "TikTok", "Twitter") as $network) { ?>
                                        <a href="<?= $getSettings("networks-" . strtolower($network)); ?>" target="_blank">
                                            <img class="img-fluid shadow border border-dark rounded-circle networks" src="<?= $getPath("/Public/Images/Networks/" . $network . ".png"); ?>" alt="<?= $network; ?>"/>
                                        </a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            </footer>

            <?php
            $component = ob_get_contents();
            ob_end_clean();

            return $component;
        }

    }

?>