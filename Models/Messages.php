<?php

    namespace Static\Models;

    use PDO;

    final class Messages extends Database {

        public static function getMessages($page) {
            $page = (int)$page;

            $userID = (int)\Static\Kernel::getValue($_SESSION, "userID");

            if($page < 1 || $userID < 1) return "error";

            $query = parent::$pdo->prepare("
                SELECT
                    Users.id AS userID,
                    Users.username AS username,
                    (
                        SELECT MAX(created)
                        FROM Messages
                        WHERE
                            (senderID = :userID AND receiverID = Users.id)
                            OR
                            (senderID = Users.id AND receiverID = :userID)
                    ) AS updated,
                    (
                        SELECT message
                        FROM Messages
                        WHERE
                            (senderID = :userID AND receiverID = Users.id)
                            OR
                            (senderID = Users.id AND receiverID = :userID)
                        ORDER BY ID DESC
                        LIMIT 1
                    ) AS message
                FROM Messages
                INNER JOIN Users
                ON Users.id = IF(Messages.senderID = :userID, Messages.receiverID, Messages.senderID)
                WHERE
                    Messages.deleted IS NULL
                    AND
                    (Messages.senderID = :userID OR Messages.receiverID = :userID)
                GROUP BY Users.id
                ORDER BY updated DESC
                LIMIT :page, 10
            ");
            $query->bindValue(":userID", $userID, PDO::PARAM_INT);
            $query->bindValue(":page", $page * 10 - 10, PDO::PARAM_INT);
            $query->execute();

            $results = array();

            while($message = $query->fetch()) {
                $hash = \Static\Kernel::getHash("User", (int)\Static\Kernel::getValue($message, "userID"));

                $today = date_format(date_create(), substr(\Static\Kernel::getDateFormat(), 0, 5));
                $date = date_format(date_create($message["updated"]), substr(\Static\Kernel::getDateFormat(), 0, 5));
                $time = date_format(date_create($message["updated"]), substr(\Static\Kernel::getDateFormat(), 5));

                array_push($results, array(
                    "link" => \Static\Kernel::getPath("/chat/" . $hash),
                    "sender" => \Static\Kernel::getPath("/Public/Images/Users/" . $hash . ".jpeg?" . time()),
                    "username" => \Static\Kernel::getValue($message, "username"),
                    "updated" => $today != $date ? $date : $time,
                    "count" => self::count((int)\Static\Kernel::getValue($message, "userID")),
                    "hash" => $hash,
                    "message" => \Static\Kernel::getValue($message, "message"),
                ));
            }

            return array(
                "status" => "success",
                "messages" => $results,
            );
        }

        public static function getMessagesByUser($link, $page) {
            $otherID = (int)\Static\Models\Users::getID($link);
            $page = (int)$page;

            $userID = (int)\Static\Kernel::getValue($_SESSION, "userID");

            if($otherID < 1 || $page < 1 || $userID < 1) return "error";

            $query = parent::$pdo->prepare("
                SELECT
                    Messages.id AS messageID,
                    Messages.created AS created,
                    Messages.message AS message,
                    Messages.image AS image,
                    Users.id AS userID,
                    Users.username AS username
                FROM Messages
                INNER JOIN Users
                ON Users.id = Messages.senderID
                WHERE
                    Messages.deleted IS NULL
                    AND
                    (
                        (Messages.senderID = :userID AND Messages.receiverID = :otherID)
                        OR
                        (Messages.senderID = :otherID AND Messages.receiverID = :userID)
                    )
                ORDER BY Messages.created DESC
                LIMIT :page, 10
            ");
            $query->bindValue(":userID", $userID, PDO::PARAM_INT);
            $query->bindValue(":otherID", $otherID, PDO::PARAM_INT);
            $query->bindValue(":page", $page * 10 - 10, PDO::PARAM_INT);
            $query->execute();

            $results = array();

            while($message = $query->fetch()) {
                $senderID = (int)\Static\Kernel::getValue($message, "userID");

                array_push($results, array(
                    "user" => \Static\Kernel::getPath("/Public/Images/Users/" . \Static\Kernel::getHash("User", $senderID) . ".jpeg?" . time()),
                    "username" => \Static\Kernel::getValue($message, "username"),
                    "date" => date_format(date_create(\Static\Kernel::getValue($message, "created")), substr(\Static\Kernel::getDateFormat(), 0, 5)),
                    "time" => date_format(date_create(\Static\Kernel::getValue($message, "created")), substr(\Static\Kernel::getDateFormat(), 5)),
                    "hash" => $senderID == $userID ? \Static\Kernel::getHash("Message", \Static\Kernel::getValue($message, "messageID")) : null,
                    "image" => \Static\Kernel::getValue($message, "image") ? \Static\Kernel::getPath("/Public/Images/Messages/" . \Static\Kernel::getValue($message, "image") . ".jpeg") : null,
                    "message" => \Static\Kernel::getValue($message, "message"),
                ));
            }

            return array(
                "status" => "success",
                "messages" => $results,
            );
        }

        public static function create($link, $message, $image) {
            $receiverID = (int)\Static\Models\Users::getID($link);
            $message = htmlspecialchars($message);
            $image = htmlspecialchars($image);
            $status = self::isContact($receiverID);

            $sessionID = (int)\Static\Kernel::getValue($_SESSION, "sessionID");
            $userID = (int)\Static\Kernel::getValue($_SESSION, "userID");

            if($status != "success") return $status;
            else if($receiverID <= 0 || empty($message) || $sessionID <= 0 || $userID <= 0 || $receiverID == $userID) return "error";

            $query = parent::$pdo->prepare("INSERT INTO Messages (created, deleted, sessionID, senderID, receiverID, message, image) VALUES (NOW(), NULL, :sessionID, :senderID, :receiverID, :message, :image)");
            $query->bindValue(":sessionID", $sessionID, PDO::PARAM_INT);
            $query->bindValue(":senderID", $userID, PDO::PARAM_INT);
            $query->bindValue(":receiverID", $receiverID, PDO::PARAM_INT);
            $query->bindValue(":message", $message, PDO::PARAM_STR);
            $query->bindValue(":image", empty($image) ? NULL : $image, PDO::PARAM_STR);

            if(!$query->execute()) return "error";

            $user = \Static\Models\Users::getUser($receiverID);

            if(\Static\Kernel::getValue(json_decode(htmlspecialchars_decode($user["notifications"]), true), "message") != "false") {
                $email = \Static\Kernel::getValue($user, "email");
                $title = \Static\Languages\Translate::getText("emails-message-title");
                $content = \Static\Languages\Translate::getText("emails-message-content", true, array(
                    "username" => \Static\Kernel::getValue($user, "username"),
                    "messages" => \Static\Kernel::getPath("/messages"),
                ));

                if(!\Static\Emails::send($email, $title, $content)) return "error";
            }

            return array(
                "status" => "success",
                "link" => \Static\Kernel::getPath("/chat/" . $link),
            );
        }

        public static function delete($link) {
            $messageID = (int)self::getID($link);

            $userID = (int)\Static\Kernel::getValue($_SESSION, "userID");

            if($messageID <= 0 || $userID <= 0) return "error";

            $query = parent::$pdo->prepare("UPDATE Messages SET deleted = NOW() WHERE id = :messageID AND deleted IS NULL AND senderID = :userID");
            $query->bindValue(":messageID", $messageID, PDO::PARAM_INT);
            $query->bindValue(":userID", $userID, PDO::PARAM_INT);

            return $query->execute() && (int)$query->rowCount() >= 1 ? "success" : "error";
        }

        public static function deleteByUser($link) {
            $otherID = (int)\Static\Models\Users::getID($link);

            $userID = (int)\Static\Kernel::getValue($_SESSION, "userID");

            if($otherID <= 0 || $userID <= 0) return "error";

            $query = parent::$pdo->prepare("
                UPDATE Messages
                SET deleted = NOW()
                WHERE
                    deleted IS NULL
                    AND
                    (
                        (senderID = :userID AND receiverID = :otherID)
                        OR
                        (senderID = :otherID AND receiverID = :userID)
                    )
            ");
            $query->bindValue(":userID", $userID, PDO::PARAM_INT);
            $query->bindValue(":otherID", $otherID, PDO::PARAM_INT);

            return $query->execute() && (int)$query->rowCount() >= 1 ? "success" : "error";
        }

        public static function deleteUser() {
            $userID = (int)\Static\Kernel::getValue($_SESSION, "userID");

            if($userID <= 0) return false;

            $query = parent::$pdo->prepare("UPDATE Messages SET deleted = NOW() WHERE deleted IS NULL AND (senderID = :userID OR receiverID = :userID)");
            $query->bindValue(":userID", $userID, PDO::PARAM_INT);

            return $query->execute();
        }

        public static function isContact($otherID) {
            $otherID = (int)$otherID;

            $userID = (int)\Static\Kernel::getValue($_SESSION, "userID");

            if($otherID <= 0 || $userID <= 0) return "error";

            $query = parent::$pdo->prepare("
                SELECT
                    others,
                    (SELECT COUNT(id) FROM Blocks WHERE deleted IS NULL AND blockerID = :otherID AND blockedID = :userID) AS blocks
                FROM Users
                WHERE
                    id = :otherID
                    AND
                    deleted IS NULL
            ");
            $query->bindValue(":otherID", $otherID, PDO::PARAM_INT);
            $query->bindValue(":userID", $userID, PDO::PARAM_INT);
            $query->execute();

            if(!($results = $query->fetch())) return "error";
            else if(\Static\Kernel::getValue(json_decode(htmlspecialchars_decode($results["others"]), true), "contact") == "false" && self::count($otherID) == 0) return "contact";
            else if(\Static\Kernel::getValue($results, "blocks") != 0) return "blocked";
            else return "success";
        }

        public static function count($otherID) {
            $otherID = (int)$otherID;

            $userID = (int)\Static\Kernel::getValue($_SESSION, "userID");

            if($otherID <= 0 || $userID <= 0) return 0;

            $query = parent::$pdo->prepare("
                SELECT COUNT(id) AS count
                FROM Messages
                WHERE
                    deleted IS NULL
                    AND
                    (
                        (senderID = :userID AND receiverID = :otherID)
                        OR
                        (senderID = :otherID AND receiverID = :userID)
                    )
            ");
            $query->bindValue(":userID", $userID, PDO::PARAM_INT);
            $query->bindValue(":otherID", $otherID, PDO::PARAM_INT);
            $query->execute();

            return $query->fetch()["count"] ?? 0;
        }

        public static function getID($hash) {
            $hash = htmlspecialchars($hash);

            if(empty($hash)) return 0;

            $query = parent::$pdo->query("SELECT id FROM Messages WHERE deleted IS NULL ORDER BY ID DESC");

            while($response = $query->fetch()) {
                if(\Static\Kernel::getHash("Message", $response["id"]) == $hash) return $response["id"];
            }

            return 0;
        }

    }

?>