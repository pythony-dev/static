<?php

    namespace Static\Models;

    use PDO;

    final class Confirmations extends Database {

        public static function create($email) {
            $email = htmlspecialchars($email);

            $sessionID = (int)\Static\Kernel::getValue($_SESSION, "sessionID");

            if(!in_array(\Static\Models\Users::isEmail($email), array("success", "used"))) return "email";
            else if($sessionID <= 0) return "error";

            $code = "";

            while(strlen($code) != 8) {
                $random = rand(0, 35);

                if($random <= 9) $code .= $random;
                else $code .= chr($random + 55);
            }

            $query = parent::$pdo->prepare("INSERT INTO Confirmations (created, deleted, sessionID, email, code) VALUES (NOW(), NULL, :sessionID, :email, :code)");
            $query->bindValue(":sessionID", $sessionID, PDO::PARAM_INT);
            $query->bindValue(":email", $email, PDO::PARAM_STR);
            $query->bindValue(":code", $code, PDO::PARAM_STR);

            $title = \Static\Languages\Translate::getText("emails-confirmations-title");
            $content = \Static\Languages\Translate::getText("emails-confirmations-content", true, array(
                "code" => $code,
            ));

            return self::delete($email) && $query->execute() && \Static\Emails::send($email, $title, $content, true) ? "success" : "error";
        }

        public static function delete($email) {
            $email = htmlspecialchars($email);

            if(!in_array(\Static\Models\Users::isEmail($email), array("success", "used"))) return false;

            $query = parent::$pdo->prepare("UPDATE Confirmations SET deleted = NOW() WHERE deleted IS NULL AND email = :email");
            $query->bindValue(":email", $email, PDO::PARAM_STR);

            return $query->execute();
        }

        public static function check($email, $code) {
            $email = htmlspecialchars($email);
            $code = htmlspecialchars($code);

            if(!in_array(\Static\Models\Users::isEmail($email), array("success", "used")) || strlen($code) != 8) return false;

            $query = parent::$pdo->prepare("SELECT id FROM Confirmations WHERE deleted IS NULL AND email = :email AND code = :code AND UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(created) <= 3600");
            $query->bindValue(":email", $email, PDO::PARAM_STR);
            $query->bindValue(":code", $code, PDO::PARAM_STR);
            $query->execute();

            return boolval($query->fetch());
        }

    }

?>