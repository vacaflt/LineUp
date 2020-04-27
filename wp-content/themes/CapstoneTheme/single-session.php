<!-- Single-session.php by Thais Vacaflores
Code for single session posts
-->

<?php 

get_header();
 
while(have_posts()){ 
	the_post(); 

?>
  <div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/walter.jpeg')?>);">
    </div>
    <div class="page-banner__content container container--narrow">
      <h1 class="page-banner__title"><?php the_title();?></h1>
      <div class="page-banner__intro">
        <p><?php echo get_field('session_start') . ' - ' . get_field('session_end');?></p>
      </div>
    </div>  
  </div>

  <div class="container container--narrow page-section">
    
    <div class="metabox metabox--position-up metabox--with-home-link">
    	<p>
        <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('session'); ?>"><i class="fa fa-home" aria-hidden="true"></i> My Schedule 
        </a> 
        <span class="metabox__main"><?php the_title();?>
        </span>
      </p>
    </div>

  	<div class= "generic-content">
    
    <?php
      //query to filter if the like_id belongs to the current session
      $likeCount = new WP_Query(array(
        'post_type'=> 'like',
        'meta_query' => array(
          array(
            'key' => 'like_id',
            'compare' => '=',
            'value' => get_the_ID())) 
      ));

      $likeStatus = 'no';

      if(is_user_logged_in()){
        
      //query to determine if the like_id belongs to the current user
        $userLike = new WP_Query(array(
          'author' => get_current_user_id(),
          'post_type'=> 'like',
          'meta_query' => array(
            array(
              'key' => 'like_id',
              'compare' => '=',
              'value' => get_the_ID())) 
        ));

        if($userLike -> found_posts){
          $likeStatus = 'yes';
        }
      }
    ?>
    <!-- output like box -->
      <div class="tooltip"> 
        <span class = "like-box" data-like= "<?php echo $userLike -> posts[0]->ID;  ?>" data-session= "<?php the_ID();?>"data-exists = "<?php echo $likeStatus;?>" > 
          <i class= "far fa-heart" type="empty" aria-hidden= "true"></i> <span class="tooltiptext">Like?</span>
          <i class= "fas fa-heart" type="fill" aria-hidden= "true"></i> <span class="tooltiptext">Like?</span>
          <span class= "like-count"><?php echo $likeCount -> found_posts; ?>
          </span>
        </span>
      </div>
      
      <?php
      //output major (if any) and session content 
      $postTags = get_the_tags();   
      if ($postTags) {
        echo "Major: " . $postTags[0]->name; 
      }

      the_content();
      ?> 
    </div>
    <?php 
    
    $locationID = get_field('related_location')[0]->ID;   
    $relatedLocation = get_field('related_location');

    //query to determine the location of the current session 
    $sessionLocations = new WP_Query(array(
      'posts_per_page' => -1,
      'post_type' => 'location',
      'post__in' => array($locationID) 
    ));

    if($relatedLocation){
      echo '<hr class="section-break">';
      echo'<h2 class="headline headline--small">Location</h2>';
      echo '<ul class= "link-list min-list">';
      
      foreach($relatedLocation as $location){ ?>

        <li><a href= "<?php echo get_the_permalink($location); ?>"> <?php echo get_the_title($location);?></a></li>
        <!-- output Google map of Location  -->
        <div class ="acf-map">
          <?php 
          while($sessionLocations -> have_posts()){
            $sessionLocations -> the_post();
            $mapLocation= get_field('map_location');
          ?>
            <div class= "marker" data-lat="<?php echo $mapLocation['lat'] ?>" data-lng="<?php echo $mapLocation['lng']?>">
              <a href= "<?php the_permalink(); ?>"><h3>
                <?php the_title(); ?></h3>
              </a>
              <?php 
              echo $mapLocation['address']; 
              $target = str_replace(' ','+',$mapLocation['address']);
              $fullTarget = "https://www.google.com/maps/dir/?api=1&origin=current+location&destination=" . $target . "&travelmode=walking";
              ?>
              <p>
                <a class="directions-box" href="<?php echo $fullTarget ?>" target="_blank">
                <i class="fas fa-route fa-lg"></i>  Get Directions in Google Maps</a>
              </p>
          </div>
        <?php 
        }
      ?>
        </div>

      <?php 
      }
      echo '</ul>';
    }
      ?>
    
    </div>
  </div>

 

<?php
}

get_footer();

?>