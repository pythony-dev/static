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
                <article class="col-12 col-md-10 col-xl-8 offset-md-1 offset-xl-2 py-5">
                    <div class="row">
                        <div class="col-12 col-md-4 d-flex p-5">
                            <div class="m-auto bg-light shadow border border-dark rounded-circle">
                                <img class="img-fluid p-4" src="<?= $getPath("/Public/Images/Index/Icon.png"); ?>" alt="<?= $getSettings("name"); ?>"/>
                            </div>
                        </div>
                        <div class="col-12 col-md-8">
                            <div class="d-flex flex-column justify-content-center h-100">
                                <p class="pt-4 text-center text-light"> Copyright © 2022 <?= $getSettings("name") . " - " . $getText("footer") . " - " . $getSettings("version"); ?> </p>
                                <div>
                                    <a class="p-4 text-decoration-none link-light" href=""> Terms and Conditions </a>
                                    <a class="p-4 text-decoration-none link-light" href=""> Privacy Policy </a>
                                    <a class="p-4 text-decoration-none link-light" href="<?= $getPath("/contact"); ?>"> Contact </a>
                                </div>
                                <div class="d-flex p-4">
                                    <a class="p-4" href="<?= $getSettings("facebook"); ?>" target="_blank">
                                        <img class="img-fluid shadow border border-dark rounded-circle" src="<?= $getPath("/Public/Images/Networks/Facebook.png"); ?>" alt="Facebook"/>
                                    </a>
                                    <a class="p-4" href="<?= $getSettings("youtube"); ?>" target="_blank">
                                        <img class="img-fluid shadow border border-dark rounded-circle" src="<?= $getPath("/Public/Images/Networks/YouTube.png"); ?>" alt="YouTube"/>
                                    </a>
                                    <a class="p-4" href="<?= $getSettings("instagram"); ?>" target="_blank">
                                        <img class="img-fluid shadow border border-dark rounded-circle" src="<?= $getPath("/Public/Images/Networks/Instagram.png"); ?>" alt="Instagram"/>
                                    </a>
                                    <a class="p-4" href="<?= $getSettings("tiktok"); ?>" target="_blank">
                                        <img class="img-fluid shadow border border-dark rounded-circle" src="<?= $getPath("/Public/Images/Networks/TikTok.png"); ?>" alt="TikTok"/>
                                    </a>
                                    <a class="p-4" href="<?= $getSettings("twitter"); ?>" target="_blank">
                                        <img class="img-fluid shadow border border-dark rounded-circle" src="<?= $getPath("/Public/Images/Networks/Twitter.png"); ?>" alt="Twitter"/>
                                    </a>
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