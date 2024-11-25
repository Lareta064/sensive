  <!--================ Start Footer Area =================-->
  <footer class="footer-area section-padding">
    <div class="container">
      <div class="row">
        <div class="col-lg-3  col-md-6 col-sm-6">
          <?php if ( ! dynamic_sidebar('sidebar-footer_text') ) :
              dynamic_sidebar( 'sidebar-footer_text' );
            endif; ?>
        </div>
        <div class="col-lg-4  col-md-6 col-sm-6">
          <div class="single-footer-widget">
            <h6>Подписаться</h6>
            <p>Читай первым новые статьи</p>
            <div class="" id="mc_embed_signup">
              <?php echo do_shortcode( '[contact-form-7 id="211" title="Форма подписки в футере"]' )?>
            </div>
          </div>
        </div>
        
        <div class="col-lg-3  col-md-6 col-sm-6">
           <?php if ( ! dynamic_sidebar('sidebar-footer_foto') ) :
              dynamic_sidebar( 'sidebar-footer_foto' );
            endif; ?>
        </div>
        
        <!-- social-icons -->
        <div class="col-lg-2 col-md-6 col-sm-6">
          <div class="single-footer-widget">
            <h6>Follow Us</h6>
            <p>Let us be social</p>
            <div class="footer-social d-flex align-items-center">
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
							<a href="<?php the_field('soc_link'); ?>">
								<?php the_field('soc_icon'); ?>
							</a>
						  
						<?php 
						}
					}
					wp_reset_postdata(); // Сбрасываем $post
              	?>
            </div>
          </div>
        </div>
      </div>
      <div class="footer-bottom d-flex justify-content-center align-items-center flex-wrap">
        <p class="footer-text m-0"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
      </div>
    </div>
  </footer>
  <!--================ End Footer Area =================-->

  <?php wp_footer(); ?>
</body>
</html>