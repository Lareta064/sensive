<?php 
	/* tem*/
	get_header();
 ?>
<section class="mb-30px">
	<div class="container">
	  <div class="hero-banner hero-banner--sm" 	  
	 	style="background: url(
        <?php
            if(has_post_thumbnail())
            the_post_thumbnail_url( )
        ?>) no-repeat center / cover">

		<div class="hero-banner__content">
		  <h1><?php the_title();?></h1>
		  <nav aria-label="breadcrumb" class="banner-breadcrumb">
			   <?php if( function_exists('kama_breadcrumbs') ) kama_breadcrumbs(' — '); ?>
			<!-- <ol class="breadcrumb">
			  <li class="breadcrumb-item"><a href="#">Home</a></li>
			  <li class="breadcrumb-item"><a href="blog.html">Blog</a></li>
			  <li class="breadcrumb-item active" aria-current="page">Blog Details</li>
			</ol> -->
		  </nav>
		</div>
	  </div>
	</div>
  </section>
  <!--================ Hero sm Banner end =================-->    

  <!--================ Start Blog Post Area =================-->
  <section class="blog-post-area section-margin">
	<div class="container">
	  <div class="row">
			<main class="col-lg-8">
				<?php
					while ( have_posts() ) :
						
						the_post();

						// get_template_part( 'template-parts/content', get_post_type(	) );
						get_template_part( 'template-parts/content', "post" );


						// If comments are open or we have at least one comment, load up the comment template.

						?>
						<div class="comment-wrapper" id="comment-wrapper">

						
						<?php

						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;

					endwhile; // End of the loop.
					?>
					</div>
					<!-- <?php the_posts_pagination(); ?> -->
			</main>

		
		<!-- Start Blog Post Siddebar -->
			<?php get_sidebar( ); ?>

		</div><!--row-->
     </div> <!--container--> 
  </section>
  <!--================ End Blog Post Area =================-->



 <?php 	
	get_footer();
 ?>