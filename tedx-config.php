<?php
/**
 * tedx-config.php
 * 
 * Author : Quentin Mathey
 * Date : 12.06.2013
 * 
 * Description : Config the app. Provide object $tedx_manager for Interface
 * Modeling.
 * 
 */

/* DATABASE CONFIG */
define('DB_LOCATION'    , 'pingouin1.heig-vd.ch');
define('DB_NAME'        , 'tedx-dev');
define('DB_USER'        , 'tedx');
define('DB_PASSWORD'    , 'BuVDuH2DRAQdFpU7');

/* APP CONFIG */
define('APP_DIR'   , 'E:\SiteWeb\tedxEventManager' );
define('CONFIG_DIR', APP_DIR);

/* Settings the app  */
require_once(APP_DIR.'/core/controller/Tedx_manager.class.php');
require_once(APP_DIR.'/core/services/Crud.class.php');
// globals vars
$tedx_manager = new Tedx_manager();
$crud = new Crud();

/* SESSION AND COOKIES*/
//session_set_cookie_params($lifetime, $path, $domain, $secure, $httponly);
session_start();

?>