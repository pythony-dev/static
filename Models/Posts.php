<?php

    namespace Static\Models;

    use PDO;

    final class Posts extends Database {

        public static function getPosts($link, $page) {
            $threadID = \Static\Models\Threads::getID(htmlspecialchars($link));
            $page = (int)$page;

            if($threadID <= 0 || $page <= 0) return array();

            $query = parent::$pdo->prepare("
                SELECT
                    Posts.id AS postID,
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
                    "hash" => \Static\Kernel::getHash("Post", \Static\Kernel::getValue($post, "postID")),
                    "chat" => \Static\Models\Messages::isContact(\Static\Kernel::getValue($post, "userID")) == "success" ? \Static\Kernel::getPath("/chat/" . \Static\Kernel::getHash("User", \Static\Kernel::getValue($post, "userID"))) : null,
                    "image" => !\Static\Kernel::getValue($post, "image") ? null : \Static\Kernel::getPath("/Public/Images/Posts/" . \Static\Kernel::getValue($post, "image") . ".jpeg?" . time()),
                    "message" => \Static\Kernel::getValue($post, "message"),
                ));
            }

            return $results;
        }

        public static function count($link) {
            $threadID = \Static\Models\Threads::getID(htmlspecialchars($link));

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
            $link = htmlspecialchars($link);
            $threadID = \Static\Models\Threads::getID($link);
            $message = htmlspecialchars($message);
            $image = htmlspecialchars($image);

            $sessionID = (int)\Static\Kernel::getValue($_SESSION, "sessionID");
            $userID = (int)\Static\Kernel::getValue($_SESSION, "userID");

            if($threadID <= 0 || empty($message) || $sessionID <= 0 || $userID <= 0) return "error";

            $query = parent::$pdo->prepare("INSERT INTO Posts (created, deleted, sessionID, userID, threadID, message, image) VALUES (NOW(), NULL, :sessionID, :userID, :threadID, :message, :image)");
            $query->bindValue(":sessionID", $sessionID, PDO::PARAM_INT);
            $query->bindValue(":userID", $userID, PDO::PARAM_INT);
            $query->bindValue(":threadID", $threadID, PDO::PARAM_INT);
            $query->bindValue(":message", $message, PDO::PARAM_STR);
            $query->bindValue(":image", empty($image) ? NULL : $image, PDO::PARAM_STR);

            return $query->execute() ? array(
                "status" => "success",
                "link" => \Static\Kernel::getPath("/thread/" . $link . "/" . ceil(\Static\Models\Posts::count($link) / 10)),
            ) : "error";
        }

        public static function delete($link) {
            $postID = self::getID(htmlspecialchars($link));

            $userID = (int)\Static\Kernel::getValue($_SESSION, "userID");

            if($postID <= 0 || $userID <= 0) return "error";

            $query = parent::$pdo->prepare("SELECT MIN(id) AS id FROM Posts WHERE threadID = (SELECT threadID FROM Posts WHERE id = :postID)");
            $query->bindValue(":postID", $postID, PDO::PARAM_INT);
            $query->execute();

            if(!($firstID = $query->fetch()["id"]) || $firstID == $postID) return "error";

            $query = parent::$pdo->prepare("UPDATE Posts SET deleted = NOW() WHERE id = :postID AND deleted IS NULL AND userID = :userID");
            $query->bindValue(":postID", $postID, PDO::PARAM_INT);
            $query->bindValue(":userID", $userID, PDO::PARAM_INT);

            return $query->execute() && (int)$query->rowCount() == 1 ? "success" : "error";
        }

        public static function getID($hash) {
            $hash = htmlspecialchars($hash);

            if(empty($hash)) return 0;

            $query = parent::$pdo->query("SELECT id FROM Posts WHERE deleted IS NULL ORDER BY ID DESC");

            while($response = $query->fetch()) {
                if(\Static\Kernel::getHash("Post", $response["id"]) == $hash) return $response["id"];
            }

            return 0;
        }

    }

?>