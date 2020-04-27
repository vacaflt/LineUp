<!-- page-myschedule.php by Thais Vacaflores
Code for the archive of events 
-->

<?php
get_header();
?>

<div class="page-banner">
  <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/walter.jpeg')?>);">
  </div>
  <div class="page-banner__content container container--narrow">
    <h1 class="page-banner__title"> My Schedule</h1>
    <d iv class="page-banner__intro">
      <p>Sessions You Signed Up For</p>
  </div>
</div> 

<div class="container container--narrow page-section">
  
  <?php
  //gets current user
  $currentUser = wp_get_current_user();

  //query to filter the current major
  $theMajor = get_user_meta($currentUser->ID, 'major', true)[0]; 
  $currentMajor = new WP_Query(array(
    'posts_per_page' => -1,
    'post_type' => 'major', 
    'post__in' => array($theMajor) 
  ));

  while($currentMajor -> have_posts()) { 
    $currentMajor -> the_post(); 
    $userMajor = get_the_title();
  }

  //query to filter out past events
  $today = date('Ymd', strtotime('-1 day'));
  
  $eventSessions = new WP_Query(array(
    'posts_per_page' => -1,
    'post_type' => 'session',
    'meta_key' => 'session_start',
    'orderby' => 'meta_value',
    'order' => 'ASC',
    'meta_query' => array(
      array(
        'key' => 'session_start',
        'compare' => '>=',
        'value' => $today,
        'type' => 'DATETIME'))
  ));

  $eventDate = DateTime::createFromFormat('j-M-Y', '15-Feb-2009');;
  $currentEvent = "";

  while($eventSessions -> have_posts()){

    $eventSessions -> the_post();

    $hasTag = has_tag(); 
    $postTags = get_the_tags();
    $registerEventStatus = 'no';
    $registerStatus = 'no';

    //query to filter if there are sessions registered in the event 
    $sessionEvent =  get_field('related_event')[0]->ID;

    $registerEvent = new WP_Query(array(
      'author' => get_current_user_id(),
      'post_type' => 'register',
      'meta_query' => array(
        array(
          'key' => 'event_id',
          'compare' => '=',
          'value' => $sessionEvent))
    ));

    if($registerEvent -> found_posts){

          $registerEventStatus = 'yes';
    }

    //query to filter if the session is registered 
    $registerSession = new WP_Query(array(
      'author' => get_current_user_id(),
      'post_type' => 'register',
      'meta_query' => array(
        array(
          'key' => 'session_id',
          'compare' => '=',
          'value' => get_the_ID()))
    ));

    if($registerSession -> found_posts){

          $registerStatus = 'yes';
    }

  
    //Outputs events and sessions the user has registered to 
    if(($registerStatus == 'yes' AND $registerEventStatus == 'yes') OR (get_field('mandatory') AND $registerEventStatus == 'yes' AND !$hasTag) OR ($postTags[0]->name == $userMajor AND $registerEventStatus == 'yes')){

      $relatedEvent = get_field('related_event')[0]->post_title;
      
      if($currentEvent != $relatedEvent){
        $currentEvent = $relatedEvent;    
        ?>
        <div class="event-schedule">
          <?php echo $currentEvent;?>
        </div>
      <?php
      }

      $sessionDate = new DateTime(get_field('session_start'));
      $sessionEndDate = new DateTime(get_field('session_end'));

      if($eventDate->format('d') != $sessionDate->format('d')){
        $eventDate = $sessionDate;
      ?>
        <div class="event-date__schedule">
          <?php echo $sessionDate -> format('M').' ' .$sessionDate -> format('d');?>
        </div>
      <?php
      }
      ?>
    
      <div class="event-summary">
        <a class="session-summary__date t-center" href="<?php the_permalink();?>">
          <span class="session-summary__day">
          </span>
          <span class = "session-summary__time"> <?php echo $sessionDate -> format('G:i') . ' - ' .$sessionEndDate -> format('G:i');?>
          </span> 
        </a>
          <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink();?>"><?php the_title();?></a></h5>
          <?php   
          if ($postTags) {
            echo '<span style="color:#3983a8;">Major: </span> '. $postTags[0]->name; 
          }
          ?>
          <p><?php echo wp_trim_words(get_the_content(), 25)?> <a href="<?php the_permalink();?>" class="nu gray">Read more</a></p>
      </div>
    <?php 
    }
  }
?>
<p>Check out the <a href = "<?php echo get_post_type_archive_link('event')?>">upcoming events.</a></p>
</div>



<?php 
get_footer();
?>