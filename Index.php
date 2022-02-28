<?php

    require_once("Static/Requires/Kernel.php");

    Static\Kernel::addRoute("home", "/");
    Static\Kernel::addRoute("news", "/news");
    Static\Kernel::addRoute("news", "/news/(page)");
    Static\Kernel::addRoute("article", "/article/(link)");
    Static\Kernel::addRoute("contact", "/contact");
    Static\Kernel::addRoute("signUp", "/sign-up");
    Static\Kernel::addRoute("logIn", "/log-in");
    Static\Kernel::addRoute("settings", "/settings");
    Static\Kernel::addRoute("terms", "/terms");
    Static\Kernel::addRoute("privacy", "/privacy");

    Static\Kernel::addRequest("start", false);
    Static\Kernel::addRequest("language", false);
    Static\Kernel::addRequest("contact", true);
    Static\Kernel::addRequest("users", true);
    Static\Kernel::addRequest("images", true);

    Static\Kernel::start();

?>