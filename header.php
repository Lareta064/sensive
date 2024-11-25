<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  
  <link rel="icon" href="<?php  echo  get_bloginfo('template_url');?>/assets/img/Fevicon.png" type="image/png">

   <?php wp_head(); ?>
  
</head>
<body>
  <!--================Header Menu Area =================-->
  <header class="header_area">
    <div class="main_menu">
      <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container box_1620">
          <!-- Brand and toggle get grouped for better mobile display -->
         
			<?php
			if( $logo = get_custom_logo() ){
				echo $logo;
			}
		?>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
			  <?php
				
			  wp_nav_menu([
				'theme_location'  => 'header',
				'container'       => false,
				'menu_class'      => 'nav navbar-nav menu_nav justify-content-center',
				'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
				'depth'           => 1,
				'walker'          => new bootstrap_4_walker_nav_menu()
				
				]);
			 
			 ?>
            
			<!-- Динамичный вывод иконок соцсетей -->
            <ul class="nav navbar-nav navbar-right navbar-social">
				<?php		
					global $post;

					$query = new WP_Query( [
						'posts_per_page' =>  4,
						'post_type'        => 'social',
						'order'           =>'ASC'
					] );

					if ( $query->have_posts() ) {
						while ( $query->have_posts() ) {
						$query->the_post();
						?>
						  <li><a href="<?php the_field('soc_link'); ?>"><?php the_field('soc_icon'); ?></a></li>
						<?php 
						}
					}
					wp_reset_postdata(); // Сбрасываем $post
              	?>
            </ul>
          </div> 
        </div>
      </nav>
    </div>
  </header>