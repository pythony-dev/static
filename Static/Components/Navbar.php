<?php

    namespace Static\Components;

    final class Navbar {

        static function create() {
            $getText = \Static\Kernel::getParameters()["getText"];
            $getPath = \Static\Kernel::getParameters()["getPath"];

            ob_start();
            ?>

            <nav class="fixed-top px-5 navbar navbar-expand-md navbar-light bg-light shadow border rounded-bottom">
                <a class="d-flex me-0 navbar-brand" href="<?= $getPath("/"); ?>">
                    <img class="pe-4 icon" src="<?= $getPath("/Public/Images/Index/Icon.png"); ?>" alt="<?= $getText("project-name"); ?>"/>
                    <p class="h1 my-auto ps-4"> <?= $getText("project-name"); ?> </p>
                </a>
                <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbar-collapse">
                    <span class="navbar-toggler-icon"> </span>
                </button>
                <div id="navbar-collapse" class="py-4 navbar-collapse collapse">
                    <ul class="navbar-nav w-100">
                        <li class="w-100 nav-item">
                            <a class="nav-link<?= \Static\Kernel::getRoute() != "Home" ? "" : " active"; ?>" href="<?= $getPath("/"); ?>"> <?= $getText("navbar-home"); ?> </a>
                        </li>
                        <li class="w-100 nav-item">
                            <a class="nav-link<?= !in_array(\Static\Kernel::getRoute(), array("News", "Article")) ? "" : " active"; ?>" href="<?= $getPath("/news"); ?>"> <?= $getText("navbar-news"); ?> </a>
                        </li>
                        <li class="w-100 nav-item">
                            <a class="nav-link<?= \Static\Kernel::getRoute() != "Contact" ? "" : " active"; ?>" href="<?= $getPath("/contact"); ?>"> <?= $getText("navbar-contact"); ?> </a>
                        </li>
                        <li class="w-100 nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href data-bs-toggle="dropdown"> <?= $getText("navbar-language"); ?> </a>
                            <ul class="w-100 dropdown-menu">
                                <?php foreach(\Static\Languages\Translate::getAllLanguages() as $language) { ?>
                                    <li>
                                        <a class="dropdown-item<?= \Static\Languages\Translate::getLanguage() != $language ? "" : " active"; ?> text-center language" href language="<?= $language; ?>"> <?= ucfirst($language); ?> </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>
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