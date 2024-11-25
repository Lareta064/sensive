 <aside class="col-lg-4 sidebar-widgets">
	<div class="widget-wrap">

		<!-- форма поиска -->
		<div class="single-sidebar-widget newsletter-widget">
			<?php get_search_form( )?>
		</div>
        <!-- список категорий -->
		<div class="single-sidebar-widget post-category-widget">
			<h4 class="single-sidebar-widget__title">Рубрики</h4>
		
			<ul class="cat-list mt-20">
				<?php 
				
				$args = array(
					'show_option_all'    => '',
					'show_option_none'   => __('No categories'),
					'orderby'            => 'name',
					'order'              => 'ASC',
					'style'              => 'list',
					'show_count'         => 1,
					'hide_empty'         => 1,
					'use_desc_for_title' => 1,
					'child_of'           => 0,
					'feed'               => '',
					'feed_type'          => '',
					'feed_image'         => '',
					'exclude'            => '',
					'exclude_tree'       => '',
					'include'            => '',
					'hierarchical'       => true,
					'title_li'           => '',
					'number'             => NULL,
					'echo'               => 1,
					'depth'              => 0,
					'current_category'   => 0,
					'pad_counts'         => 0,
					'taxonomy'           => 'category',
					'walker'             => 'Walker_Category',
					'hide_title_if_empty' => false,
					'separator'          => '<br/>',
				);
				wp_list_categories( $args); 
				?>
			</ul>
		</div>

		<!-- карточки Популярное -->
		<div class="single-sidebar-widget popular-post-widget">
			<h4 class="single-sidebar-widget__title">Популярные</h4>
			<div class="popular-post-list">
			
			<?php
				
				$time = "&monthnum=".date("m"); // За месяц
				$sort = "DESC"; // Порядок сортировки
				$numb = "3"; // Количество записей для вывода
				
				query_posts("post_type=post&posts_per_page=".$numb."&orderby=comment_count&order=".$sort."&year=".date("Y").$time);
			
				while (have_posts()): the_post();
				
			?>
			
				<div class="single-post-list">
					<div class="thumb">
						<img class="card-img rounded-0" src="<?php  echo  get_the_post_thumbnail_url() ;  ?>" alt="">
						<ul class="thumb-info">
						<li><a href="<?php echo get_author_posts_url( get_the_author_meta('ID'))?>"><?php  the_author(); ?></a></li>
						<li><a href="<?php 
                          $archive_year  = get_the_time( 'Y' ); 
                          $archive_month = get_the_time( 'm' ); 
                          $archive_day   = get_the_time( 'd' ); 
                          echo esc_url( get_day_link( $archive_year, $archive_month, $archive_day ) ); 
                          ?>" ><? the_time('M j'); ?></a></li>
						</ul>
					</div>
					<div class="details mt-20">
						<a href="<?php the_permalink(); ?>">
						<h6><?php  the_title(); ?></h6>
						</a>
					</div>
				</div>

			<?php
				
				endwhile;
				wp_reset_query();
			
			?>
		    </div>
		</div>
		 
		<!-- список метки -->
		<div class="single-sidebar-widget tag_cloud_widget">
			<h4 class="single-sidebar-widget__title">Tags</h4>
			<?php
				if ( function_exists('wp_tag_cloud') ){
					wp_tag_cloud("smallest=14&largest=14&unit='px'");
				}
				?>
		</div>
		
	</div>
	
<!-- End Blog Post Siddebar -->
</aside>