<?php
/*
	Plugin Name: Code d'accès
	Description: Gestion des codes d'accès au site droit pour le praticien
	Version: 1
	Author:@designpond
	Author URI: http://designpond.ch
*/

//menu items
add_action('admin_menu','dd_codes_modifymenu');

function dd_codes_modifymenu() {
	
	//this is the main item for the menu
	add_menu_page('Codes d\'accès', //page title
	'Codes d\'accès', //menu title
	'manage_options', //capabilities
	'dd_codes_list', //menu slug
	dd_codes_list //function
	);
	
	//this is a submenu
	add_submenu_page('dd_codes_list', //parent slug
	'Add New School', //page title
	'Add New', //menu title
	'manage_options', //capability
	'dd_codes_create', //menu slug
	'dd_codes_create'); //function
	
	//this submenu is HIDDEN, however, we need to add it anyways
	add_submenu_page(null, //parent slug
	'Update School', //page title
	'Update', //menu title
	'manage_options', //capability
	'dd_codes_update', //menu slug
	'dd_codes_update'); //function
}

function add_e2_date_picker(){
	//jQuery UI date picker file
	wp_enqueue_script('jquery-ui-datepicker');
	//jQuery UI theme css file
	wp_enqueue_style('e2b-admin-ui-css','http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.0/themes/base/jquery-ui.css',false,"1.9.0",false);
	
}

add_action('admin_enqueue_scripts', 'add_e2_date_picker'); 

define('ROOTDIR', plugin_dir_path(__FILE__));

require_once(ROOTDIR . 'dd_codes-list.php');
require_once(ROOTDIR . 'dd_codes-create.php');
require_once(ROOTDIR . 'dd_codes-update.php');
