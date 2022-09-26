<?php

    namespace Static\Models;

    use PDO;

    final class Threads extends Database {

        public static function getThreads($page) {
            $page = (int)$page;

            if($page < 1) return array();

            $query = parent::$pdo->prepare("
                SELECT
                    hash,
                    title,
                    (SELECT userID FROM Posts WHERE threadID = Threads.id LIMIT 1) AS userID,
                    (SELECT username FROM Users WHERE id = userID) AS author,
                    (SELECT MAX(created) FROM Posts WHERE threadID = Threads.id) AS updated,
                    (
                        SELECT COUNT(Posts.id)
                        FROM Posts
                        INNER JOIN Users
                        ON Users.id = Posts.userID
                        WHERE
                            Posts.deleted IS NULL
                            AND
                            Posts.threadID = Threads.id
                            AND
                            Users.deleted IS NULL
                    ) AS count
                FROM Threads
                WHERE
                    deleted IS NULL
                    AND
                    LOCATE (language, :languages)
                    AND
                    (
                        SELECT COUNT(Posts.id)
                        FROM Posts
                        INNER JOIN Users
                        ON Users.id = Posts.userID
                        WHERE
                            Posts.deleted IS NULL
                            AND
                            Posts.threadID = Threads.id
                            AND
                            Users.deleted IS NULL
                    ) >= 1
                ORDER BY updated DESC
                LIMIT :page, 10
            ");
            $query->bindValue(":languages", \Static\Languages\Translate::getUserLanguage(), PDO::PARAM_STR);
            $query->bindValue(":page", $page * 10 - 10, PDO::PARAM_INT);
            $query->execute();

            $results = array();

            while($thread = $query->fetch()) {
                array_push($results, array(
                    "hash" => \Static\Kernel::getValue($thread, "hash"),
                    "image" => \Static\Kernel::getPath("/Public/Images/Users/" . \Static\Kernel::getHash("User", \Static\Kernel::getValue($thread, "userID")) . ".jpeg?" . time()),
                    "author" => \Static\Kernel::getValue($thread, "author"),
                    "updated" => date_format(date_create($thread["updated"]), substr(\Static\Kernel::getDateFormat(), 0, 5)),
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
                FROM Threads
                WHERE
                    deleted IS NULL
                    AND
                    LOCATE (language, :languages)
                    AND
                    (
                        SELECT COUNT(Posts.id)
                        FROM Posts
                        INNER JOIN Users
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

            return $query->fetch()["count"] ?? 0;
        }

        public static function create($title, $message, $image) {
            $title = htmlspecialchars($title);
            $message = htmlspecialchars($message);
            $image = htmlspecialchars($image);

            if(empty($title)) return "title";
            else if(empty($message)) return "message";

            $sessionID = (int)\Static\Kernel::getValue($_SESSION, "sessionID");
            $userID = (int)\Static\Kernel::getValue($_SESSION, "userID");

            if($sessionID <= 0 || $userID <= 0) return "error";

            $query = parent::$pdo->prepare("INSERT INTO Threads (hash, created, deleted, title, language) VALUES (NULL, NOW(), NOW(), :title, :language)");
            $query->bindValue(":title", $title, PDO::PARAM_STR);
            $query->bindValue(":language", \Static\Languages\Translate::getLanguage(), PDO::PARAM_STR);

            if(!$query->execute()) return "error";

            $threadID = parent::$pdo->lastInsertId();
            $hash = \Static\Kernel::getHash("Thread", $threadID);

            $query = parent::$pdo->prepare("UPDATE Threads SET hash = :hash, deleted = NULL WHERE id = :threadID AND hash IS NULL AND deleted IS NOT NULL");
            $query->bindValue(":hash", $hash, PDO::PARAM_STR);
            $query->bindValue(":threadID", $threadID, PDO::PARAM_INT);

            if(!$query->execute()) return "error";

            $response = \Static\Models\Posts::create($hash, $message, $image);

            return \Static\Kernel::getValue($response, "status") == "success" ? array(
                "status" => "success",
                "link" => \Static\Kernel::getPath("/thread/" . $hash),
            ) : $response;
        }

        public static function delete($hash) {
            $threadID = self::getThreadID(htmlspecialchars($hash));

            if($threadID <= 0) return "threadID";

            $sessionID = (int)\Static\Kernel::getValue($_SESSION, "sessionID");
            $userID = (int)\Static\Kernel::getValue($_SESSION, "userID");

            if($sessionID <= 0 || $userID <= 0) return "error";

            $query = parent::$pdo->prepare("SELECT userID FROM Posts WHERE threadID = :threadID LIMIT 1");
            $query->bindValue(":threadID", $threadID, PDO::PARAM_INT);
            $query->execute();

            if(!($author = $query->fetch()["userID"]) || $author != $userID) return "error";

            $query = parent::$pdo->prepare("UPDATE Threads SET deleted = NOW() WHERE id = :threadID AND deleted IS NULL");
            $query->bindValue(":threadID", $threadID, PDO::PARAM_INT);

            return $query->execute() ? "success" : "error";
        }

        public static function getThreadID($hash) {
            $hash = htmlspecialchars($hash);

            if(empty($hash)) return 0;

            $query = parent::$pdo->prepare("SELECT id FROM Threads WHERE hash = :hash AND deleted IS NULL");
            $query->bindValue(":hash", $hash, PDO::PARAM_STR);
            $query->execute();

            return $query->fetch()["id"] ?? 0;
        }

        public static function getTitle($hash) {
            $hash = htmlspecialchars($hash);

            if(empty($hash)) return null;

            $query = parent::$pdo->prepare("SELECT title FROM Threads WHERE hash = :hash AND deleted IS NULL");
            $query->bindValue(":hash", $hash, PDO::PARAM_STR);
            $query->execute();

            return $query->fetch()["title"] ?? null;
        }

    }

?>