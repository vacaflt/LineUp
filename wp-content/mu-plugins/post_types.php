<?php 
//post-types.php by Thais Vacaflores
//Creates custom post types

function post_types(){
//Event
	register_post_type('event', array(
		'capability_type' => 'event',
		'map_meta_cap' => true,
        'supports' => array('title', 'editor', 'excerpt'),
		'rewrite' => array('slug' => 'events'),
		'has_archive' => true,
		'public' => true,
		'labels' => array(
		'name' => 'Events',
        'add_new_item' => 'Add New Event',
        'edit_item' => 'Edit Event',
        'all_items' => 'All Events',
        'singular_event' => 'Event'),
		'menu_icon' => 'dashicons-calendar-alt',
	));

//Campus
	register_post_type('campus', array(
		'capability_type' => 'campus',
		'map_meta_cap' => true,
        'supports' => array('title', 'editor'),
		'rewrite' => array('slug' => 'campuses'),
		'has_archive' => true,
		'public' => true,
		'labels' => array(
		'name' => 'Campuses',
        'add_new_item' => 'Add New Campus',
        'edit_item' => 'Edit Campuses',
        'all_items' => 'All Campuses',
        'singular_event' => 'Campus'),
		'menu_icon' => 'dashicons-admin-home',
	));

//Session
	register_post_type('session', array(
		'capability_type' => 'session',
		'map_meta_cap' => true,
		'taxonomies' => array('category', 'post_tag'),
        'supports' => array('title', 'editor','excerpt'),
		'rewrite' => array('slug' => 'sessions'),
		'has_archive' => true,
		'public' => true,
		'labels' => array(
		'name' => 'Sessions',
        'add_new_item' => 'Add New Session',
        'edit_item' => 'Edit Session',
        'all_items' => 'All Sessions',
        'singular_event' => 'Session'),
		'menu_icon' => 'dashicons-clipboard',
	));

//Location
	register_post_type('location', array(
		'capability_type' => 'location',
		'map_meta_cap' => true,
        'supports' => array('title', 'editor'),
		'rewrite' => array('slug' => 'locations'),
		'has_archive' => true,
		'public' => true,
		'labels' => array(
		'name' => 'Locations',
        'add_new_item' => 'Add New Location',
        'edit_item' => 'Edit Location',
        'all_items' => 'All Locations',
        'singular_event' => 'Location'),
		'menu_icon' => 'dashicons-admin-site',
	));

//Registration
	register_post_type('register', array(
		'capability_type' => 'register',
		'map_meta_cap' => true,
        'suppports' => array('title'),
		'public' => false,
		'show_ui' => true,
		'labels' => array(
		'name' => 'Register',
		'add_new_item' => 'Add New Registration',
		'edit_item' => 'Edit Registration',        
		'all_items' => 'All Registrations',
		'singular_name' => 'Registration'),
		'menu_icon' => 'dashicons-editor-ul',
	));

//Like
	register_post_type('like', array(
		'capability_type' => 'like',
		'map_meta_cap' => true,
		'suppports' => array('title'),
		'public' => false,
		'show_ui' => true,
		'labels' => array(
		'name' => 'Likes',
		'add_new_item' => 'Add New Like',
		'edit_item' => 'Edit Like',        
		'all_items' => 'All Likes',
		'singular_name' => 'Like'),
		'menu_icon' => 'dashicons-heart'
	));

//Major
	register_post_type('major', array(
		'capability_type' => 'major',
		'map_meta_cap' => true,
		'suppports' => array('title'),
		'public' => false,
		'show_ui' => true,
		'labels' => array(
		'name' => 'Majors',
		'add_new_item' => 'Add New Major',
		'edit_item' => 'Edit Major',        
		'all_items' => 'All Majors',
		'singular_name' => 'Major'),
		'menu_icon' => 'dashicons-businessperson'
	));

}
add_action('init','post_types');



?>
