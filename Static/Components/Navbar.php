<?php

    namespace Static\Components;

    final class Navbar {

        static function create($userID) {
            $userID = (int)$userID;

            $getText = \Static\Kernel::getParameters()["getText"];
            $getSettings = \Static\Kernel::getParameters()["getSettings"];
            $getPath = \Static\Kernel::getParameters()["getPath"];

            ob_start();
            ?>

            <nav class="fixed-top px-5 navbar navbar-expand-md navbar-light bg-light shadow border rounded-bottom">
                <a class="d-flex me-0 navbar-brand" href="<?= $getPath("/"); ?>">
                    <img class="pe-3 icon" src="<?= $getPath("/Public/Images/Index/Icon.png"); ?>" alt="<?= $getSettings("project-name"); ?>"/>
                    <p class="h1 my-auto ps-3"> <?= $getSettings("project-name"); ?> </p>
                </a>
                <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbar-collapse">
                    <span class="navbar-toggler-icon"> </span>
                </button>
                <div id="navbar-collapse" class="navbar-collapse collapse">
                    <ul class="navbar-nav w-100">
                        <li class="w-100 my-auto nav-item">
                            <a class="nav-link<?= \Static\Kernel::getRoute() != "Home" ? null : " active"; ?>" href="<?= $getPath("/"); ?>"> <?= $getText("title-home"); ?> </a>
                        </li>
                        <li class="w-100 my-auto nav-item">
                            <a class="nav-link<?= \Static\Kernel::getRoute() != "Features" ? null : " active"; ?>" href="<?= $getPath("/features"); ?>"> <?= $getText("title-features"); ?> </a>
                        </li>
                        <li class="w-100 my-auto nav-item">
                            <a class="nav-link<?= !in_array(\Static\Kernel::getRoute(), array("News", "Article")) ? null : " active"; ?>" href="<?= $getPath("/news"); ?>"> <?= $getText("title-news"); ?> </a>
                        </li>
                        <li class="w-100 my-auto nav-item">
                            <a class="nav-link<?= \Static\Kernel::getRoute() != "Contact" ? null : " active"; ?>" href="<?= $getPath("/contact"); ?>"> <?= $getText("title-contact"); ?> </a>
                        </li>
                        <li class="w-100 my-auto nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown"> <?= $getText("title-language"); ?> </a>
                            <ul class="w-100 dropdown-menu">
                                <?php foreach(\Static\Languages\Translate::getAllLanguages() as $language) { ?>
                                    <li>
                                        <a class="dropdown-item text-center language<?= \Static\Languages\Translate::getLanguage() != $language ? null : " active"; ?>" language="<?= $language; ?>"> <?= ucfirst($language); ?> </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>
                        <?php if($userID < 1) { ?>
                            <li class="w-200 nav-item">
                                <div class="flex-column flex-md-row my-4 input-group">
                                    <a class="w-50 btn btn-outline<?= \Static\Kernel::getRoute() != "SignUp" ? "-primary" : "-dark"; ?>" href="<?= $getPath("/sign-up"); ?>"> <?= $getText("title-signUp"); ?> </a>
                                    <a class="w-50 btn btn-outline<?= \Static\Kernel::getRoute() != "LogIn" ? "-primary" : "-dark"; ?>" href="<?= $getPath("/log-in"); ?>"> <?= $getText("title-logIn"); ?> </a>
                                </div>
                            </li>
                        <?php } else { ?>
                            <li class="w-200 nav-item">
                                <div class="flex-column flex-md-row my-4 input-group">
                                    <a class="w-50 btn btn-outline<?= \Static\Kernel::getRoute() != "Settings" ? "-primary" : "-dark"; ?>" href="<?= $getPath("/settings"); ?>"> <?= $getText("title-settings"); ?> </a>
                                    <a id="logOut" class="w-50 btn btn-outline-dark"> <?= $getText("title-logOut"); ?> </a>
                                </div>
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