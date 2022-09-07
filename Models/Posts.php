<?php

    namespace Static\Models;

    use PDO;

    final class Posts extends Database {

        public static function getPosts($link, $page) {
            $threadID = \Static\Models\Threads::getThreadID(htmlspecialchars($link));
            $page = (int)$page;

            if($threadID <= 0 || $page < 1) return array();

            $query = parent::$pdo->prepare("
                SELECT
                    Posts.hash AS hash,
                    Posts.created AS created,
                    Posts.userID AS userID,
                    Posts.message AS message,
                    Posts.image AS image,
                    Users.username AS username
                FROM Posts
                INNER JOIN Users
                ON Users.id = Posts.userID
                WHERE
                    Posts.deleted IS NULL
                    AND
                    Posts.threadID = :threadID
                    AND
                    Users.deleted IS NULL
                LIMIT :page, 10
            ");
            $query->bindValue(":threadID", $threadID, PDO::PARAM_INT);
            $query->bindValue(":page", $page * 10 - 10, PDO::PARAM_INT);
            $query->execute();

            $results = array();

            while($post = $query->fetch()) {
                array_push($results, array(
                    "user" => \Static\Kernel::getPath("/Public/Images/Users/" . \Static\Kernel::getHash("User", \Static\Kernel::getValue($post, "userID")) . ".jpeg?" . time()),
                    "username" => \Static\Kernel::getValue($post, "username"),
                    "date" => date_format(date_create(\Static\Kernel::getValue($post, "created")), substr(\Static\Kernel::getDateFormat(), 0, 5)),
                    "time" => date_format(date_create(\Static\Kernel::getValue($post, "created")), substr(\Static\Kernel::getDateFormat(), 5)),
                    "userID" => \Static\Kernel::getValue($post, "userID"),
                    "hash" => \Static\Kernel::getValue($post, "hash"),
                    "message" => \Static\Kernel::getValue($post, "message"),
                    "image" => !\Static\Kernel::getValue($post, "image") ? null : \Static\Kernel::getPath("/Public/Images/Posts/" . \Static\Kernel::getValue($post, "image") . ".jpeg?" . time()),
                ));
            }

            return $results;
        }

        public static function count($link) {
            $threadID = \Static\Models\Threads::getThreadID(htmlspecialchars($link));

            if($threadID <= 0) return 0;

            $query = parent::$pdo->prepare("
                SELECT COUNT(Posts.id) AS count
                FROM Posts
                INNER JOIN Users
                ON Users.id = Posts.userID
                WHERE
                    Posts.deleted IS NULL
                    AND
                    Posts.threadID = :threadID
                    AND
                    Users.deleted IS NULL
            ");
            $query->bindValue(":threadID", $threadID, PDO::PARAM_INT);
            $query->execute();

            return $query->fetch()["count"] ?? 0;
        }

        public static function create($link, $message, $image) {
            $threadID = \Static\Models\Threads::getThreadID(htmlspecialchars($link));
            $message = htmlspecialchars($message);
            $image = htmlspecialchars($image);

            if($threadID <= 0) return "error";
            else if(empty($message)) return "message";

            $sessionID = (int)\Static\Kernel::getValue($_SESSION, "sessionID");
            $userID = (int)\Static\Kernel::getValue($_SESSION, "userID");

            if($sessionID <= 0 || $userID <= 0) return "error";

            $query = parent::$pdo->prepare("INSERT INTO Posts (hash, created, deleted, sessionID, userID, threadID, message, image) VALUES (NULL, NOW(), NOW(), :sessionID, :userID, :threadID, :message, :image)");
            $query->bindValue(":sessionID", $sessionID, PDO::PARAM_INT);
            $query->bindValue(":userID", $userID, PDO::PARAM_INT);
            $query->bindValue(":threadID", $threadID, PDO::PARAM_INT);
            $query->bindValue(":message", $message, PDO::PARAM_STR);
            $query->bindValue(":image", empty($image) ? NULL : $image, PDO::PARAM_STR);

            if(!$query->execute()) return "error";

            $postID = parent::$pdo->lastInsertId();

            $query = parent::$pdo->prepare("UPDATE Posts SET hash = :hash, deleted = NULL WHERE id = :postID AND hash IS NULL AND deleted IS NOT NULL");
            $query->bindValue(":hash", \Static\Kernel::getHash("Post", $postID), PDO::PARAM_STR);
            $query->bindValue(":postID", $postID, PDO::PARAM_INT);

            return $query->execute() ? array(
                "status" => "success",
                "link" => \Static\Kernel::getPath("/thread/" . $link . "/" . ceil(\Static\Models\Posts::count($link) / 10)),
            ) : "error";
        }

        public static function delete($link) {
            $postID = self::getPostID(htmlspecialchars($link));

            if($postID <= 0) return "postID";

            $userID = (int)\Static\Kernel::getValue($_SESSION, "userID");

            if($userID <= 0) return "error";

            $query = parent::$pdo->prepare("SELECT MIN(id) AS id FROM Posts WHERE threadID = (SELECT threadID FROM Posts WHERE id = :postID)");
            $query->bindValue(":postID", $postID, PDO::PARAM_INT);
            $query->execute();

            if(!($firstID = $query->fetch()["id"]) || $firstID == $postID) return "error";

            $query = parent::$pdo->prepare("UPDATE Posts SET deleted = NOW() WHERE id = :postID AND deleted IS NULL AND userID = :userID");
            $query->bindValue(":postID", $postID, PDO::PARAM_INT);
            $query->bindValue(":userID", $userID, PDO::PARAM_INT);

            return $query->execute() && (int)$query->rowCount() >= 1 ? "success" : "error";
        }

        public static function getPostID($hash) {
            $hash = htmlspecialchars($hash);

            if(empty($hash)) return 0;

            $query = parent::$pdo->prepare("SELECT id FROM Posts WHERE hash = :hash AND deleted IS NULL");
            $query->bindValue(":hash", $hash, PDO::PARAM_STR);
            $query->execute();

            return $query->fetch()["id"] ?? 0;
        }

    }

?>