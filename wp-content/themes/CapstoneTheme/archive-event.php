<!-- archive-event.php by Thais Vacaflores
Code for the archive of events 
-->

<?php
get_header(); 
?>

<div class="page-banner">
  <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/donovan.jpg')?>);">
  </div>
  <div class="page-banner__content container container--narrow">
    <h1 class="page-banner__title"> All Events</h1>
    <div class="page-banner__intro">
      <p>Find what to do</p>
    </div>
  </div>  
</div>

<!-- Outputs list of all events and their starting date -->
<div class="container container--narrow page-section"> 

  <?php 
  while(have_posts()){
    the_post(); 
  ?>
    <div class="event-summary">
      <a class="event-summary__date t-center" href="<?php the_permalink();?>">
        <span class="event-summary__month">
          <?php
          $eventDate = new DateTime(get_field('event_start'));
          echo $eventDate -> format('M');
          ?>
        </span>
        <span class="event-summary__day"><?php echo $eventDate -> format('d') ;?>
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
          <a href="<?php the_permalink();?>" class="nu gray">Read more</a>
        </p>
      </div>
    </div>

  <?php 
  }
  echo paginate_links();
  ?>
  <hr class= "section-break">
  <p>Check out <a href = "<?php echo site_url('/past-events')?>">past events.</a></p>

</div>

<?php
get_footer();
?>