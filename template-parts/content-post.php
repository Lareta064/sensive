<div class="main_blog_details">
	<img class="img-fluid mb-3" src="<?php  echo  get_the_post_thumbnail_url() ;  ?>" alt="img">
	<!-- <a href="#"><h4><?php the_title(); ?></h4></a> -->
	<div class="user_details">
		<div class="float-left">
			<?php
			if($tags = get_the_tags($post->ID)){
				foreach($tags as $tag){?>
					<a href="
					
					<?php 
					echo('/tag/'.$tag->slug); 
					?>"> <?php echo($tag->name);?> </a>
				<?php }
			}
			
			 ?>
		</div>
		
		<div class="float-right mt-sm-0 mt-3">
			<div class="media">
				<div class="media-body">
					<h5><?php the_author(); ?></h5>
					<p><?php the_time('M j g:i');?></p>
				</div>
				<div class="d-flex">
					<img width="42" height="42" src="<?php the_field('author_picture');?>" alt="img">
				</div>
			</div>
		</div>
	</div>
	<div class="post-content__wrapper">
		
		<?php the_content(); ?>
	</div>
		
	<div class="news_d_footer flex-column flex-sm-row">
		<span class="mr-2"><i class="ti-themify-favicon"></i></span><?php echo get_comments_number(); ?> комментариев
		<div class="news_socail ml-sm-auto mt-sm-0 mt-2">
			<ul class="d-flex">
				<?php echo get_template_part( 'template-parts/content', 'social'); ?>
			</ul>
		</div>
	</div>
</div>
	<!-- //main_blog_details -->


