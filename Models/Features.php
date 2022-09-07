<?php

    namespace Static\Models;

    use PDO;

    final class Features extends Database {

        public static function getFeatures() {
            $query = parent::$pdo->prepare("SELECT id, title, subtitle, content FROM Features WHERE language = :language ORDER BY id DESC");
            $query->bindValue(":language", \Static\Languages\Translate::getLanguage(), PDO::PARAM_STR);
            $query->execute();

            $results = array();

            while($feature = $query->fetch()) {
                array_push($results, array(
                    "image" => \Static\Kernel::getPath("/Public/Images/Features/" . \Static\Kernel::getHash("Feature", \Static\Kernel::getID(\Static\Kernel::getValue($feature, "id"))) . ".jpeg"),
                    "title" => $feature["title"],
                    "subtitle" => $feature["subtitle"],
                    "content" => $feature["content"],
                ));
            }

            return $results;
        }

    }

?>