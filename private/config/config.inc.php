<?php

/*
 * Folders
 */
define("CONTROLLER_DIR", APP_DIR."/controller");
define("TEMPLATE_DIR", APP_DIR."/template");
define("INCLUDE_DIR", APP_DIR."/include");
define("CLASS_DIR", APP_DIR."/class");
define("ADMIN_DIR", APP_DIR."/admin");

define("CACHE_DIR", PUBLIC_DIR."/cache");
define("CSS_DIR", PUBLIC_DIR."/css");
define("JS_DIR", PUBLIC_DIR."/js");
define("IMG_DIR", PUBLIC_DIR."/img");

/*
 * Database
 */
define("DB_HOST", "localhost");
define("DB_USER", "");
define("DB_PASS", "");
define("DB_BASE", "");
define("DB_DEBUG", true);

/*
 * JS
 */
define("JS_CACHE_TTL_MIN", 60); // 1 minute
define("JS_CACHE_TTL_MAX", 86400); // 1 jour
define("JS_CACHE_EXPIRES", 2592000); // 30 jours

/*
 * CSS
 */
define("CSS_CACHE_TTL_MIN", 60); // 1 minute
define("CSS_CACHE_TTL_MAX", 86400); // 1 jour
define("CSS_CACHE_EXPIRES", 2592000); // 30 jours

/*
 * Captcha
 */
define("CAPTCHA_FONT", "Bleeding_Cowboys.ttf");

/*
 * Model classes
 */
$_model_list = array(
);

?>