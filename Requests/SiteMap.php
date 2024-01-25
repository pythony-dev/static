<?php

    namespace Static\Requests;

    final class SiteMap {

        public static function fetch() {
            $link = \Static\Kernel::getSettings("settings-link");
            $links = array(
                $link . "/error/404?error=false",
                $link . "/",
                $link . "/features",
                $link . "/news",
            );

            foreach(range(1, ceil(\Static\Models\Articles::count() / 5)) as $page) {
                array_push($links, $link . "/news/" . $page);

                foreach(\Static\Models\Articles::getArticles($page) as $article) array_push($links, \Static\Kernel::getValue($article, "link"));
            }

            array_push($links, $link . "/forums");

            foreach(range(1, ceil(\Static\Models\Threads::count() / 10)) as $page) {
                array_push($links, $link . "/forums/" . $page);

                foreach(\Static\Models\Threads::getThreads($page) as $thread) array_push($links, $link . "/thread/" . \Static\Kernel::getValue($thread, "hash"));
            }

            array_push($links, ...array(
                $link . "/contact",
                $link . "/sign-up",
                $link . "/log-in",
                $link . "/terms",
                $link . "/privacy",
                $link . "/site-map",

                $link . "/Public/Images/Features/" . \Static\Kernel::getHash("Feature", 0) . ".jpeg",
                $link . "/Public/Images/Articles/" . \Static\Kernel::getHash("Article", 0) . ".jpeg",
                $link . "/Public/Images/Users/" . \Static\Kernel::getHash("User", 0) . ".jpeg",
                $link . "/Public/Images/Posts/" . \Static\Kernel::getHash("Post", 0) . ".jpeg",
                $link . "/Public/Images/Messages/" . \Static\Kernel::getHash("Message", 0) . ".jpeg",

                $link . "/Public/Images/Icons/Light/Report.png",
                $link . "/Public/Images/Icons/Light/Delete.png",
                $link . "/Public/Images/Icons/Light/Chat.png",
                $link . "/Public/Images/Icons/Light/Block.png",
                $link . "/Public/Images/Icons/Light/Unblock.png",
                $link . "/Public/Images/Icons/Dark/Report.png",
                $link . "/Public/Images/Icons/Dark/Delete.png",
                $link . "/Public/Images/Icons/Dark/Chat.png",
                $link . "/Public/Images/Icons/Dark/Block.png",
                $link . "/Public/Images/Icons/Dark/Unblock.png",
            ));

            return array(
                "status" => "success",
                "name" => \Static\Kernel::getSettings("project-name"),
                "link" => $link,
                "links" => $links,
            );
        }

    }

?>