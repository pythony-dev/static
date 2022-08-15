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
                    <div class="row mx-0">
                        <div class="col-8 col-md-4 offset-2 offset-md-0 my-auto p-5">
                            <div class="bg-light shadow border rounded-circle">
                                <a href="<?= $getPath("/"); ?>">
                                    <img class="p-4 img-fluid" src="<?= $getPath("/Public/Images/Index/Icon.png"); ?>" alt="<?= $getSettings("project-name"); ?>"/>
                                </a>
                            </div>
                        </div>
                        <div class="col-12 col-md-8 my-auto p-5 pt-0 pt-md-5">
                            <p class="text-light"> Copyright © <?= date("Y") . " " . $getSettings("project-name") . " - " . $getText("footer-rights") . " - Version " . $getSettings("project-version"); ?> </p>
                            <div class="d-flex flex-column flex-md-row justify-content-around">
                                <a class="text-decoration-none link-light" href="<?= $getPath("/contact"); ?>"> <?= $getText("footer-contact"); ?> </a>
                                <a class="text-decoration-none link-light" href="<?= $getPath("/terms"); ?>"> <?= $getText("footer-terms"); ?> </a>
                                <a class="text-decoration-none link-light" href="<?= $getPath("/privacy"); ?>"> <?= $getText("footer-privacy"); ?> </a>
                            </div>
                            <div class="d-flex justify-content-around pt-4">
                                <?php foreach(\Static\Kernel::getNetworks() as $network) if($getSettings("networks-" . strtolower($network))) { ?>
                                    <a href="<?= $getSettings("networks-" . strtolower($network)); ?>" target="_blank">
                                        <img class="img-fluid shadow border border-dark rounded-circle networks" src="<?= $getPath("/Public/Images/Networks/" . $network . ".png"); ?>" alt="<?= $network; ?>"/>
                                    </a>
                                <?php } ?>
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