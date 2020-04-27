<?php 
//functions.php by Thais Vacaflores
//Functions for the site 

//gets paths to route files 
require get_theme_file_path('/inc/like-route.php');
require get_theme_file_path('/inc/register-route.php');
require get_theme_file_path('/inc/major-route.php');
include 'variables.php'; 

//gets style and script files
add_action('wp_enqueue_scripts','files');

function files() {

	if(file_exists(dirname(__FILE__) . '/variables.php')) {
		$googlekey = getenv('googlekey');
	} 
	else {
		$googlekey = getenv('APPSETTING_googlekey');
	}

	wp_enqueue_script('googleMap', '//maps.googleapis.com/maps/api/js?key=' . $googlekey, NULL, 1.0, true);
	wp_enqueue_script('main-js', get_theme_file_uri('/js/scripts-bundled.js'), NULL, microtime(), true);
	wp_enqueue_style('custom_font','//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
	wp_enqueue_style('font-awesome', '//use.fontawesome.com/releases/v5.5.0/css/all.css');
	wp_enqueue_style('main_styles', get_stylesheet_uri(), NULL, microtime());
	wp_localize_script('main-js','capstoneData', array(
		'root_url' => get_site_url(),
		'nonce' => wp_create_nonce('wp_rest')
    ));
}

//gets menus for header and footer
add_action('after_setup_theme','features');

function features() {
	register_nav_menu('headerMenu', 'Header Menu');
	register_nav_menu('footerMenu1', 'Footer Menu 1');
	register_nav_menu('footerMenu2', 'Footer Menu 2');
	add_theme_support('title_tag');
}

//query to order events by date 
add_action('pre_get_posts', 'adjust_queries');

function adjust_queries($query){
	
	//Campus
	if(!is_admin() AND is_post_type_archive('campus') AND $query-> is_main_query()){
		$query -> set('orderby','title');
		$query -> set('order','ASC');
		$query -> set('posts_per_page', -1);
	}
	
	//Event
	if(!is_admin() AND is_post_type_archive('event') AND $query->is_main_query()){
		$today = date('Ymd');
		$query -> set('meta_key', 'event_start');
		$query -> set('orderby','meta_value_num');
		$query -> set('order','ASC');
		$query -> set('meta_query',array(
            array(
              'key' => 'event_start',
              'compare' => '>=',
              'value' => $today,
              'type' => 'numeric')
        ));
	}
}


//Redirect subscriber
add_action('admin_init', 'redirectSubs');

function redirectSubs(){
	$currentUser = wp_get_current_user();
	
	if(count($currentUser-> roles) == 1 AND $currentUser->roles[0] == 'subscriber') {
		wp_redirect(site_url('/'));
		exit;
	}
}


//Remove admin bar
add_action('wp_loaded', 'removeAdminBar');

function removeAdminBar(){
	$currentUser = wp_get_current_user();
	
	if(count($currentUser-> roles) == 1 AND $currentUser->roles[0] == 'subscriber') {
		show_admin_bar(false);
	}
}


//Customize login screen
add_filter('login_headerurl', 'headerUrl');

function headerUrl(){
	
	return esc_url(site_url('/'));
}


//customize login font 
add_action('login_enqueue_scripts', 'login');

function login(){

	wp_enqueue_style('main_styles', get_stylesheet_uri());
	wp_enqueue_style('custom_font','//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');

}


//header title for login page
add_filter('login_headertitle', 'loginTitle');

function loginTitle(){

	return get_bloginfo('name');
}

//Google API for maps
add_filter('acf/fields/google_map/api', 'mapKey');

function mapKey($api){

	if(file_exists(dirname(__FILE__) . '/variables.php')) {
		$googlekey = getenv('googlekey');
	} 
	else {
		$googlekey = getenv('APPSETTING_googlekey');
	}

	$api['key'] = $googlekey;
	return $api;

}


//restricts access to only @sunypoly.edu emails
add_action('register_post', 'is_valid_email_domain',10,3 );

function is_valid_email_domain($login, $email, $errors ){
 	$valid_email_domains = array("sunypoly.edu", "sunypoly.edu");
 	$valid = false; 
 	foreach( $valid_email_domains as $d ){
  		$d_length = strlen( $d );
  		$current_email_domain = strtolower( substr( $email, -($d_length), $d_length));
 		if( $current_email_domain == strtolower($d) ){
  			$valid = true;
  			break;
 		}
 	}

 	if( $valid === false ){

		$errors->add('domain_whitelist_error',__( '<strong>ERROR</strong>: Registration is only allowed from selected approved domains.' ));
 	}
}












?>