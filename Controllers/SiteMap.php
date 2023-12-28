<?php

    namespace Static\Controllers;

    final class SiteMap extends Main {

        public static function start($parameters) {
            $news = array();

            foreach(range(1, ceil(\Static\Models\Articles::count() / 5)) as $page) {
                $news["Page " . $page] = "/news/" . $page;

                foreach(\Static\Models\Articles::getArticles($page) as $article) $news["Page " . $page . " - Array"][\Static\Kernel::getValue($article, "title")] = \Static\Kernel::getValue($article, "link");
            }

            $forums = array();

            foreach(range(1, ceil(\Static\Models\Threads::count() / 10)) as $page) {
                $forums["Page " . $page] = "/forums/" . $page;

                foreach(\Static\Models\Threads::getThreads($page) as $thread) $forums["Page " . $page . " - Array"][\Static\Kernel::getValue($thread, "title")] = "/thread/" . \Static\Kernel::getValue($thread, "hash");
            }

            if($parameters["userID"] <= 0) $parameters["links"] = array(
                $parameters["getText"]("title-home") => "/",
                $parameters["getText"]("title-features") => "/features",
                $parameters["getText"]("title-news") => "/news",
                $parameters["getText"]("title-news") . " - Array" => $news,
                $parameters["getText"]("title-forums") => "/forums",
                $parameters["getText"]("title-forums") . " - Array" => $forums,
                $parameters["getText"]("title-contact") => "/contact",
                $parameters["getText"]("title-signUp") => "/sign-up",
                $parameters["getText"]("title-logIn") => "/log-in",
                $parameters["getText"]("title-terms") => "/terms",
                $parameters["getText"]("title-privacy") => "/privacy",
                $parameters["getText"]("title-siteMap") => "/site-map",
            );
            else {
                $chats = array();

                for($page = 1; true; $page ++) {
                    $messages = \Static\Kernel::getRequest(\Static\Models\Messages::getMessages($page));

                    if($messages["status"] != "success" || count($messages["messages"]) == 0) break;

                    foreach($messages["messages"] as $message) $chats[\Static\Kernel::getValue($message, "username")] = "/chat/" . \Static\Kernel::getValue($message, "hash");
                }

                $parameters["links"] = array(
                    $parameters["getText"]("title-home") => "/",
                    $parameters["getText"]("title-news") => "/news",
                    $parameters["getText"]("title-news") . " - Array" => $news,
                    $parameters["getText"]("title-forums") => "/forums",
                    $parameters["getText"]("title-forums") . " - Array" => $forums,
                    $parameters["getText"]("title-contact") => "/contact",
                    $parameters["getText"]("title-messages") => "/messages",
                    $parameters["getText"]("title-messages") . " - Array" => $chats,
                    $parameters["getText"]("title-settings") => "/settings",
                    $parameters["getText"]("title-settings") . " - Array" => array(
                        $parameters["getText"]("title-settings-account") => "/settings?account",
                        $parameters["getText"]("title-settings-notifications") => "/settings?notifications",
                        $parameters["getText"]("title-settings-others") => "/settings?others",
                    ),
                    $parameters["getText"]("title-terms") => "/terms",
                    $parameters["getText"]("title-privacy") => "/privacy",
                    $parameters["getText"]("title-siteMap") => "/site-map",
                );
            }

            return $parameters;
        }

    }

?>