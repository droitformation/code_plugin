<?php
/*
	Plugin Name: Code d'accès
	Description: Gestion des codes d'accès au site droit pour le praticien
	Version: 1
	Author:@designpond
	Author URI: http://designpond.ch
*/

require_once( plugin_dir_path( __FILE__ ) . 'bootstrap.php' );

//menu items
add_action('admin_menu','dd_codes_modifymenu');

function dd_codes_modifymenu() {
	
	//this is the main item for the menu
	add_menu_page('Codes d\'accès', //page title
	'Codes d\'accès', //menu title
	'manage_options', //capabilities
	'dd_codes_list', //menu slug
	'dd_codes_list' //function
	);
	
	//this is a submenu
	add_submenu_page('dd_codes_list', //parent slug
	'Ajouter un code', //page title
	'Ajouter un code', //menu title
	'manage_options', //capability
	'dd_codes_create', //menu slug
	'dd_codes_create'); //function

    //this is a submenu
    add_submenu_page('dd_codes_import', //parent slug
    'Importer des codes', //page title
    'Importer des codes', //menu title
    'manage_options', //capability
    'dd_codes_import', //menu slug
    'dd_codes_import'); //function

	//this submenu is HIDDEN, however, we need to add it anyways
	add_submenu_page(null, //parent slug
	'Mettre à jour le code', //page title
	'Mettre à jour', //menu title
	'manage_options', //capability
	'dd_codes_update', //menu slug
	'dd_codes_update'); //function
}

function add_e2_date_picker(){
	//jQuery UI date picker file
	wp_enqueue_script('jquery-ui-datepicker');
	//wp_enqueue_script('suggest');
	wp_enqueue_script( 'jquery-ui-autocomplete' );
	//jQuery UI theme css file
	wp_enqueue_style('e2b-admin-ui-css','http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.0/themes/base/jquery-ui.css',false,"1.9.0",false);
	
}

add_action('admin_enqueue_scripts', 'add_e2_date_picker'); 

add_action('wp_ajax_wpgetall-users', 'ajaxAllUser');
add_action('wp_ajax_nopriv_wpgetall-users', 'ajaxAllUser');

function ajaxAllUser() {

	$search_string = esc_attr( trim($_GET['term']) );
	
	$users = new WP_User_Query( array(
	    'meta_query' => array(
	        'relation' => 'OR',
	        array(
	            'key'     => 'first_name',
	            'value'   => $search_string,
	            'compare' => 'LIKE'
	        ),
	        array(
	            'key'     => 'last_name',
	            'value'   => $search_string,
	            'compare' => 'LIKE'
	        )
	    )
	));
	
	$results = $users->get_results();

	if(!empty($results))
	{
		foreach($results as $user)
		{
			$user_info  = get_userdata($user->id);
	        
	        $name = $user_info->first_name.' '.$user_info->last_name;
			        
			$suggestions[$user->id]['label'] = $name;
			$suggestions[$user->id]['value'] = $user->id;
		}
	}
	else
	{
		$suggestions['label'] = 'Aucun résultat';
	}
	
	$response = json_encode( $suggestions );
	
	echo $response;
	
	exit();
    
}

define('ROOTDIR', plugin_dir_path(__FILE__));

add_action('init', 'do_output_buffer');

function do_output_buffer() {
    ob_start();
}

require_once(ROOTDIR . 'dd_codes-list.php');
require_once(ROOTDIR . 'dd_codes-create.php');
require_once(ROOTDIR . 'dd_codes-update.php');
require_once(ROOTDIR . 'dd_codes-import.php');
