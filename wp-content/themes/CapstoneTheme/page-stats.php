 <!-- page-stats.php by Thais Vacaflores
Code for stats page that displays all information regarding the events for event coordinators
-->

<?php
get_header(); 
?>

<div class="page-banner">
  <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/inside.jpg')?>);">
  </div>
  <div class="page-banner__content container container--narrow">
    <h1 class="page-banner__title">Stats</h1>
    <div class="page-banner__intro">
      <p>Data from all events</p>
    </div>
  </div>  
</div>

<div class="container container--narrow page-section">
  <div class= "generic-content">
    <p><i class= "fas fa-user-friends"></i> Number of users registered for events & sessions
    </br>
    <i class= "fas fa-heart"></i> Number of user likes per session</p>
    </br>
  </div>

  <?php 
  // query to organize all sessions
  $eventSessions = new WP_Query(array(
    'posts_per_page' => -1,
    'post_type' => 'session',
    'meta_key' => 'session_start',
    'orderby' => 'meta_value',
    'order' => 'ASC',
    'meta_query' => array(
      array(
        'key' => 'mandatory',
        'compare' => '!=',
        'value' => true))
  ));

  $eventDate = DateTime::createFromFormat('j-M-Y', '15-Feb-2009');;
  $currentEvent = "";
  $userArray = [];

  while($eventSessions -> have_posts()){

    $eventSessions -> the_post();

    $eventSessionTitle = get_the_title();
    $sessionStartDate = new DateTime(get_field('session_start'));
    $sessionEndDate = new DateTime(get_field('session_end'));
    $postTags = get_the_tags();
    $currentSessionID = get_the_ID();

    $relatedEvent = get_field('related_event')[0]->post_title;
    $currentEventID = get_field('related_event')[0]->ID;

    if($currentEvent != $relatedEvent){
       $currentEvent = $relatedEvent; 
 
//query to get the number of registered users in each event
$registerEvent = new WP_Query(array(
  'posts_per_page' => -1,
  'post_type' => 'register',
  'meta_query' => array(
    array(
      'key' => 'event_id',
      'compare' => '=',
      'value' => $currentEventID))
  ));
  while($registerEvent-> have_posts()){

   $registerEvent -> the_post();

   $author = get_the_author();

   array_push($userArray,$author);
  }
  $uniqueUserArray = array_unique($userArray);    
    ?>
      <div class="event-schedule">
      
      <span class = "event-stats">
        <i class= "fas fa-user-friends"> <?php 
        echo sizeof($uniqueUserArray);
        $userArray = [];
        ?> </i>
      </span>

        <?php echo $currentEvent;?>
      </div>

      <?php
      }

    //query to get all likes from the session
    $likes = new WP_Query(array(
      'posts_per_page' => -1,
      'post_type' => 'like',
      'meta_query' => array(
        array(
          'key' => 'like_id',
          'compare' => '=',
          'value' => $currentSessionID))
    ));
   
    // query to get the number of registered users in each session
    $register = new WP_Query(array(
      'posts_per_page' => -1,
      'post_type' => 'register',
      'meta_query' => array(
        array(
          'key' => 'session_id',
          'compare' => '=',
          'value' => $currentSessionID))
      ));

    // output all event data 
    if($eventDate->format('d') != $sessionStartDate->format('d')){
      $eventDate = $sessionStartDate;
      
    ?>
      <div class="event-date__schedule">
        <?php echo $sessionStartDate -> format('M').' ' .$sessionStartDate -> format('d');?>
      </div>

    <?php
    }
    ?>
  
    <div class="event-summary__stats">

      <a class="session-stats__date t-center">
        <span class = "session-summary__time"> <?php echo $sessionStartDate -> format('G:i') . ' - ' .$sessionEndDate -> format('G:i');?>
        </span> 
      </a>
      <h5 class="event-summary__title headline headline--tiny"><?php echo $eventSessionTitle;?>
      <span class = "session-stats">
        <i class= "fas fa-heart">
        <?php echo $likes-> found_posts;?></i>

        <i class= "fas fa-user-friends">
        <?php 
        echo ($register-> found_posts);
        ?></i>
      </span> 
      </h5>


    </div>
  <?php 
  }
  ?>
</div>


<?php
get_footer();
?>