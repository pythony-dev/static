<?php

    namespace Static;

    final class Kernel {

        private static $version = "1.8.2";
        private static $salt = "0123456789ABCDEF";
        private static $settings = array();

        private static $styles = array();
        private static $scripts = array();
        private static $routes = array();
        private static $requests = array();
        private static $route = "";

        public static function getSalt() {
            return self::$salt;
        }

        public static function getSettings($settings) {
            $settings = \Static\Kernel::getValue(self::$settings, $settings);

            foreach(self::$settings as $key => $value) $settings = str_replace("@" . $key, htmlspecialchars($value), $settings);

            return $settings;
        }

        public static function addStyle($style, $encode = true) {
            array_push(self::$styles, $encode ? htmlspecialchars($style) : $style);
        }

        public static function addScript($script, $encode = true) {
            array_push(self::$scripts, $encode ? htmlspecialchars($script) : $script);
        }

        public static function addRoute($name, $path) {
            array_push(self::$routes, array(
                "name" => htmlspecialchars($name),
                "path" => htmlspecialchars($path),
            ));
        }

        public static function addRequest($name, $secure = true) {
            array_push(self::$requests, array(
                "name" => htmlspecialchars($name),
                "secure" => boolval($secure),
            ));
        }

        public static function getRoute() {
            return self::$route;
        }

        public static function start($hash = null) {
            if(file_exists("Static/Settings.json")) self::$settings = (array)json_decode(file_get_contents("Static/Settings.json"));
            else exit();

            \Static\Models\Database::connect();
            \Static\Languages\Translate::setLanguage();

            if(!$hash && (!\Static\Models\Sessions::start() || !\Static\Models\Requests::start())) return self::setError(429, \Static\Languages\Translate::getText("error-requests"), false);
            else if(!array_key_exists("request", $_POST) || $hash) {
                self::addRoute("manifest", "/manifest");
                self::addRoute("email", "/email/(link)");
                self::addRoute("error", "/error/(error)");

                $start = strlen(self::getSettings("settings-link")) + 1;
                $search = explode("/", substr((array_key_exists("HTTPS", $_SERVER) ? "https" : "http") . "://" . self::getValue($_SERVER, "HTTP_HOST") . self::getValue($_SERVER, "REDIRECT_URL"), $start));

                foreach(self::$routes as $route) {
                    $path = explode("/", substr(self::getSettings("settings-link") . $route["path"], $start));

                    if(count($path) < count($search)) continue;

                    $parameters = array();
                    $found = true;

                    foreach($search as $id => $action) {
                        if(empty($action) && empty($path[$id])) break;
                        else if(empty($action) || count($path) <= $id || strlen($path[$id]) <= 0) $found = false;
                        else if($path[$id][0] == "(" && $path[$id][strlen($path[$id]) - 1] == ")") {
                            $value = substr($path[$id], 1, -1);

                            if(empty($value)) $found = false;
                            else $parameters[$value] = $action;
                        } else if($action != $path[$id]) $found = false;
                    }

                    if($found) {
                        self::$route = ucfirst($route["name"]);

                        if(self::$route == "Manifest") {
                            $themes = self::getThemes();
                            $theme = self::getValue($_SESSION, array("theme", "color"));

                            $colors = $themes["aqua"];

                            if(array_key_exists($theme, $themes)) $colors = $themes[$theme];

                            echo json_encode(array(
                                "name" => \Static\Kernel::getSettings("project-name"),
                                "version" => \Static\Kernel::getSettings("project-version"),
                                "start_url" => \Static\Kernel::getSettings("settings-link"),
                                "display" => "standalone",
                                "icons" => array(
                                    array(
                                        "src" => \Static\Kernel::getSettings("settings-link") . "/Public/Images/Index/Icon.jpeg",
                                        "type" => "image/png",
                                        "sizes" => "512x512",
                                    ),
                                ),
                                "background_color" => $colors[0],
                                "theme_color" => $colors[\Static\Kernel::isLight() ? 2 : 1],
                            ));

                            return;
                        } else if(self::$route == "Error") return self::setError(array_key_exists("error", $parameters) ? $parameters["error"] : 500, \Static\Languages\Translate::getText("error-internal"), false);

                        $view = "Views/" . self::$route . ".php";
                        $controller = "\Static\Controllers\\" . self::$route;

                        if(!file_exists($view)) return self::setError(404, \Static\Languages\Translate::getText("error-view") . $view, false);
                        else if(!class_exists($controller)) return self::setError(404, \Static\Languages\Translate::getText("error-controller") . $controller, false);

                        $parameters = $controller::start(\Static\Controllers\Main::start(array_merge($parameters, array(
                            "userID" => self::getValue($_SESSION, "userID"),
                            "title" => \Static\Languages\Translate::getText("title-" . lcfirst(self::$route)),
                            "hash" => $hash,
                            "getSettings" => "\Static\Kernel::getSettings",
                            "getPath" => "\Static\Kernel::getPath",
                            "getText" => "\Static\Languages\Translate::getText",
                        ))));

                        ob_start();
                        require($view);
                        $body = ob_get_contents();
                        ob_end_clean();

                        $title = array_key_exists("title", $parameters) ? $parameters["title"] : self::$route;
                        $styles = self::$styles;
                        $scripts = self::$scripts;

                        require("Views/Index.php");

                        return;
                    }
                }

                return self::setError(404, \Static\Languages\Translate::getText("error-route") . self::getValue($_SERVER, "REDIRECT_URL"), false);
            } else {
                header("Content-Type: application/json");

                self::addRequest("tokens", false);
                self::addRequest("siteMap");
                self::addRequest("settings");

                $search = htmlspecialchars($_POST["request"]);

                if(\Static\Kernel::getSettings("project-environment") != "development" && self::$requests[array_search($search, array_column(self::$requests, "name"))]["secure"] && !\Static\Models\Tokens::check()) return self::setError(401, \Static\Languages\Translate::getText("error-token") . \Static\Kernel::getValue($_POST, "token"), true);

                foreach(self::$requests as $request) {
                    if($search == $request["name"]) {
                        $request = "\Static\Requests\\" . ucfirst($request["name"]);
                        $action = self::getValue($_POST, "action");

                        if(!class_exists($request)) return self::setError(404, \Static\Languages\Translate::getText("error-class") . $request, true);
                        else if(!method_exists($request, $action)) return self::setError(404, \Static\Languages\Translate::getText("error-method") . $request . "::" . $action, true);

                        echo json_encode($request::$action());

                        return;
                    }
                }

                return self::setError(404, \Static\Languages\Translate::getText("error-request") . $search, true);
            }
        }

        public static function setError($error, $response, $request) {
            $parameters = \Static\Controllers\Error::start(\Static\Controllers\Main::start(array(
                "error" => (int)$error,
                "response" => htmlspecialchars($response),
                "userID" => self::getValue($_SESSION, "userID"),
                "hash" => false,
                "getSettings" => "\Static\Kernel::getSettings",
                "getPath" => "\Static\Kernel::getPath",
                "getText" => "\Static\Languages\Translate::getText",
            )));

            http_response_code(self::getValue($_GET, "error") != "false" ? (int)$parameters["error"] : 200);

            if($request) {
                echo json_encode(array(
                    "status" => "error",
                    "error" => (int)$parameters["error"],
                    "response" => htmlspecialchars($parameters["response"]),
                ));
            } else {
                ob_start();
                require_once("Views/Error.php");
                $body = ob_get_contents();
                ob_end_clean();

                $title = array_key_exists("title", $parameters) ? $parameters["title"] : $parameters["getText"]("title-error");
                $styles = self::$styles;
                $scripts = self::$scripts;

                require_once("Views/Index.php");
            }

            \Static\Models\Errors::create((int)$parameters["error"], htmlspecialchars($parameters["response"]));

            exit();
        }

        public static function getValue($array, $keys) {
            if(!is_array($array)) return null;
            else if(!is_array($keys) && array_key_exists($keys, $array)) return htmlspecialchars($array[$keys]);
            else if(is_array($keys) && count($keys) == 1 && array_key_exists($keys[0], $array)) return htmlspecialchars($array[$keys[0]]);
            else if(is_array($keys) && count($keys) > 1) {
                $key = array_shift($keys);

                if(array_key_exists($key, $array)) return self::getValue($array[$key], $keys);
                else return null;
            } else return null;
        }

        public static function getPath($path, $encode = true) {
            $path = $encode ? htmlspecialchars($path) : $path;

            if(empty($path) || (strlen($path) > 0 && $path[0] == "/")) return self::getSettings("settings-link") . $path;
            else return $path;
        }

        public static function getHash($folder, $id) {
            return sha1(htmlspecialchars($folder) . "-" . htmlspecialchars($id) . "?" . self::$salt);
        }

        public static function getID($id) {
            return (int)(($id - 1) / count(\Static\Languages\Translate::getAllLanguages())) + 1;
        }

        public static function getRequest($response) {
            return is_array($response) ? $response : array(
                "status" => $response,
            );
        }

        public static function getDateFormat() {
            return (\Static\Languages\Translate::getLanguage() == "english" ? "m/d" : "d/m") . "/Y H:i:s";
        }

        public static function isLight() {
            return self::getValue($_SESSION, array("theme", "mode")) != "dark";
        }

        public static function getThemes() {
            return array(
                "maraschino" => array("FF2600", "941100", "FF7E79"),
                "tangerine" => array("FF9300", "945200", "FFD479"),
                "lemon" => array("FFFB00", "929000", "FFFC79"),
                "lime" => array("8EFA00", "4F8F00", "D4FB79"),
                "spring" => array("00F900", "008F00", "73FA79"),
                "foam" => array("00FA92", "009051", "73FCD6"),
                "turquoise" => array("00FDFF", "009193", "73FDFF"),
                "aqua" => array("0096FF", "005493", "76D6FF"),
                "blueberry" => array("0433FF", "011993", "7A81FF"),
                "grape" => array("9437FF", "531B93", "D783FF"),
                "magenta" => array("FF40FF", "942193", "FF85FF"),
                "strawberry" => array("FF2F92", "941751", "FF8AD8"),
            );
        }

        public static function getNetworks() {
            return array("Facebook", "Instagram", "Threads", "YouTube", "TikTok");
        }

    }

?>