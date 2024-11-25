<?php
 	/*Template name: Шаблон страницы Блог*/
	get_header();
 ?>


  <!--================ Hero sm Banner start =================-->    
  <section class="mb-30px">
    <div class="container">
      <div class="hero-banner hero-banner--sm" 	  
	    	style="background: url('<?php echo get_bloginfo('template_url');?>/assets/img/banner/kek.jpg') no-repeat center / cover">
        <div class="hero-banner__content">
          <h1>Блог</h1>
          <nav aria-label="breadcrumb" class="banner-breadcrumb">
             <?php if( function_exists('kama_breadcrumbs') ) kama_breadcrumbs(' — '); ?>
            
          </nav>
        </div>
      </div>
    </div>
  </section>
  <!--================ Hero sm Banner end =================-->    

  <!--================ Start Blog Post Area =================-->
  <?php echo get_template_part( 'template-parts/content', 'page'); ?>

  <!--================ End Blog Post Area =================-->
<?php get_header(); ?>