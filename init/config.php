<?php
/*
 * This is the main config file
 */

/*
 * dirname(__FILE__) gets the path of the current directory of the file
 * it always give path of the file parent directory even if included in other files
 * 
 * path of some directory
 * 
 * NOTE: please mind the naming convention
 * a prefix '_' before any define is used to inform that this is for internal use of php
 * for printing for a browser , use the un prefixed version
 * ex:
 *  ABSPATH contain /home/kuldeep/www/webroot
 *  _ABSPATH contain http://localhost/webroot
 */

define('EXT_JS', 'js');
define('EXT_CSS', 'css');
define('EXT_PHP', 'php');

//internals(file access)
define('_ABSPATH', dirname(_BASEAPP));
define('_WEBROOT', _ABSPATH . DS . 'webroot');
define('_ELEMENT', _ABSPATH . DS . 'elements');
define('_LIB', _ABSPATH . DS . 'lib');

//external (browsers)
define('ABSPATH', 'https://twitter-timeline.pagodabox.com');
define('WEBROOT', ABSPATH . DS . 'webroot');
define('WEBROOT_CSS', WEBROOT . DS . 'css');
define('WEBROOT_JS', WEBROOT . DS . 'js');
define('WEBROOT_IMG', WEBROOT . DS . 'img');
define('WEBROOT_LIB', WEBROOT . DS . 'lib');

define('TWITTER_KEY','23vRWb6FnR4ky6aNfmwYw');
define('TWITTER_SECRET','VHzDgHdZ4bXo7dgrOC1gtzL99a63Jq7uqsidpC8E8');

define('TWITTER_LANDPAGE', ABSPATH . DS . 'index.php');
define('TWITTER_CALLBACK', ABSPATH . DS . 'callback.php');
define('TWITTER_LOGIN', ABSPATH . DS . 'connect.php');

define('TWITTER_API_URL', 'https://api.twitter.com/1.1/');
define('TWITTER_MAX_ID_FETCHED', 5000);
define('TWITTER_MAX_USER_LOOKUP', 100);