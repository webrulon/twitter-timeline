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
define('_ABSPATH', dirname(dirname(__FILE__)));
define('_WEBROOT', _ABSPATH . DS . 'webroot');
define('_ELEMENT', _ABSPATH . DS . 'elements');
define('_LIB', _ABSPATH . DS . 'lib');

//external (browsers)
define('ABSPATH', DS . 'baseapp');
define('WEBROOT', ABSPATH . DS . 'webroot');
define('WEBROOT_CSS', WEBROOT . DS . 'css');
define('WEBROOT_JS', WEBROOT . DS . 'js');
define('WEBROOT_IMG', WEBROOT . DS . 'img');
define('WEBROOT_LIB', WEBROOT . DS . 'lib');

define('TWITTER_KEY','sdfsdf');
define('TWITTER_SECRET','sdfsdf');

define('TWITTER_LANDPAGE', ABSPATH . DS . 'home.php');