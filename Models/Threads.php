<?php

    namespace Static\Models;

    use PDO;

    final class Threads extends Database {

        public static function getThreads($page) {
            $page = (int)$page;

            if($page <= 0) return array();

            $query = parent::$pdo->prepare("
                SELECT
                    id,
                    title,
                    (SELECT userID FROM " . parent::getPrefix() . "Posts WHERE threadID = Threads.id LIMIT 1) AS userID,
                    (SELECT username FROM " . parent::getPrefix() . "Users WHERE id = userID) AS author,
                    (SELECT MAX(created) FROM " . parent::getPrefix() . "Posts WHERE threadID = Threads.id) AS updated,
                    (
                        SELECT COUNT(Posts.id)
                        FROM " . parent::getPrefix() . "Posts AS Posts
                        INNER JOIN " . parent::getPrefix() . "Users AS Users
                        ON Users.id = Posts.userID
                        WHERE
                            Posts.deleted IS NULL
                            AND
                            Posts.threadID = Threads.id
                            AND
                            Users.deleted IS NULL
                    ) AS count
                FROM " . parent::getPrefix() . "Threads AS Threads
                WHERE
                    deleted IS NULL
                    AND
                    LOCATE (language, :languages)
                    AND
                    (
                        SELECT COUNT(Posts.id)
                        FROM " . parent::getPrefix() . "Posts AS Posts
                        INNER JOIN " . parent::getPrefix() . "Users AS Users
                        ON Users.id = Posts.userID
                        WHERE
                            Posts.deleted IS NULL
                            AND
                            Posts.threadID = Threads.id
                            AND
                            Users.deleted IS NULL
                    ) >= 1
                ORDER BY updated DESC, id DESC
                LIMIT :page, 10
            ");
            $query->bindValue(":languages", \Static\Languages\Translate::getUserLanguage(), PDO::PARAM_STR);
            $query->bindValue(":page", $page * 10 - 10, PDO::PARAM_INT);
            $query->execute();

            $results = array();

            while($thread = $query->fetch()) {
                $today = date_format(date_create(), substr(\Static\Kernel::getDateFormat(), 0, 5));
                $date = date_format(date_create($thread["updated"]), substr(\Static\Kernel::getDateFormat(), 0, 5));
                $time = date_format(date_create($thread["updated"]), substr(\Static\Kernel::getDateFormat(), 5));

                array_push($results, array(
                    "hash" => \Static\Kernel::getHash("Thread", (int)\Static\Kernel::getValue($thread, "id")),
                    "image" => \Static\Kernel::getPath("/Public/Images/Users/" . \Static\Kernel::getHash("User", \Static\Kernel::getValue($thread, "userID")) . ".jpeg?" . time()),
                    "author" => \Static\Kernel::getValue($thread, "author"),
                    "updated" => $today != $date ? $date : $time,
                    "count" => \Static\Kernel::getValue($thread, "count"),
                    "userID" => \Static\Kernel::getValue($thread, "userID"),
                    "title" => \Static\Kernel::getValue($thread, "title"),
                ));
            }

            return $results;
        }

        public static function count() {
            $query = parent::$pdo->prepare("
                SELECT COUNT(id) AS count
                FROM " . parent::getPrefix() . "Threads AS Threads
                WHERE
                    deleted IS NULL
                    AND
                    LOCATE (language, :languages)
                    AND
                    (
                        SELECT COUNT(Posts.id)
                        FROM " . parent::getPrefix() . "Posts AS Posts
                        INNER JOIN " . parent::getPrefix() . "Users AS Users
                        ON Users.id = Posts.userID
                        WHERE
                            Posts.deleted IS NULL
                            AND
                            Posts.threadID = Threads.id
                            AND
                            Users.deleted IS NULL
                    ) >= 1
            ");
            $query->bindValue(":languages", \Static\Languages\Translate::getUserLanguage(), PDO::PARAM_STR);
            $query->execute();

            return max($query->fetch()["count"] ?? 0, 1);
        }

        public static function create($title, $message, $image) {
            $title = htmlspecialchars($title);
            $message = htmlspecialchars($message);
            $image = htmlspecialchars($image);

            $sessionID = (int)\Static\Kernel::getValue($_SESSION, "sessionID");
            $userID = (int)\Static\Kernel::getValue($_SESSION, "userID");

            if(empty($title) || empty($message) || $sessionID <= 0 || $userID <= 0) return "error";

            $query = parent::$pdo->prepare("INSERT INTO " . parent::getPrefix() . "Threads (created, deleted, title, language) VALUES (NOW(), NULL, :title, :language)");
            $query->bindValue(":title", $title, PDO::PARAM_STR);
            $query->bindValue(":language", \Static\Languages\Translate::getLanguage(), PDO::PARAM_STR);

            if(!$query->execute()) return "error";

            $hash = \Static\Kernel::getHash("Thread", parent::$pdo->lastInsertId());

            return \Static\Kernel::getValue(\Static\Models\Posts::create($hash, $message, $image), "status") == "success" ? array(
                "status" => "success",
                "link" => "/thread/" . $hash,
            ) : "error";
        }

        public static function delete($hash) {
            $threadID = self::getID(htmlspecialchars($hash));

            $sessionID = (int)\Static\Kernel::getValue($_SESSION, "sessionID");
            $userID = (int)\Static\Kernel::getValue($_SESSION, "userID");

            if($threadID <= 0 || $sessionID <= 0 || $userID <= 0) return "error";

            $query = parent::$pdo->prepare("SELECT userID FROM " . parent::getPrefix() . "Posts WHERE threadID = :threadID LIMIT 1");
            $query->bindValue(":threadID", $threadID, PDO::PARAM_INT);
            $query->execute();

            if(!($author = $query->fetch()["userID"]) || $author != $userID) return "error";

            $query = parent::$pdo->prepare("UPDATE " . parent::getPrefix() . "Threads SET deleted = NOW() WHERE id = :threadID AND deleted IS NULL");
            $query->bindValue(":threadID", $threadID, PDO::PARAM_INT);

            return $query->execute() && (int)$query->rowCount() == 1 ? "success" : "error";
        }

        public static function getID($hash, $title = false) {
            $hash = htmlspecialchars($hash);

            if(empty($hash)) return 0;

            $query = parent::$pdo->query("SELECT id, title FROM " . parent::getPrefix() . "Threads WHERE deleted IS NULL ORDER BY ID DESC");

            while($response = $query->fetch()) {
                if(\Static\Kernel::getHash("Thread", $response["id"]) == $hash) return !$title ? $response["id"] : $response["title"];
            }

            return 0;
        }

    }

?>