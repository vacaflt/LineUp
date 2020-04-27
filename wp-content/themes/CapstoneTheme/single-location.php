 <!-- Single-location.php by Thais Vacaflores
Code for single locations with Google map
-->

<?php 
get_header();

while(have_posts()){
	the_post(); 
?>
  <div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/donovan.jpg')?>);">
    </div>
    <div class="page-banner__content container container--narrow">
      <h1 class="page-banner__title"><?php the_title();?></h1>
    </div>  
  </div>

  <div class="container container--narrow page-section">

  	<div class="metabox metabox--position-up metabox--with-home-link">
      <p>
        <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('location'); ?>"><i class="fa fa-home" aria-hidden="true"></i>All Locations
        </a> 
        <span class="metabox__main"><?php the_title();?>
        </span>
      </p>
    </div>
    <!-- output Google map for current location -->
  	<div class= "generic-content"><?php the_content();?>
      <div class ="acf-map">
        <?php 
        $mapLocation= get_field('map_location');
        ?>
        <div class= "marker" data-lat="<?php echo $mapLocation['lat'] ?>" data-lng="<?php echo $mapLocation['lng']?>">
          <h3><?php the_title(); ?></h3>
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
      </div>
    </div>
  </div>

<?php
}

get_footer();

?>
