<!-- archive-campus.php by Thais Vacaflores
Code for the archive of campuses 
-->

<?php
get_header(); 
?>

<div class="page-banner">
	<div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ork.jpg')?>);">
	</div>
	<div class="page-banner__content container container--narrow">
		<h1 class="page-banner__title"> All Campuses</h1>
	</div>  
</div>

<!-- Outputs list of all campuses -->
<div class="container container--narrow page-section">
	<?php
	while(have_posts()){
			the_post();
	?>
		<ul class= "link-list min-list">
			<li><a href= "<?php echo get_the_permalink($location); ?>"> <?php echo get_the_title($location);?></a></li>
		</ul>
	<?php 
	}
	?>

	<!-- Outputs Google Map with all campuses -->
	<div class ="acf-map">
		<?php 
		while(have_posts()){
			the_post();
			$mapLocation= get_field('map_location_campus');
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
</div>

<?php
get_footer();
?>