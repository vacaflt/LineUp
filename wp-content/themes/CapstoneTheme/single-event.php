 <!-- Single-event.php by Thais Vacaflores
Code for single events along with sessions and register boxes
--> 

<?php 
get_header(); 

//get the current user 
$currentUser = wp_get_current_user();
$theMajor = get_user_meta($currentUser->ID, 'major', true)[0];

//query to get the current major
$currentMajor = new WP_Query(array(
  'posts_per_page' => -1,
  'post_type' => 'major', 
  'post__in' => array($theMajor) 
));

while($currentMajor -> have_posts()) { 
  $currentMajor -> the_post(); 
  $userMajor = get_the_title();
}

//Output current event title, date and content
while(have_posts()) { 
  the_post(); 
  $eventId = get_the_ID();
  ?>

  <div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/donovan.jpg')?>);">
    </div>
    <div class="page-banner__content container container--narrow">
      <h1 class="page-banner__title"><?php the_title();?></h1>
      <div class="page-banner__intro">
        <p><?php echo get_field('event_start') . ' - ' . get_field('event_end'); ?></p>
      </div>
    </div>  
  </div>

  <div class="container container--narrow page-section">

    <div class="metabox metabox--position-up metabox--with-home-link">
      <p>
        <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('event'); ?>"><i class="fa fa-home" aria-hidden="true"></i>   Events Home 
        </a> 
        <span class="metabox__main"><?php the_title();?>
        </span>
      </p>
    </div>
    <div class= "generic-content"><?php the_content();?>  
    </div>
  <?php 
  $relatedCampus = get_field('related_campus');
} 
?>
  <hr class= "section-break">
  <h2 class="headline headline--small">Sessions</h2>  
  <?php

  //query to filter all sessions for the event 
  $eventSessions = new WP_Query(array(
    'posts_per_page' => -1,
    'post_type' => 'session',
    'meta_key' => 'session_start',
    'orderby' => 'meta_value',
    'order' => 'ASC',
    'meta_query' => array(
      array(
        'key' => 'related_event',
        'compare' => 'LIKE',
        'value' => '"'. get_the_ID().'"'))
  ));

  if(is_user_logged_in() == false){
  ?>
    <div class="login_prompt">
      <?php echo 'Log In to register to sessions';?>
    </div>
  <?php
  }

  $eventDate = DateTime::createFromFormat('j-M-Y', '15-Feb-2009');
    $banner = false;

    while($eventSessions -> have_posts()){

      $eventSessions -> the_post();

      $postTags = get_the_tags();
      $hasTag = has_tag();
      $sessionStartTime = new DateTime(get_field('session_start'));
      $sessionEndTime = new DateTime(get_field('session_end'));
      $sessionTitle = get_the_title();
      $sessionContent = get_the_content();
      $sessionID = get_the_ID();
      $sessionPermalink = get_the_permalink();
      $sessionMandatory = get_field('mandatory');
      $sessionTime = get_field('session_start');

      //gets all the sessions, sessions for the major, mandatory sessions 
      if(($sessionMandatory AND !$hasTag) OR ($sessionMandatory AND $postTags[0]->name == $userMajor) OR !$sessionMandatory){
        
        //query to get same time sessions 
        $sameTimeSessions = new WP_Query(array(
          'posts_per_page' => -1,
          'post_type' => 'session',
        ));

        //gets same time sessions and overlap
        $count = 0;
        $overlap = false;
        while($sameTimeSessions -> have_posts()){
          $sameTimeSessions -> the_post();

          if(get_field('session_start')==$sessionTime){
            $count++;
            if($count>1) {
              $overlap = true;
              break;
            }
          }
        }

        if($overlap == true AND !$hasTag AND $banner == false){
        ?>
          <div class="event-date__overlap">
            <?php 
              echo 'Select one of the following';
              $banner = true;
            ?>
          </div>
        <?php
        } 

        if($eventDate->format('Ymd') != $sessionStartTime->format('Ymd')){
          $eventDate = $sessionStartTime;
        ?>
          <div class="event-date">
            <?php echo $sessionStartTime -> format('M').' ' .$sessionStartTime -> format('d');?>
          </div>
        <?php
        }
        
        //checks if user is logged in and checks registration status 
        $registerStatus = 'no';
        if(is_user_logged_in()){
          
          $userRegister = new WP_Query(array(
            'author' => get_current_user_id(),
            'post_type'=> 'register',
            'meta_query' => array(
              array(
                'key' => 'session_id',
                'compare' => '=',
                'value' => $sessionID)) 
          ));

          if($userRegister -> found_posts){
            $registerStatus = 'yes';
          }
        }

        //outputs all sessions in date order 
        $today = date('Ymd');
        ?>
        <div class="event-summary<?php if($overlap AND !$hasTag) echo '__overlap'; ?>">
          <?php
          if($today < $eventDate -> format('Ymd')){
          ?>
          <!-- Outputs register boxes -->
            <span class="register-box">    
              <?php
                if($sessionMandatory){
                ?>
                  <div class="tooltip">
                    <i class="far fa-check-square fa-2x" type="mandatory"></i>
                    <span class="tooltiptext">Mandatory</span>
                  </div>
                <?php
                }
                else {
                  if($registerStatus == 'yes'){
                    ?>
                      <i class="far fa-check-square fa-2x" data-register="<?php echo $userRegister->posts[0]->ID;?>" 
                        data-session="<?php echo $sessionID;?>" data-event="<?php echo 'eventId';?>" type="registered">    
                      </i>
                  <?php
                  } 
                  else{
                    ?>
                    <div class="tooltip">
                      <i class="far fa-square fa-2x" data-register="<?php echo $userRegister->posts[0]->ID;?>" 
                        data-session="<?php echo $sessionID;?>" data-event="<?php echo $eventId;?>"type="empty">
                      </i>
                      <span class="tooltiptext">Register?</span>
                    </div>
                    <?php 
                  }
                }
                ?>
            </span>
          <?php
          }
          ?>
          <!-- outputs all sessions data -->
          <a class="session-summary__date t-center" href="<?php echo $sessionPermalink;?>">
            <span class="session-summary__day">
            </span>
            <span class = "session-summary__time"> <?php echo $sessionStartTime -> format('G:i') . ' - ' .$sessionEndTime -> format('G:i');?>
            </span> 
          </a>
            <h5 class="event-summary__title headline headline--tiny"><a  href="<?php echo $sessionPermalink;?>"><?php echo $sessionTitle;?></a></h5>
            <?php   
            if ($postTags) {
              echo "Major: " . $postTags[0]->name; 
            }
            ?>
            <p><?php echo wp_trim_words($sessionContent, 25)?> <a href="<?php echo $sessionPermalink;?>" class="nu gray">Read more</a></p>
        </div>
        <?php 
      }
      if(!$overlap){
        $banner = false;
      }
    }
   
    //Outputs the hosting campus
    if($relatedCampus){
      echo '<hr class="section-break">';
      echo'<h2 class="headline headline--small">Hosting Campus</h2>';
      echo '<ul class= "link-list min-list">';
    
      foreach($relatedCampus as $campus){ 
    ?>
      <li><a href= "<?php echo get_the_permalink($campus); ?>"> <?php echo get_the_title($campus);?></a></li>
    <?php 
      }
    echo '</ul>';
    }
    ?>
  </div>
<?php
get_footer();
?>