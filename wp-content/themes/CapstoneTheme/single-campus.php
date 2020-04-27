 <!-- Single-campus.php by Thais Vacaflores
Code for single campuses with Google map that show all locations in current campus
-->

<?php 
get_header();

while(have_posts()) {

	the_post();
  $campusId= get_the_ID();
  $campusTitle= get_the_title(); 
?>
  <div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ork.jpg')?>);">
    </div>
    <div class="page-banner__content container container--narrow">
      <h1 class="page-banner__title"><?php the_title();?></h1>
    </div>  
  </div>

  <div class="container container--narrow page-section">
  
    <div class="metabox metabox--position-up metabox--with-home-link">
      <p>
        <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('campus'); ?>"><i class="fa fa-home" aria-hidden="true"></i>All Campuses</a><span class="metabox__main"><?php the_title();?></span>
      </p>
    </div>
    <?php   
    the_content();

    //query to filter if the location belongs to the current campus
    $campusLocations = new WP_Query(array(
      'posts_per_page' => -1,
      'post_type' => 'location',
      'meta_query' => array(
        array(
          'key' => 'related_campus',
          'compare' => 'LIKE',
          'value' => '"'. get_the_ID().'"'))
    ));
    ?>
    <!-- Output locations in current campus -->
    <div class ="acf-map">
      <?php 
      while($campusLocations -> have_posts()){
        $campusLocations -> the_post();
        $mapLocation= get_field('map_location');
      ?>
        <div class= "marker" data-lat="<?php echo $mapLocation['lat'] ?>" data-lng="<?php echo $mapLocation['lng']?>">
          <a href= "<?php the_permalink(); ?>"><h3><?php the_title(); ?></h3></a>
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
    //query to filter all upcoming events at current campus 
    $today = date('Ymd');
    $campusEvents = new WP_Query(array(
      'posts_per_page' => -1,
      'post_type' => 'event',
      'meta_key' => 'event_start',
      'orderby' => 'meta_value_num',
      'order' => 'ASC',
      'meta_query' => array(
        array(
          'key' => 'event_start',
          'compare' => '>=',
          'value' => $today,
          'type' => 'DATE'),
        array(
          'key' => 'related_campus',
          'compare' => 'LIKE',
          'value' => '"'. $campusId.'"'))
    )); 

    // Output upcoming events with their dates and summaries
    if($campusEvents->have_posts()){
      echo '<hr class= section-break>';
      echo'<h2 class="headline headline--small"> Upcoming ' . $campusTitle . ' Events</h2>';

      while($campusEvents -> have_posts()){
        $campusEvents -> the_post(); 
    ?>
        <div class="event-summary">
          <a class="event-summary__date t-center" href="<?php the_permalink();?>">
            <span class="event-summary__month">
              <?php $eventDate = new DateTime(get_field('event_start'));
              echo $eventDate -> format('M');
              ?>
            </span>
            <span class="event-summary__day"><?php echo $eventDate -> format('d');?>
            </span>
          </a>
          <div class="event-summary__content">
            <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink();?>"><?php the_title();?></a></h5>
            <p>
            <?php 
            if(has_excerpt()){
              echo get_the_excerpt();
            }
            else{
              echo wp_trim_words(get_the_content(), 25);
            }
            ?> 
            <a href="<?php the_permalink();?>" class="nu gray">Read more</a></p>
          </div>
        </div>
      <?php 
      } 
    }

    wp_reset_postdata();
    ?>  
</div>
<?php
}
get_footer();

?>