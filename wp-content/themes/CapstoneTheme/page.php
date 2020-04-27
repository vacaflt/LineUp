 <!-- page.php by Thais Vacaflores
Code for all individual pages
-->

<?php  
get_header();

while(have_posts()) {
	the_post(); 
?>

	<div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/kunsela.jpg')?>);">
    </div>
    <div class="page-banner__content container container--narrow">
      <h1 class="page-banner__title"><?php the_title()?></h1>
      <div class="page-banner__intro">
      </div>
    </div>  
  </div>

  <div class="container container--narrow page-section">

    <!-- gets parent/child page(if any) and displays in a metabox  -->
    <?php
    $theParent = wp_get_post_parent_id(get_the_ID());

    if ($theParent){ 
    ?>
      <div class="metabox metabox--position-up metabox--with-home-link">
        <p><a class="metabox__blog-home-link" href="<?php echo get_permalink($theParent); ?>"><i class="fa fa-home" aria-hidden="true"></i> Back to <?php echo get_the_title($theParent);?> </a><span class="metabox__main"> <?php the_title();?></span></p>
      </div>
    <?php 
    }

    $array = get_pages(array(
      'child_of' => get_the_ID()
    ));

    if($theParent or $array){ 
    ?>
      <div class="page-links">
        <h2 class="page-links__title"><a href="<?php echo get_permalink($theParent); ?>"><?php echo get_the_title($theParent);?></a></h2>
        <ul class="min-list">
    <?php 
    }

    if($theParent){
    
      $findChildren = $theParent;
    } 
    else {
      $findChildren = get_the_ID();
    }
      
      wp_list_pages(array(
        'title_li' => NULL,
        'child_of' => $findChildren
      ));
    ?>
        </ul>
      </div>
<?php 
}

?>
  <!-- Output content of page -->
  <div class="generic-content">
    <?php the_content();?>
  </div>

</div>

<?php

get_footer();

?>