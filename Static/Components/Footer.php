<?php

    namespace Static\Components;

    final class Footer {

        static function create() {
            $getText = \Static\Kernel::getParameters()["getText"];
            $getSettings = \Static\Kernel::getParameters()["getSettings"];
            $getPath = \Static\Kernel::getParameters()["getPath"];

            ob_start();
            ?>

            <footer class="bg-dark shadow border border-dark rounded-bottom">
                <article class="col-12 col-md-10 col-xl-8 offset-md-1 offset-xl-2">
                    <div class="row mx-0 px-5">
                        <div class="col-8 col-md-4 offset-2 offset-md-0 my-auto p-5 pb-3 pb-md-5">
                            <div class="bg-light shadow border border-dark rounded-circle">
                                <a href="<?= $getPath("/"); ?>">
                                    <img class="img-fluid p-4" src="<?= $getPath("/Public/Images/Index/Icon.png"); ?>" alt="<?= $getSettings("project-name"); ?>"/>
                                </a>
                            </div>
                        </div>
                        <div class="col-12 col-md-8 my-auto py-5 pt-3 pt-md-5">
                            <div class="d-flex flex-column">
                                <p class="pt-4 text-center text-light"> Copyright © <?= date("Y") . " " . $getSettings("project-name") . " - " . $getText("footer-rights") . " - Version " . $getSettings("project-version"); ?> </p>
                                <div class="d-flex flex-column flex-md-row justify-content-between pb-4">
                                    <a class="text-decoration-none link-light" href="<?= $getPath("/contact"); ?>"> <?= $getText("footer-contact"); ?> </a>
                                    <a class="text-decoration-none link-light" href="<?= $getPath("/terms"); ?>"> <?= $getText("footer-terms"); ?> </a>
                                    <a class="text-decoration-none link-light" href="<?= $getPath("/privacy"); ?>"> <?= $getText("footer-privacy"); ?> </a>
                                </div>
                                <div class="d-flex justify-content-around py-4">
                                    <?php foreach(array("Facebook", "YouTube", "Instagram", "TikTok", "Twitter") as $network) { ?>
                                        <?php if($getSettings("networks-" . strtolower($network))) { ?>
                                            <a href="<?= $getSettings("networks-" . strtolower($network)); ?>" target="_blank">
                                                <img class="img-fluid shadow border border-dark rounded-circle networks" src="<?= $getPath("/Public/Images/Networks/" . $network . ".png"); ?>" alt="<?= $network; ?>"/>
                                            </a>
                                        <?php } ?>
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