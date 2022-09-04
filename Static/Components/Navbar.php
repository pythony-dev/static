<?php

    namespace Static\Components;

    final class Navbar {

        static function create() {
            $userID = (int)\Static\Kernel::getValue($_SESSION, "userID");

            $getText = \Static\Kernel::getParameters()["getText"];
            $getSettings = \Static\Kernel::getParameters()["getSettings"];
            $getPath = \Static\Kernel::getParameters()["getPath"];

            ob_start();
            ?>

            <nav class="fixed-top p-4 navbar navbar-expand-lg navbar-light bg-light shadow border rounded-bottom">
                <a class="d-flex me-0 navbar-brand" href="<?= $getPath("/"); ?>">
                    <img class="icon" src="<?= $getPath("/Public/Images/Index/Icon.png"); ?>" alt="<?= $getSettings("project-name"); ?>"/>
                    <p class="h1 my-auto"> <?= $getSettings("project-name"); ?> </p>
                </a>
                <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbar-collapse">
                    <div class="navbar-toggler-icon"> </div>
                </button>
                <div id="navbar-collapse" class="navbar-collapse collapse">
                    <ul class="navbar-nav w-100">
                        <li class="w-100 pt-4 pt-md-0 nav-item">
                            <a class="nav-link<?= \Static\Kernel::getRoute() != "Home" ? null : " active"; ?>" href="<?= $getPath("/"); ?>"> <?= $getText("title-home"); ?> </a>
                        </li>
                        <li class="w-100 nav-item">
                            <a class="nav-link<?= \Static\Kernel::getRoute() != "Features" ? null : " active"; ?>" href="<?= $getPath("/features"); ?>"> <?= $getText("title-features"); ?> </a>
                        </li>
                        <li class="w-100 nav-item">
                            <a class="nav-link<?= !in_array(\Static\Kernel::getRoute(), array("News", "Article")) ? null : " active"; ?>" href="<?= $getPath("/news"); ?>"> <?= $getText("title-news"); ?> </a>
                        </li>
                        <li class="w-100 nav-item">
                            <a class="nav-link<?= !in_array(\Static\Kernel::getRoute(), array("Forums", "Thread")) ? null : " active"; ?>" href="<?= $getPath("/forums"); ?>"> <?= $getText("title-forums"); ?> </a>
                        </li>
                        <li class="w-100 nav-item">
                            <a class="nav-link<?= \Static\Kernel::getRoute() != "Contact" ? null : " active"; ?>" href="<?= $getPath("/contact"); ?>"> <?= $getText("title-contact"); ?> </a>
                        </li>
                        <?php if($userID < 1) { ?>
                            <li class="w-100 nav-item dropdown">
                                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown"> <?= $getText("title-language"); ?> </a>
                                <ul class="w-100 dropdown-menu text-center">
                                    <?php foreach(\Static\Languages\Translate::getAllLanguages() as $language) { ?>
                                        <li>
                                            <a class="dropdown-item language<?= \Static\Languages\Translate::getLanguage() != $language ? null : " active"; ?>" language="<?= $language; ?>"> <?= ucfirst($language); ?> </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <li class="w-200 my-auto pt-4 pt-md-0">
                                <div class="flex-column flex-lg-row input-group">
                                    <a class="w-50 btn btn-outline-primary" href="<?= $getPath("/sign-up"); ?>"> <?= $getText("title-signUp"); ?> </a>
                                    <a class="w-50 btn btn-outline-primary" href="<?= $getPath("/log-in"); ?>"> <?= $getText("title-logIn"); ?> </a>
                                </div>
                            </li>
                        <?php } else { ?>
                            <li class="w-100 my-auto pt-4 pt-md-0 dropdown">
                                <button class="w-100 btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown"> <?= $getText("title-settings"); ?> </button>
                                <ul class="w-100 dropdown-menu text-center">
                                    <li>
                                        <a class="dropdown-item" href="<?= $getPath("/settings"); ?>"> <?= $getText("title-settings-account"); ?> </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="<?= $getPath("/settings?notifications"); ?>"> <?= $getText("title-settings-notifications"); ?> </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="<?= $getPath("/settings?others"); ?>"> <?= $getText("title-settings-others"); ?> </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"> </div>
                                    </li>
                                    <li>
                                        <button id="navbar-logOut" class="dropdown-item"> <?= $getText("title-settings-logOut"); ?> </button>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </nav>

            <?php
            $component = ob_get_contents();
            ob_end_clean();

            return $component;
        }

    }

?>