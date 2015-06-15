<?php 

if (function_exists('plugin_dir_path')) 
{
    $path =  plugin_dir_path( __FILE__ );
} 
else 
{
    $path = dirname(dirname(dirname(dirname(__FILE__)))).'/wp-content/plugins/dd_codes/';
    
    require_once( dirname(dirname(dirname(dirname(__FILE__)))).'/wp-load.php' );
}


if ( file_exists( plugin_dir_path( __FILE__ ) . 'vendor/autoload.php' ) )  
require_once( plugin_dir_path( __FILE__ ) . 'vendor/autoload.php' );
