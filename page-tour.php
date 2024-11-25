<?php 
/*Template name: Шаблон Туры*/


get_header(); ?>


  <!--================ Hero sm Banner start =================-->    
    <!--================ Hero sm Banner start =================-->    
  <section class="mb-30px">
    <div class="container">
      <div class="hero-banner hero-banner--sm" 	  
        style="background: url(
            <?php
                if(has_post_thumbnail())
                the_post_thumbnail_url( )
            ?>) no-repeat center / cover">
        <div class="hero-banner__content">
          <h1><?php the_title(); ?></h1>
          <nav aria-label="breadcrumb" class="banner-breadcrumb">
            <?php if( function_exists('kama_breadcrumbs') ) kama_breadcrumbs(' — '); ?>
            
          </nav>
        </div>
      </div>
    </div>
  </section>
  <!--================ Hero sm Banner end =================-->  
  <!--================ Hero sm Banner end =================-->    

  <!--================ Start Blog Post Area =================-->
 <?php echo get_template_part( 'template-parts/content', 'tour'); ?>
  <!--================ End Blog Post Area =================-->

  <!--================ Start Footer Area =================-->
  <?php get_footer();?>