<?php
/*
Plugin Name: The Stiz - Audio for WooCommerce
Plugin URI: http://pagesofinterest.net/projects/the-stiz-audio-for-woocommerce/
Description:
Version: 1.0.2
Author: Michael Robinson
Author URI: http://pagesofinterest.net/
Contributors: Mike Hemberger
Author URI: http://thestiz.com/
License: http://www.gnu.org/licenses/gpl.html
*/

if (!defined('WCJD_ROOT')) {
    define('WCJD_ROOT', dirname(__FILE__));
}

include_once WCJD_ROOT.'/include.php';

register_activation_hook(__FILE__, array('WCJDInstaller', 'install'));

$initialiser = new WCJDInitialiser();
