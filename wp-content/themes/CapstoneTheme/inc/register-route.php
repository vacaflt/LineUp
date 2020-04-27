<?php 
//register-route.php by Thais Vacaflores
//Route for Register.js



add_action('rest_api_init', 'registerRoutes');

function registerRoutes(){

	register_rest_route('v1', 'manageRegister', array(
		'methods' => 'POST',
		'callback' => 'createRegister'
	));

	register_rest_route('v1', 'manageRegister', array(
		'methods' => 'DELETE',
		'callback' => 'deleteRegister'
	));

}

function createRegister($data){

	if(is_user_logged_in()){
		$session = sanitize_text_field($data['sessionId']);
		$event = sanitize_text_field($data['eventId']);

		//User Registered to event
		$userRegister = new WP_Query(array(
			'author' => get_current_user_id(),
			'post_type'=> 'register',
			'meta_query' => array(
				array(
					'key' => 'session_id',
					'compare' => '=',
					'value' => $userRegister)) 
		));

			if($userRegister -> found_posts == 0 AND get_post_type($session) == 'session'){

				return wp_insert_post(array(
					'post_type' => 'register',
					'post_status' => 'publish',
					'post_title' => 'Register',
					'meta_input' => array(
					'session_id' => $session,
					'event_id' => $event)
				));
			}
			else{

				die("Invalid ID");
			}
	}
	else{
		header("Location: http://mysite.local/wp-login.php");
		die("Please Log In");
	}
}


function deleteRegister($data){
	
	$registerId = sanitize_text_field($data['register']);
	
	if(get_current_user_id() == get_post_field('post_author',$registerId) AND get_post_type($registerId)=='register'){

		wp_delete_post($registerId, true);
		return 'Deleted';
	}
	else {
		
		die("Restricted");
	}
}



