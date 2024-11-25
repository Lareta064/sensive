<?php get_header(); ?>
  <!--================Header Menu Area =================-->
  <main class="site-main">
    <!--================Hero Banner start =================-->
    <section class="mb-30px">
      <div class="container">
        <div class="hero-banner hero-banner--main" style="background-image: url(<?php  the_post_thumbnail_url( ); ?>);">
          <div class="hero-banner__content">
            <h3><?php the_field('sup_title'); ?></h3>
            <h1><?php the_field('main_title'); ?></h1>
            <h4></h4>
          </div>
        </div>
      </div>
    </section>
    <!--================Hero Banner end =================-->

    <!--================ Blog slider start =================-->
    <section>
      <div class="container">
        <div class="owl-carousel owl-theme blog-slider">
           <?php		
              global $post;

              $query = new WP_Query( [
                'posts_per_page' =>  5,
                'post_type' => 'tours'
                
              ] );

              if ( $query->have_posts() ) {
                while ( $query->have_posts() ) {
                  $query->the_post();

            ?>
            <div class="card blog__slide text-center">
              <div class="blog__slide__img">
                <img class="card-img rounded-0" src="<?php  echo  get_the_post_thumbnail_url() ;  ?>" alt="img">
              </div>
              <div class="blog__slide__content">
                <h3><a href="<?php the_permalink( ); ?>"><?php  the_title(); ?></a></h3>
                <p><?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' назад'; ?></p>
              </div>
            </div>
            <?php 
                }
              }
              wp_reset_postdata(); // Сбрасываем $post
              ?>
        </div>
      </div>
    </section>
    <!--================ Blog slider end =================-->

    <!--================ Start Blog Post Area =================-->
    <section class="blog-post-area section-margin mt-4">
      <div class="container">
        <div class="row">
          <div class="col-lg-8">
            
              <?php		
                  global $post;

                  $query = new WP_Query( [
                    'posts_per_page' =>  6,
                    'orderby' => 'rand'
                    
                  ] );

                  if ( $query->have_posts() ) {
                    while ( $query->have_posts() ) {
                      $query->the_post();
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
                          <li><a href="<?php the_permalink(); ?>/#comment-wrapper"><i class="ti-themify-favicon"></i>Комментариев <?php echo get_comments_number(); ?></a></li>
                        </ul>
                      </div>
                      <div class="details mt-20">
                        <a href="<?php the_permalink(); ?>">
                          <h3> <?php the_title(); ?></h3>
                        </a>
                        <p class="tag-list-inline">Категории: <a href="archive.html"><?php the_category('name'); ?></a>
                        <!-- <p class="tag-list-inline">Tag: <a href="archive.html">life style</a>, <a href="archive.html">technology</a>, <a href="archive.html">fashion</a></p> -->
                        <p> <?php the_excerpt(  ); ?></p>
                        <a class="button" href="<?php the_permalink(); ?>">Read More <i class="ti-arrow-right"></i></a>
                      </div>
                    </div>
                <?php 
                }
              }
              wp_reset_postdata(); // Сбрасываем $post
              ?>
           <!-- PAGINATION -->
           
          </div>

          <!-- Start Blog Post Siddebar -->
          <?php get_sidebar(); ?>
          <!-- End Blog Post Siddebar -->
        </div>
    </section>
    <!--================ End Blog Post Area =================-->
  </main>
<?php get_footer(); ?>
