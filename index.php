<?php
define("DS",DIRECTORY_SEPARATOR);
define("APP_DIR", "App");
define("GLOBALDIR",getcwd());
$file = APP_DIR.DS."index.php";

require $file;
