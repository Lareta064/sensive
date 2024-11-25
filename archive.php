<?php get_header();?>
<!--MAIN BANNER AREA START -->
<section class="mb-30px">
    <div class="container">
      <div class="hero-banner hero-banner--sm"
	  style="background: url('<?php echo get_bloginfo('template_url');?>/assets/img/banner/archive.jpg') no-repeat center / cover">
        <div class="hero-banner__content">
          <h1>
               <?php 
						
				if( is_category(  ) ){
					echo __('Рубрика: ', 'sensive') .get_queried_object()->name;
				}
				if( is_tag(  ) ){
					echo __('Раздел: ', 'sensive') .get_queried_object()->name;
					}
				if( is_author(  ) ){
					echo '<small>' . __('Все статьи: ', 'sensive') . '</small><br>' .get_the_author_meta( 'display_name');
					}
				if( is_date(  ) ){
					echo '<small>' . __('Статьи от: ', 'sensive') . '</small><br>' .get_the_date( 'j F Y');
					}
					
				else{
					'Архив статей';
				}

			?>

		  </h1>
          <nav aria-label="breadcrumb" class="banner-breadcrumb">
			   <?php if( function_exists('kama_breadcrumbs') ) kama_breadcrumbs(' — '); ?>
            <!-- <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Archive Page</li>
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
        <div class="col-lg-8">
          <div class="row">
            <?php 
				
				if ( have_posts() ) {
					if(count($posts) == 1){
						?>
						
						<div class="single-recent-blog-post card-view">
							<div class="thumb">
							<img class="card-img rounded-0" src="<?php  echo  get_the_post_thumbnail_url() ;  ?>" alt="img">
							<ul class="thumb-info">
								<li><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID'))?>"><i class="ti-user"></i><?php the_author(); ?></a></li>
								<li><a href="<?php the_permalink(); ?>/#comment-wrapper"><i class="ti-themify-favicon"></i><?php echo get_comments_number(); ?> комментариев</a></li>
							</ul>
							</div>
							<div class="details mt-20">
							<a href="<?php the_permalink(); ?>">
								<h3><?php the_title(); ?></h3>
							</a>
							<p><?php the_excerpt(  ); ?></p>
							<a class="button" href="<?php the_permalink(); ?>">Читать <i class="ti-arrow-right"></i></a>
							</div>
						</div>
						<?php 
					}
					else{

					
					while ( have_posts() ) { 
						the_post();
				?>
					<div class="col-md-6">
						<div class="single-recent-blog-post card-view">
							<div class="thumb">
							<img class="card-img rounded-0" src="<?php  echo  get_the_post_thumbnail_url() ;  ?>" alt="img">
							<ul class="thumb-info">
								<li><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID'))?>"><i class="ti-user"></i><?php the_author(); ?></a></li>
								<li><a href="<?php the_permalink(); ?>/#comment-wrapper"><i class="ti-themify-favicon"></i><?php echo get_comments_number(); ?> комментариев</a></li>
							</ul>
							</div>
							<div class="details mt-20">
							<a href="<?php the_permalink(); ?>">
								<h3><?php the_title(); ?></h3>
							</a>
							<p><?php the_excerpt(  ); ?></p>
							<a class="button" href="<?php the_permalink(); ?>">Читать <i class="ti-arrow-right"></i></a>
							</div>
						</div>
					</div>
			<?php 
			      }
				}
			}
			?>
          </div>

          <div class="row">
            <div class="col-lg-12">
                <div class="blog-pagination justify-content-center d-flex">
                    <?php the_posts_pagination(); ?>
                </div>
            </div>
          </div>
        </div>

        <!-- Start Blog Post Siddebar -->
        <?php get_sidebar( ); ?>
        <!-- End Blog Post Siddebar -->
      </div>
  </section>
  <!--================ End Blog Post Area =================-->



<?php get_footer();?>