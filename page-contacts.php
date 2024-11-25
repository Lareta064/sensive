<?php
 	/*Template name: Шаблон страницы Контакты*/
	get_header(); ?>

  <!--================ Hero sm banner start =================-->  
  <section class="mb-30px">
    <div class="container">
      <div class="hero-banner hero-banner--sm"
          style="background: url(
            <?php
                if(has_post_thumbnail()){
                  the_post_thumbnail_url( );
                }  
            ?>) no-repeat center / cover">
        <div class="hero-banner__content">
          <h1 class="slider__title"
              <?php
                $titleColor = get_field('bg_color');
                if($titleColor == 'Light'):
                ?>
                  style="color: #1b1b1b;"													
                <?php
                endif;
              ?> >
              <?php the_title(); ?>
            </h1>
          <nav aria-label="breadcrumb" class="banner-breadcrumb">
             <?php if( function_exists('kama_breadcrumbs') ) kama_breadcrumbs(' — '); ?>
            <!-- <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
            </ol> -->
          </nav>
        </div>
      </div>
    </div>
  </section>
  <!--================ Hero sm banner end =================-->  


  <!-- ================ contact section start ================= -->
  <section class="section-margin--small section-margin">
    <div class="container">
      <div class="d-none d-sm-block mb-5 pb-4">
        <div id="map" style="height: 420px;">        
        <?php the_content(); ?>
      </div>
      </div>

      <div class="row">
        <div class="col-md-4 col-lg-3 mb-4 mb-md-0">
          <div class="media contact-info">
            <span class="contact-info__icon"><i class="ti-home"></i></span>
            <div class="media-body">
              <h3><?php the_field('address_city', $post->ID);?></h3>
              <p><?php the_field('address_street', $post->ID);?></p>
            </div>
          </div>
          <div class="media contact-info">
            <span class="contact-info__icon"><i class="ti-headphone"></i></span>
            <div class="media-body">
              <?php 
                $phone = get_field('phone_number');
                $phoneLink = preg_replace('/[^0-9]/', '', $phone);
              ?>
              <h3><a href="tel:<?php echo $phoneLink ?>"><?php the_field('phone_number', $post->ID); ?></a></h3>
              <p>Звонитес 9ч до 18ч</p>
            </div>
          </div>
          <div class="media contact-info">
            <span class="contact-info__icon"><i class="ti-email"></i></span>
            <div class="media-body">
              <h3><a href="mailto:support@colorlib.com"><?php the_field('email_field', $post->ID); ?></a></h3>
              <p>Пишите нам</p>
            </div>
          </div>
        </div>
        <div class="col-md-8 col-lg-9">
           <div class="form-contact">
            <?php echo do_shortcode( '[contact-form-7 id="210" title="Контактная форма 1"]');?>
          </div>
        </div>
      </div>
    </div>
  </section>
	<!-- ================ contact section end ================= -->

<?php get_footer(); ?>