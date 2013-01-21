<?php

session_start();

/*
 * please remember, this is developed on linux(LAMP)
 * so it may conflict with names on case insensitive os( ex. windows )
 */

/*
 * NOTE:
 * i havent stored the auth token to db
 * so , one user auth, token will be lost when the session is closed
 * this was not done, because their wasnt mentioned to save the token to db
 */

define('DS', '/');
define('DOT', '.');
define('_BASEAPP', dirname(__FILE__));

require_once _BASEAPP . DS .'config.php';
require_once _BASEAPP . DS .'class.Theme.php';
require_once _BASEAPP . DS .'class.Twitter.php';

/* create some globals */
$twitter = new Twitter;
$theme = new Theme;