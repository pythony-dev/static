<?php

    session_start();

    require_once("Static/Requires/Kernel.php");

    Static\Kernel::addRoute("home", "/");
    Static\Kernel::addRoute("features", "/features");
    Static\Kernel::addRoute("news", "/news/(page)");
    Static\Kernel::addRoute("article", "/article/(link)");
    Static\Kernel::addRoute("contact", "/contact");
    Static\Kernel::addRoute("signUp", "/sign-up");
    Static\Kernel::addRoute("logIn", "/log-in");
    Static\Kernel::addRoute("settings", "/settings");
    Static\Kernel::addRoute("terms", "/terms");
    Static\Kernel::addRoute("privacy", "/privacy");

    Static\Kernel::addRequest("contact");
    Static\Kernel::addRequest("users");
    Static\Kernel::addRequest("images");

    Static\Kernel::start();

?>