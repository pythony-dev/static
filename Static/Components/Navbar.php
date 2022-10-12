<?php

    namespace Static\Components;

    final class Navbar {

        static function create() {
            $userID = (int)\Static\Kernel::getValue($_SESSION, "userID");

            ob_start();
            ?>

            <nav class="fixed-top p-4 navbar navbar-expand-lg navbar-light bg-light shadow border rounded-bottom">
                <a class="d-flex me-0 navbar-brand" href="<?= \Static\Kernel::getPath("/"); ?>">
                    <img class="icon" src="<?= \Static\Kernel::getPath("/Public/Images/Index/Icon.png"); ?>" alt="<?= \Static\Kernel::getSettings("project-name"); ?>"/>
                    <p class="h1 my-auto"> <?= \Static\Kernel::getSettings("project-name"); ?> </p>
                </a>
                <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbar-collapse">
                    <div class="navbar-toggler-icon"> </div>
                </button>
                <div id="navbar-collapse" class="navbar-collapse collapse">
                    <ul class="navbar-nav w-100">
                        <li class="w-100 pt-4 pt-md-0 nav-item">
                            <a class="nav-link<?= \Static\Kernel::getRoute() != "Home" ? null : " active"; ?>" href="<?= \Static\Kernel::getPath("/"); ?>"> <?= \Static\Languages\Translate::getText("title-home"); ?> </a>
                        </li>
                        <li class="w-100 nav-item">
                            <a class="nav-link<?= \Static\Kernel::getRoute() != "Features" ? null : " active"; ?>" href="<?= \Static\Kernel::getPath("/features"); ?>"> <?= \Static\Languages\Translate::getText("title-features"); ?> </a>
                        </li>
                        <li class="w-100 nav-item">
                            <a class="nav-link<?= !in_array(\Static\Kernel::getRoute(), array("News", "Article")) ? null : " active"; ?>" href="<?= \Static\Kernel::getPath("/news"); ?>"> <?= \Static\Languages\Translate::getText("title-news"); ?> </a>
                        </li>
                        <li class="w-100 nav-item">
                            <a class="nav-link<?= !in_array(\Static\Kernel::getRoute(), array("Forums", "Thread")) ? null : " active"; ?>" href="<?= \Static\Kernel::getPath("/forums"); ?>"> <?= \Static\Languages\Translate::getText("title-forums"); ?> </a>
                        </li>
                        <li class="w-100 nav-item">
                            <a class="nav-link<?= \Static\Kernel::getRoute() != "Contact" ? null : " active"; ?>" href="<?= \Static\Kernel::getPath("/contact"); ?>"> <?= \Static\Languages\Translate::getText("title-contact"); ?> </a>
                        </li>
                        <?php if($userID <= 0) { ?>
                            <li class="w-100 nav-item dropdown">
                                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown"> <?= \Static\Languages\Translate::getText("title-language"); ?> </a>
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
                                    <a class="w-50 btn btn-outline-primary" href="<?= \Static\Kernel::getPath("/sign-up"); ?>"> <?= \Static\Languages\Translate::getText("title-signUp"); ?> </a>
                                    <a class="w-50 btn btn-outline-primary" href="<?= \Static\Kernel::getPath("/log-in"); ?>"> <?= \Static\Languages\Translate::getText("title-logIn"); ?> </a>
                                </div>
                            </li>
                        <?php } else { ?>
                            <li class="w-200 my-auto pt-4 pt-md-0">
                                <div class="flex-column flex-lg-row input-group">
                                    <a class="w-50 btn btn-outline-primary" href="<?= \Static\Kernel::getPath("/messages"); ?>"> <?= \Static\Languages\Translate::getText("title-messages"); ?> </a>
                                    <div class="w-50">
                                        <button class="w-100 btn btn-outline-primary dropdown-toggle border-left-0" data-bs-toggle="dropdown"> <?= \Static\Languages\Translate::getText("title-settings"); ?> </button>
                                        <ul class="w-100 dropdown-menu text-center">
                                            <li>
                                                <a class="dropdown-item" href="<?= \Static\Kernel::getPath("/settings"); ?>"> <?= \Static\Languages\Translate::getText("title-settings-account"); ?> </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="<?= \Static\Kernel::getPath("/settings?notifications"); ?>"> <?= \Static\Languages\Translate::getText("title-settings-notifications"); ?> </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="<?= \Static\Kernel::getPath("/settings?others"); ?>"> <?= \Static\Languages\Translate::getText("title-settings-others"); ?> </a>
                                            </li>
                                            <li>
                                                <div class="dropdown-divider"> </div>
                                            </li>
                                            <li>
                                                <button id="navbar-logOut" class="dropdown-item"> <?= \Static\Languages\Translate::getText("title-settings-logOut"); ?> </button>
                                            </li>
                                        </ul>
                                    </div>
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