<?php
/*
  Plugin Name: Code crew plugin
  Plugin URI: http://codecrew.tech/
  Description: Creates and manages cool scroller galleries.
  Version: 1.41
  Author: Code crew plugin
  Author URI: http://codecrew.tech/
 */







include_once(dirname(__FILE__).'/dzs_functions.php');
if(!class_exists('DZSScrollerGallery')){
    include_once(dirname(__FILE__).'/class-dzssg.php');
}


define("DZSSG_VERSION", "1.41");

$dzssg = new DZSScrollerGallery();