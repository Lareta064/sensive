<?php get_header();?>


<section class="mb-30px">
    <div class="container">
      <div class="hero-banner hero-banner--sm" 	  
	    	style="background: url(
        <?php
            the_post_thumbnail_url( );
        ?>) no-repeat center / cover">
        <div class="hero-banner__content">
          <h1><?php
				/* translators: %s: search query. */
				printf( esc_html__( 'Результат поиска: %s', 'sensive' ), '<p class="search-phrase">' . get_search_query() . '</p>' );
				?>
			</h1>
          <nav aria-label="breadcrumb" class="banner-breadcrumb">
			   <?php if( function_exists('kama_breadcrumbs') ) kama_breadcrumbs(' — '); ?>
            
          </nav>
        </div>
      </div>
    </div>
</section>
<section class="blog-post-area section-margin mt-4">
    <div class="container">
        <div class="row">
			
            <div class="col-lg-8">
				<?php if ( have_posts() ) {
					while ( have_posts() ) { 
						the_post();
				?>

				<div class="single-recent-blog-post">
					<div class="thumb">
						<img class="img-fluid" src="<?php  echo  get_the_post_thumbnail_url() ;  ?>" alt="">
						<ul class="thumb-info">
							<li><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID'))?>"><i class="ti-user"></i><?php the_author(); ?></a></li>
							<li><a href="<?php 
                          $archive_year  = get_the_time( 'Y' ); 
                          $archive_month = get_the_time( 'm' ); 
                          $archive_day   = get_the_time( 'd' ); 
                          echo esc_url( get_day_link( $archive_year, $archive_month, $archive_day ) ); 
                          ?>"><i class="ti-notepad"></i><?php the_time(' j F Y'); ?></a></li>
							<li><a href="#"><i class="ti-themify-favicon"></i>комментариев <?php echo get_comments_number(); ?></a></li>
						</ul>
					</div>
					<div class="details mt-20">
						<a href="<?php the_permalink(); ?>">
							<h3> <?php the_title(); ?></h3>
						</a>
						<p class="tag-list-inline">Категории:
							<a href="archive.html"><?php the_category('name'); ?></a>
						</p>
					    <!-- <p class="tag-list-inline">Tag: 
							<a href="archive.html">life style</a>, 
							<a href="archive.html">technology</a>, 
							<a href="archive.html">fashion</a>
						</p> -->
					   <p> <?php the_excerpt(  ); ?></p>
					   <a class="button" href="<?php the_permalink(); ?>">Читать 
					   		<i class="ti-arrow-right"></i>
						</a>
					</div>
				</div>
				<?php
					}
				} else{
					?>
					<h2 class="error-notify"> К сожалению, ничего не найдено<br>
				Попробуйте изенить запрос</h2>
					<?php
				}
				?>
			</div>
			<!-- Start Blog Post Siddebar -->
			<?php get_sidebar( ); ?>
			<!-- End Blog Post Siddebar -->
		</div>
	</div>
</section>
<?php get_footer(); ?>