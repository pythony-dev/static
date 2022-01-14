<?php

    session_start();

    require_once("Static/Requires/Kernel.php");

    Static\Models\Database::setEnvironment("production");
    Static\Models\Database::connect();

    Static\Kernel::setSalt("0123456789ABCDEF");
    Static\Kernel::setLink("https://www.website.com");
    Static\Kernel::addStyle("https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css");
    Static\Kernel::addStyle("/Public/Styles/Index.css");
    Static\Kernel::addScript("https://code.jquery.com/jquery-3.5.0.min.js");
    Static\Kernel::addScript("https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js");
    Static\Kernel::addScript("/Public/Scripts/Index.js");

    Static\Kernel::addRoute("error", "/error");
    Static\Kernel::addRoute("home", "/");
    Static\Kernel::addRoute("news", "/news");
    Static\Kernel::addRoute("news", "/news/(page)");
    Static\Kernel::addRoute("article", "/article/(link)");
    Static\Kernel::addRoute("contact", "/contact");
    Static\Kernel::addRoute("signUp", "/sign-up");
    Static\Kernel::addRoute("logIn", "/log-in");
    Static\Kernel::addRoute("settings", "/settings");

    Static\Kernel::addRequest("start");
    Static\Kernel::addRequest("language");
    Static\Kernel::addRequest("contact");
    Static\Kernel::addRequest("users");
    Static\Kernel::addRequest("images");

    Static\Languages\Translate::setLanguage();
    Static\Kernel::start();

?>