<?php

//APPLICATION DIRECTORIES
/********************************************/
define("ROOT", dirname(__DIR__));
define("WEBROOT", ROOT."/public");
define("CORE", ROOT."/src/Core");
define("APP", ROOT."/src/Ngpictures");
define("UPLOAD", WEBROOT."/uploads");



//APPLICATION KEYS
/********************************************/
define("SITE_NAME", "http://127.1.1.1");
define("ADMIN", "/backoffice");
define("AUTH_KEY", "auth");
define("FLASH_MESSAGE_KEY", "flash");
define("TOKEN_KEY", "token");
define("CAPTCHA_KEY", "captcha");
define("COOKIE_REMEMBER_KEY", "NGPICTURES-REMEMBER");
define('ENV', 'developpement');

//APPLICATION API KEYS
//***************************************************************
define("MAPS_API_KEY", "AIzaSyBGKrzWSCBr0PROSEO0knD5vBrNsiW-7zU");
define("RECAPTCHA_SITE_KEY", "6LfUxlwUAAAAABl24HJ4H8wRcMGVm4aqxfob9IKb");
define("RECAPTCH_API_KEY", "6LfUxlwUAAAAAFq_8arOgt2Px_mqKHUQNURiOn4A");
define("PEXELS_API_KEY", "563492ad6f91700001000001501c76171edf4ba0b829e6583eb64dcc");
