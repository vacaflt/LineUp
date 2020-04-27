<?php 
 //like-route.php by Thais Vacaflores
 //Route for Like.js
 
add_action('rest_api_init', 'likeRoutes');

function likeRoutes(){

	register_rest_route('v1', 'manageLike', array(
		'methods' => 'POST',
		'callback' => 'createLike'
	));

	register_rest_route('v1', 'manageLike', array(
		'methods' => 'DELETE',
		'callback' => 'deleteLike'
	));

}

function createLike($data){

	if(is_user_logged_in()){

		$session = sanitize_text_field($data['sessionId']);

		$userLike = new WP_Query(array(
			'author' => get_current_user_id(),
			'post_type'=> 'like',
			'meta_query' => array(
				array(
					'key' => 'like_id',
					'compare' => '=',
					'value' => $userLike)) 
		));

			if($userLike -> found_posts == 0 AND get_post_type($session) == 'session'){

				return wp_insert_post(array(
					'post_type' => 'like',
					'post_status' => 'publish',
					'post_title' => 'Like',
					'meta_input' => array(
					'like_id' => $session)
				));

			}
			else{
				die("Invalid ID");
			}
	}
	else{

		die("Please Log In");
	}
}


function deleteLike($data){
	
	$likeId = sanitize_text_field($data['like']);
	
	if(get_current_user_id() == get_post_field('post_author',$likeId) AND get_post_type($likeId)=='like'){

		wp_delete_post($likeId, true);
		return 'Deleted';
	}
	else {
		
		die("Restricted");
	}
}



